<?php
defined('PHP168_PATH') or die();

/**
http://special.php168.com[/index.php]/-view-id-11.html
http://special.php168.com/2010/11/23/iron_man.html
**/
class P8_Special extends P8_Module{

var $table;
var $category;
var $_categories;

function P8_Special(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->category = new P8_Special_Category($this);
}

function add(&$data){
	
	$data = $this->DB_master->escape_string($data);
	
	return $this->DB_master->insert(
		$this->table, 
		$data,
		array('return_id' => true)
	);
}

function update($id, &$data){
	
	$data = $this->DB_master->escape_string($data);
	
	return $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
}

function cache(){
	parent::cache();
	$this->category->cache();

}

function delete($id){
	
	$where = " id IN(".implode(",",$id).")";
	
	if($this->DB_master->delete($this->table, $where)){
		//ɾ����Ӧ�ı�ǩ
		$label = &$this->core->load_module('label');
		foreach($id as $v){
			$label->delete(array(
				'where' => "system = 'core' AND module = 'special' AND postfix = 'sp_$v'"
			));
		}
		
		return $id;
	}
	
	return  array();
}
function fetch_item($cid,$option){
	$select = select();
	$select->from($this->table .' AS i', 'i.id,i.cid,i.title,i.frame,i.title,i.html_view_url_rule,i.description,i.banner');
	$select->in('i.cid',$cid);
	$select->order('i.timestamp');
	$list = $this->core->list_item(
			$select,
			$option
	);
	$this->category->get_cache();
	foreach($list as $k => $v){
		$list[$k]['url'] = p8_url($this, $v, 'view');
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['banner'] = attachment_url($v['banner']);
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['summary'] =$list[$k]['description'] = p8_cutstr($v['description'], 300, '');
	
	}
	return $list;
	
}

function label(&$LABEL, &$label, &$var){

	$option = &$label['option'];
	
	$select = select();
	$select->from($this->table .' AS i', 'i.*');
	
	//����
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}
	
	if(empty($option['ids'])){
		
		//����
		if(!empty($option['category'])){
			$select->in('i.cid', $option['category']);
		}
		
		//��ǰҳ��
		$page = 0;
		//�ܼ�¼��
		$count = 0;
		$page_size = $option['limit'];
		
		
		//ȡ������
		$list = $this->core->list_item(
			$select,
			array(
				'page' => &$page,
				'page_size' => $page_size,
				'count' => &$count,
				'sphinx' => $option['sphinx']
			)
		);
		
	}else{
		//ָ��ID,�����ҳ,��ʹ��sphinx
		$select->in('i.id', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0
			)
		);
		
		$tmp = array_combine($option['ids'], $c);
		foreach($list as $v){
			$tmp[$v['id']] = $v;
		}
		
		$list = array_values($tmp);
	}
	$this->category->get_cache();
	
	//����URL
	foreach($list as $k => $v){
		$list[$k]['url'] = p8_url($this, $v, 'view');
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['banner'] = attachment_url($v['banner']);
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
		$list[$k]['summary'] =$list[$k]['description'] = p8_cutstr($v['description'], $option['summary_length'], '');
		//��������
		$list[$k]['category_name'] = $this->category->categories[$v['cid']]['name'];
		//����URL
		$list[$k]['category_url'] = $this->category->categories[$v['cid']]['url'];
	}
	
	//�����
	$rand = rand_str(4);
	//ÿ�еĿ��,���ڶ���
	$wf ='';
	$width = isset($option['rows']) && $option['rows'] > 1 ? (100/$option['rows']-1).'%' : '99%';
	if($width!='99%'){
		$wf = "width:$width;float:left;margin-right:1%";
	}
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
	
	return isset($pages) ? array($content, $pages) : array($content);
}

}

































class P8_Special_Category{

var $sp_mod;
var $core;
var $table;
var $data;
var $categories;
var $top_categories;

function P8_Special_Category(&$sp_mod){
	$this->sp_mod = &$sp_mod;
	$this->core = &$this->sp_mod->core;
	
	$this->table = $this->sp_mod->TABLE_ .'category';
}

function add(&$data){
	return $this->sp_mod->DB_master->insert($this->table, $data, array('return_id' => true));
}

function update($id, &$data){
	return $this->sp_mod->DB_master->update($this->table, $data, "id = '$id'");
}

function get_cache($read_cache = true){
	if(!empty($this->categories)) return;
	
	global $CACHE;
	
	if(
		$read_cache &&
		$this->data = $CACHE->read(
			$this->sp_mod->system->name .'/modules',
			$this->sp_mod->name,
			'categories',
			'serialize'
		)
	){
		$this->categories = &$this->data['categories'];
		$this->top_categories = &$this->data['top_categories'];
	}else{
		$this->cache(false, false);
	}
}

/**
* ȡ�û����JSON
**/
function get_json(){
	global $CACHE;
	$json = $CACHE->read($this->sp_mod->system->name .'/modules', $this->sp_mod->name, 'category_json');
	return array(
		'json' => empty($json['json']) ? '{}' : $json['json'],
		'path' => empty($json['path']) ? '{}' : $json['path'],
	);
}

function cache($cache_all = true, $write_cache = true, $id = 0){
	
	return include $this->sp_mod->path .'call/cache_category.call.php';
}

/**
* ���·����ר����
* @param int $id ����ID
* @param int $num ���µ�����
**/
function update_count($id, $num){
	$this->get_cache();
	if(empty($this->categories[$id]) || empty($num)) return false;
	
	$ids = $id;
	//����и�����ͬʱ���¸�����
	if($parents = $this->get_parents($id)){
		$ids = '';
		foreach($parents as $v){
			$ids .= ',' . $v['id'];
		}
		$ids = $id . $ids;
	}
	
	return $this->sp_mod->DB_master->update(
		$this->table,
		array(
			'item_count' => 'item_count + '. $num
		),
		"id IN ($ids)",
		false
	);
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

function delete($option){
	
	$query = $this->sp_mod->DB_master->query("SELECT id FROM $this->table WHERE $option");
	$id = array();
	$this->get_cache();
	while($arr = $this->sp_mod->DB_master->fetch_array($query)){
		$id[] = $arr['id'];
		//��ͬ�ӷ���һ��ɾ��
		$cids = $this->get_children_ids($arr['id']);
		$id = array_merge($id, $cids);
	}
	
	$ids = implode(',', $id);
	$status = $this->sp_mod->DB_master->delete($this->table, "id IN ($ids)");
	return $status ? $id : array();

}
function fetch_category($id, $refresh = false){
	if(isset($this->_categories[$id]) && !$refresh){
		return $this->_categories[$id];
	}else{
		return $this->_categories[$id] = $this->core->CACHE->read($this->name .'/modules', 'category', (int)$id, 'serialize');
	}
}
}