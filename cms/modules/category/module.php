<?php
defined('PHP168_PATH') or die();

/**
* ��������
* 1 ֻ��һ��ҳ��ķ���,ͨ��������Ƶ��ҳ,�����������
* 2 �б����,�����������,���԰����ӷ��������
**/

class P8_CMS_Category extends P8_Module{

var $table;
var $categories;		//�ܷ���,�ⲿ����ֱ�Ӵ���id $obj->categories[$id] ֱ�ӵõ���Ӧ�ķ���,������ķ��������ĸ�������,������ֱ�ӻ�����ӷ���ڵ�
var $top_categories;	//��������,��������������,�������������ӷ�������νṹ����
var $data;
var $_category;

function __construct(&$system, $name){
	$this->configurable = false;	//������
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->system->TABLE_ .'category';
	$this->_category = array();
}

function P8_CMS_Category(&$system, $name){
	$this->__construct($system, $name);
}

/**
* ���һ������
* @param string $name ��������
* @param int $parent ������ID
* @param int $display_order ����
**/
function add(&$data){
	$this->get_cache();
	
	
	if($data['type'] != 3){
		$ext = empty($this->core->CONFIG['ssi']) ? 'html' : 'shtml';
		
		empty($data['html_list_url_rule']) && $data['html_list_url_rule'] = '{$core_url}/html/{$id}/#list-{$page}.'. $ext .'#';
		empty($data['html_view_url_rule']) && $data['html_view_url_rule'] = '{$core_url}/html/{$cid}/{$Y}-{$m}-{$d}/content-{$id}#-{$page}#.'. $ext;
		
		empty($data['html_list_url_rule_mobile']) && $data['html_list_url_rule_mobile'] = '{$core_m_url}/{$id}/#list-{$page}.'. $ext .'#';
		empty($data['html_view_url_rule_mobile']) && $data['html_view_url_rule_mobile'] = '{$core_m_url}/{$cid}/{$Y}-{$m}-{$d}/content-{$id}#-{$page}#.'. $ext;
		
		empty($data['list_template']) && $data['list_template'] = $data['model'] .'/list';
		empty($data['view_template']) && $data['view_template'] = $data['model'] .'/view';
		empty($data['item_template']) && $data['item_template'] = 'common/ico_title/dot_title';
		
		empty($data['list_template_mobile']) && $data['list_template_mobile'] = $data['model'] .'/list_mobile';
		empty($data['view_template_mobile']) && $data['view_template_mobile'] = $data['model'] .'/view_mobile';
		empty($data['item_template_mobile']) && $data['item_template_mobile'] = 'mobile/title';
	}
	$auto_label_postfix = $data['auto_label_postfix'];
	unset($data['auto_label_postfix']);
	if(
		$id = $this->DB_master->insert(
			$this->table,
			$data,
			array('return_id' => true)
		)
	){
		if(!$auto_label_postfix && !empty($data['label_postfix'])){
			$d['label_postfix'] = 'category_'. $id;
			
			$this->DB_master->update($this->table, $d, "id = '$id'");
		}
		if($data['type'] == 1 && empty($data['label_postfix'])){
			//��������Լ��ı�ǩ��׺
			$d['label_postfix'] = 'category_'. $id;
			
			//$this->DB_master->update($this->table, $d, "id = '$id'");
		}
		
		//if(!empty($data['path']))
			//md($this->system->path . $data['path']);
	}
	return $id;
}

/**
* ����һ������
* ����ͬadd
**/
function update($id, &$data, &$orig_data){
	return include $this->path .'call/update.call.php';
}

/**
* �ϲ���Ŀ
* @param array $ids ���ϲ�����Ŀ(����)
* @param int $to_id �ϲ�������Ŀ
* @return bool
**/
function merge($ids, $to_id){
	return include $this->path .'call/merge.call.php';
}
/**
* ��¡��Ŀ
* @param array $ids ���ϲ�����Ŀ(����)
* @param int $to_id �ϲ�������Ŀ
* @return bool
**/
function clonecat($id, $to_id){
	$this->get_cache();
	$id = intval($id);
	$_ids = $comma = '';
	$cates = $this->categories[$id];
	if(!$cates)return false;

	$this->exec_clone(array($id=>$cates),$to_id);
	$this->cache();
}

function exec_clone($cates,$to_id){

	foreach($cates as $cid=>$cd){
		
		$query = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id=$cid");
		$files = array('name','url','type','list_all_model','domain','model','path','letter','htmlize','html_list_url_rule',
		'html_view_url_rule','list_template','view_template','item_template','list_template_mobile','view_template_mobile',
		'item_template_mobile','frame','display_order','page_size','seo_keywords','seo_description','label_postfix','auto_label_postfix','config');
		$data = array('id' => 0,'parent' => $to_id,);
		
		foreach($files as $file){
			$data[$file] = $query[$file];
		}
	
		$id = $this->add($data);
		
		if($cd['categories']){
			$this->exec_clone($cd['categories'],$id);
		}
	
	}

}

/**
* ���·������Ŀ��
* @param int $id �����ID
* @param int $num ����
**/
function update_count($id, $num){

	$this->get_cache();
	
	if(
		empty($this->categories[$id]) || empty($num) ||
		!($cat = $this->system->fetch_category($id, true))
	) return false;
	
	$cat['item_count'] += $num;
	$this->core->CACHE->write($this->system->name .'/modules/', $this->name, (int)$id, $cat, 'serialize');
	
	$ids = $id;
	//����и�����ͬʱ���¸�����
	if($parents = $this->get_parents($id)){
		$ids = '';
		foreach($parents as $v){
			if($v['model'] != $cat['model']) continue;	//ģ�Ͳ���ͬ
			
			$ids .= ',' . $v['id'];
			
			$cat = $this->system->fetch_category($v['id'], true);
			$cat['item_count'] += $num;
			$this->core->CACHE->write($this->system->name .'/modules/', $this->name, (int)$v['id'], $cat, 'serialize');
		}
		$ids = $id . $ids;
	}
	
	return $this->DB_master->update(
		$this->table,
		array(
			'item_count' => 'item_count + '. $num
		),
		"id IN ($ids)",
		false
	);
}

/**
* ɾ������
* @param array $data ɾ��������
* @return array ��ɾ����ID
**/
function delete($data){
	return include $this->path .'call/delete.call.php';
}

/**
* ȡ��һ����������ݻ���
* 
**/
function &fetch_one($id, $refresh = false){
	
	if($refresh){
		$this->system->_category[$id] = $this->core->CACHE->read($this->system->name .'/modules/', $this->name, (int)$id);
		
		return $this->system->_category[$id];
	}else{
		if(empty($this->system->_category[$id])){
			$this->system->_category[$id] = $this->core->CACHE->read($this->system->name .'/modules/', $this->name, (int)$id);
		}
		
		return $this->system->_category[$id];
	}
}

function get_cache($read_cache = true){
	if(!empty($this->categories)) return;
	
	if(
		$read_cache &&
		$this->data = $this->core->CACHE->read(
			$this->system->name .'/modules',
			$this->name,
			'categories',
			'serialize'
		)
	){
		$this->categories = &$this->data['categories'];
		$this->top_categories = &$this->data['top_categories'];
		if(empty($this->categories) or empty($this->top_categories)){
			$this->cache(false, false);
			$this->categories = &$this->data['categories'];
			$this->top_categories = &$this->data['top_categories'];
		}
	}else{
		$this->cache(false, false);
	}
}

/**
* ȡ�û����JSON
**/
function get_json(){
	$json = $this->core->CACHE->read($this->system->name .'/modules', $this->name, 'json');
	return array(
		'json' => empty($json['json']) ? '{}' : $json['json'],
		'path' => empty($json['path']) ? '{}' : $json['path'],
	);
}

function make_json_sort($data){
	$return = array();
	if(!is_array($data))return $return;
	foreach($data as $k=>$v){
		if(!empty($v['categories'])){
			$v['categories']=$this->make_json_sort($v['categories']);
		}
		$return[]=$v;
	}

	return $return;

}

/**
* ���ɻ���
* @param string $model ָ��ģ��,�����ָ��������������ģ�͵ķ���
* @param bool $cache_all �Ƿ��ÿ�����඼�����һ�������ļ�
* @param bool $list_cache �Ƿ�д����,�����,��д����,�������νṹ,����ʵʱˢ��
* @param array $ids ֻ����ķ����ID��ϣ array(id1 => 1, id2 => 1 ...)
**/
function cache($cache_all = true, $list_cache = true, $ids = array()){
	parent::cache();
	
	return include $this->path .'call/cache.call.php';
}

/**
* ȡ�÷�������и����������
* @param int $id ����ID
**/
function get_parents($id){
	if(!isset($this->categories[$id])) return array();
	
	$p = $this->categories[$id]['parent'];
	$ps = array();
	while($p){
		array_unshift($ps, $this->categories[$p]);
		unset($ps[0]['categories']);
		$p = $this->categories[$p]['parent'];
	}
	return $ps;
}

/**
* ȡ�÷���������ӷ����ID
* @param int $id ����ID
**/
function get_children_ids($id){
	if(empty($this->categories[$id]['categories'])) return array();
	
	$ids = array();
	foreach($this->categories[$id]['categories'] as $v){
		$ids[$v['id']] = $v['id'];
		if(isset($v['categories']))
			$ids = $ids + $this->get_children_ids($v['id']);
	}
	
	return $ids;
}
/**
*ȡ�÷��������ͬ������
*@param int $id ����ID
**/
function get_siblings($id){
	$p = $this->categories[$id]['parent'];
	$siblings = array();
	if(!$p)
		$siblings = $this->top_categories;
	elseif(isset($this->categories[$p]['categories']))
		$siblings = $this->categories[$p]['categories'];
	return $siblings;
}
function label($LABEL, &$label, &$var){
	$this->get_cache();
	
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return array($content);
}
	
}