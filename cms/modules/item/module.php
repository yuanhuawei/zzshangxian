<?php
defined('PHP168_PATH') or die();

class P8_CMS_Item extends P8_Module{

var $model;				//��ǰģ��
var $table;				//���ݱ�
var $main_table;		//����
var $unverified_table;	//δ�������
var $addon_table;		//׷�����ݱ�
var $collection_table;	//�ղ����ݱ�
var $member_table;		//��Ա��
var $search_table;		//������
var $attributes;		//����
var $attribute_table;	//���Ա�
var $tag_table;
var $tag_item_table;
var $order_table;
var $delimiter;			//�Զ����ֶ��зָ��,�����ݺ�Ҫ�����޸�,ascii bel
var $col_delimiter;		//�Զ����ֶ��зָ��,�����ݺ�Ҫ�����޸�,ascii ack
var $_categories;
var $_html;

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->main_table = $this->system->TABLE_ .'item';
	$this->unverified_table = $this->TABLE_ .'unverified';
	$this->search_table = $this->TABLE_ .'search';
	$this->attribute_table = $this->TABLE_ .'attribute';
	$this->member_table = $this->TABLE_ .'member';
	$this->tag_table = $this->TABLE_ .'tag';
	$this->tag_item_table = $this->TABLE_ .'tag_item';
	$this->collection_table = $this->member_table .'_collection';
	$this->order_table = $this->system->TABLE_ .'order';
	$this->delimiter = chr(7);
	$this->col_delimiter = chr(6);
	$this->_html = array();
	
	$this->attributes = array(
		1 => 'cms_item_attribute_1',
		2 => 'cms_item_attribute_2',
		3 => 'cms_item_attribute_3',
		4 => 'cms_item_attribute_4',
		5 => 'cms_item_attribute_5',
		6 => 'cms_item_attribute_6',
		7 => 'cms_item_attribute_7',
		8 => 'cms_item_attribute_8',
		//more attributes
	);
	
	$this->_categories = array();
}

function P8_CMS_Item(&$system, $name){
	$this->__construct($system, $name);
}

/**
* ���õ�ǰģ��
* @param string $name ģ������
**/
function set_model($name){
	$this->model = $name;
	
	$this->table = $this->TABLE_ . $name .'_';
	$this->addon_table = $this->TABLE_ . $name .'_addon';
}

/**
* ȡ�����ݵļ������
**/
function data($act, $data){
	
	if($act == 'read'){
		$sql = 'SELECT id, uid, model, cid, pages, allow_comment, credit, credit_type, html_view_url_rule, url FROM '. $this->main_table .' WHERE id = \''. $data .'\'';
		
		//��ȡ
		if($this->core->CACHE->memcache){
			$ret = $this->core->CACHE->memcache_read($this->system->name .'_item_'. $data);
			if(!$ret && $ret = $this->DB_slave->fetch_one($sql)){
				$this->core->CACHE->memcache_write($this->system->name .'_item_'. $data, $ret);
			}
		}else{
			$ret = $this->DB_slave->fetch_one($sql);
		}
		return $ret;
	}else if($act == 'write' && $this->core->CACHE->memcache){
		//д��
		$d = array(
			'id' => $data['id'],
			'uid' => $data['uid'],
			'cid' => $data['cid'],
			'model' => $data['model'],
			'pages' => $data['pages'],
			'allow_comment' => $data['allow_comment'],
			'credit' => $data['credit'],
			'credit_type' => $data['credit_type'],
			'html_view_url_rule' => $data['html_view_url_rule']
		);
		$this->core->CACHE->memcache_write($this->system->name .'_item_'. $data['id'], $d);
	}else if($act == 'delete' && $this->core->CACHE->memcache){
		$this->core->CACHE->memcache_delete($this->system->name .'_item_'. $data);
	}
}

/**
* ���һ������
**/
function add(&$data){
	return include $this->path .'call/add.call.php';
}

/**
* �޸�һ������
**/
function update($id, &$data, &$orig_data, $verified = true){
	return include $this->path .'call/update.call.php';
}

/**
* ׷������
**/
function addon(&$data){
	return include $this->path .'call/addon.call.php';
}

/**
* �༭׷������
**/
function update_addon(&$data, &$orig_data){
	return include $this->path .'call/update_addon.call.php';
}

/**
* ɾ��׷������
**/
function delete_addon($data){
	return include $this->path .'call/delete_addon.call.php';
}

/**
* ��֤����
**/
function verify($data){
	return include $this->path .'call/verify.call.php';
}

/**
* ɾ����¼
* @param array $data Ҫɾ��������
* @return array ��ɾ����ID
**/
function delete($data){
	
	return include $this->path .'call/delete.call.php';
}

/**
* �ҹ�ɾ��
**/
function hook_delete(&$obj, $cond){
	$orig_model = $this->model;
	
	//����˵�����
	$this->delete(array(
		'where' => str_replace('#module_table#', $this->main_table, $cond),
		'hook' => true
	));
	
	//δ��˵�����
	$this->delete(array(
		'where' => str_replace('#module_table#', $this->unverified_table, $cond),
		'verified' => 0,
		'hook' => true
	));
	
	$this->model = $orig_model;
}

/**
* �ƶ�����
* @param array $id Ҫ�ƶ�������ID
* @param int $cid Ҫ�ƶ����ķ���ID
* @return bool
**/
function move($id, $cid, $verified = true){
	return include $this->path .'call/move.call.php';
}

/**
* ���Ƶ�����
* @param array $id Ҫ�ƶ�������ID
* @param int $cid Ҫ�ƶ����ķ���ID
* @return bool
**/
function cloneitem($id, $cid, $verified = true, $clone_time=''){
	return include $this->path .'call/clone.call.php';
}

function list_order($id, $timestamp){
	return include $this->path .'call/list_order.call.php';
}

/**
* Ϊһ�������������
* @param string $attributes ���� 1,2,3
* @param int $id ����ID
* @param int $cid ����ID
**/
function add_attribute($attributes, $id, $cid){
	return include $this->path .'call/add_attribute.call.php';
}

/**
* ��ʽ������
* @param array $data
**/
function format_data(&$data){
	//����
	$data['frame'] = isset($data['frame']) ? attachment_url($data['frame']) : '';
	$data['addon_frame'] = isset($data['addon_frame']) ? attachment_url($data['addon_frame']) : '';
	//��Դ��ַ
	if(isset($data['source'])){
		$tmp = explode('|', $data['source']);
		$data['source_name'] = $tmp[0];
		$data['source_url'] = isset($tmp[1]) ? $tmp[1] : '';
	}
	$data['summary'] = preg_replace('/(amp;)+/','', $data['summary']);
	global $this_model;
	foreach($this_model['fields'] as $field => $v){
		
		if(!isset($data[$field])) continue;
		
		switch($v['widget']){
		
		//�ָ��ѡ��
		case 'checkbox':
		case 'multi_select':
			$tmp = explode($this->delimiter, $data[$field]);
			$data[$field] = array();
			foreach($tmp as $vv){
				foreach($v['data'] as $value => $key){
					if($vv == $value) $data[$field][$value] = $value;
				}
			}
			unset($tmp);
		break;
		
		//�ϴ���,�༭��Ҫ�Ը�����ַ����
		case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
			$data[$field] = attachment_url($data[$field]);
		break;
		
		case 'uploader':case 'image_uploader':
			$tmp = explode($this->delimiter, attachment_url($data[$field]));
			$data[$field] = array(
				'title' => $tmp[0],
				'url' => isset($tmp[1]) ? $tmp[1] : '',
				'thumb' => isset($tmp[2]) ? $tmp[2] : ''
			);
		break;
		
		//���ϴ���
		case 'multi_uploader':
			$tmp = explode($this->delimiter, attachment_url($data[$field]));
			
			$data[$field] = array();
			foreach($tmp as $v){
				$v = explode($this->col_delimiter, $v);
				$data[$field][] = array(
					'title' => $v[0],
					'url' => isset($v[1]) ? $v[1] : '',
					'thumb' => isset($v[2]) ? $v[2] : ''
				);
			}
			unset($tmp);
		break;
		case 'link':
			$linktemp = explode('|', $data[$field]);
			$data[$field] = array('txt'=>$linktemp[0], 'url'=>$linktemp[1]);
			!empty($linktemp[2]) && $data[$field]['target']=$linktemp[2];
		break;
		}
	}
	
}

function fetch_category($id){
	if(isset($this->_categories[$id])){
		return $this->_categories[$id];
	}else{
		return $this->_categories[$id] = $this->core->CACHE->read($this->system->name .'/modules', 'category', (int)$id);
	}
}

/**
* ��������ҳ��̬
**/
function html(&$query){
	return include $this->path .'call/html.call.php';
}

/**
* �����б�ҳ��̬
**/
function html_list($dcid,$mobile=false){
	return include $this->path .'call/html_list.call.php';
}

function get_tag($str, $return_id = false){
	$ret = array('array' => array(), 'tag_id' => array(), 'tag' => array());
	$sql = $comma = ''; $i = 1;
	foreach(explode(',', $str) as $v){
		if(strlen($v = trim($v)) == 0) continue;
		if($i > 5) break;
		
		$ret['array'][] = $v;
		$sql .= $comma . '\''. $v. '\''; $comma = ',';
		$i++;
	}
	if(empty($ret['array'])) return $ret;
	
	if($return_id){
		$query = $this->DB_slave->query("SELECT id, name, item_count FROM $this->tag_table WHERE name IN ($sql)");
		while($arr = $this->DB_slave->fetch_array($query)){
			$ret['tag_id'][$arr['name']] = $arr['id'];
			$ret['tag'][$arr['name']] = $arr;
		}
	}
	
	return $ret;
}

/**
* ��ӱ�ǩ(tag)
* @param string $str Ҫ��ӵ��ַ���,�ָ�. tag1,tag2
* @param int $iid tagged������id
* @param string $action ��ӻ��������
**/
function add_tag($str, $iid, $action = 'add'){
	if(strlen($str) == 0) return false;
	
	return include $this->path .'call/add_tag.call.php';
}

/**
* ����
**/
function cache(){
	parent::cache();
	
	return include $this->path .'call/cache.call.php';
}


/**
* ���ɼ�Ⱥʹ�õ�����
* @param array $id Ҫ�������ݵ�����ID
* @param int $cid Ҫ���͵�Զ�̵ķ���ID
* @return array
**/
function cluster_data($id, $cid){
	return include $this->path .'call/cluster_data.call.php';
}

function sites_data($id, $cid, $push_site, $send_time_type, $send_time){
	return include $this->path .'call/sites_data.call.php';
}

function add_order($data){

	$pay = $this->core->load_module('pay');
	if($sdata = $pay->order($data)){
		$data['NO'] = $sdata['NO'];
		$status = $this->DB_master->insert(
			$this->order_table,
			$this->DB_master->escape_string($data),
			array('return_id' => true)
		);
		return $sdata;
	}
}



















/**
* ��ǩ���õ�����, �ӿ�
* @param array $LABEL ��ǩģ��
* @param array $label ��ǩ����
* @param array $var ����
**/
function label(&$LABEL, &$label, &$var){
	
	$option = &$label['option'];
	
	$orig_model = $this->model;
	if(!empty($var['model'])){
		//���������
		$model = $var['model'];
	}else if(!empty($option['model'])){
		$model = $option['model'];
	}
	
	if(!empty($model)){
		$this->set_model($model);
		
		//��ǰģ��
		$this_model = &$this->system->get_model($model);
		
		$table = $this->table;
		
		$sphinx_indexes = $this->system->sphinx_indexes(array($model => 1));
		
		$fields = 'i.*';
	}else{
		$table = $this->main_table;
		
		$sphinx_indexes = $this->system->sphinx_indexes();
		
		$fields = 'i.id, i.model, i.title, i.title_color, i.title_bold, i.sub_title, i.cid, i.frame, i.url, i.uid, i.username, i.attributes, i.summary, i.html_view_url_rule, i.views, i.comments, i.timestamp, i.list_order';
	}
	
	$category = &$this->system->load_module('category');
	$category->get_cache();
	
	$select = select();
	
	if(empty($option['ids'])){
		
		$sphinx = $this->CONFIG['sphinx'];
		$sphinx['index'] = $sphinx_indexes;
		
		if(!empty($option['attribute'])){
			//������,ȡ��sphinx
			$select->from($table .' AS i', $fields);
			$select->inner_join($this->attribute_table .' AS a', '', 'a.id = i.id');
			$select->in('a.aid', $option['attribute']);
			$sphinx['enabled'] = 0;
			
		}else{
			$select->from($table .' AS i', $fields);
		}
		
		//ʱ������
		$select->range(
			'i.timestamp',
			empty($option['timestamp'][0]) ? null : strtotime($option['timestamp'][0]),
			empty($option['timestamp'][1]) ? null : strtotime($option['timestamp'][1]),
			!empty($option['timestamp']['exclude'])
		);
		
		//����
		if(!empty($option['category'])){
			//���������,ʹ�����Ե��ֶ�����Ϊ����
			
			$cats = $option['category'];
			if(!empty($option['include_sub_category'])){
				foreach($option['category'] as $v){
					$cats = array_merge($category->get_children_ids($v));
				}
			}
			
			$select->in(empty($option['attribute']) ? 'i.cid' : 'a.cid', $cats);
		}
		
		//�û�ID
		if(!empty($option['uids'])){
			$select->in('i.uid', $option['uids']);
		}
		
		//�����ؼ���
		if(!empty($option['keyword'])){
			/*if(!empty($option['keyword_tag'])){*/
				$tag = $this->get_tag($option['keyword'], true);
				
				if($tag['tag_id']){
					$select->inner_join($this->tag_item_table .' AS ti', '', 'ti.iid = i.id');
					$select->in('ti.tid', $tag['tag_id']);
					$select->distinct();
				}
			/*}else{
				$select->search('i.title', $option['keyword']);
			}*/
		}
		
		foreach($option['field#'] as $field => $v){
			$exclude = empty($v['exclude']) ? false : true;
			switch($v['op']){
			
			case 'in':
				$select->in('i.'. $field, $v['value'], $exclude);
			break;
			
			case 'range':
				$select->in('i.'. $field, $v[0], $v[1], $exclude);
			break;
			
			case 'search':
				$select->like('i.'. $field, $v['value'], 'all', $exclude);
			break;
			
			}
		}
		
		//����
		if(!empty($option['order_by_string'])){
			if(array_key_exists('d.digg',$option['order_by']) || array_key_exists('d.trample',$option['order_by']))
				$select->left_join($this->TABLE_.'digg as d', 'd.digg, d.trample', 'd.iid=i.id', $index = '');
				
			$select->order($option['order_by_string']);
		}else{
			$select->order('i.list_order DESC');
		}
		
		//��ǰҳ��
		$page = 0;
		//�ܼ�¼��
		$count = 0;
		$page_size = $option['limit'];
		
		//�������
		if(is_array($var)){
			$var = $this->DB_master->escape_string($var);
			
			foreach($option['var_fields'] as $field => $v){
				//��������ֶ�
				switch($v['operator']){
				
				case 'in':
					$select->in($field, $var[$field]);
				break;
				
				case 'range':
					$exclude = !empty($var[$field]) || !empty($var['exclude']) ? true : false;
					$select->range(
						$field,
						isset($var[$field][0]) ? $var[$field][0] : null,
						isset($var[$field][1]) ? $var[$field][1] : null,
						$exclude
					);
				break;
				
				case 'search':
					if($field == 'i.title'){
						$tag = $this->get_tag($var[$field], true);
						
						if($tag['tag_id']){
							$select->inner_join($this->tag_item_table .' AS ti', '', 'ti.iid = i.id');
							$select->in('ti.tid', $tag['tag_id']);
							$select->distinct();
						}
					}else{
						$select->search($field, $var[$field]);
					}
				break;
				
				}
			}
			
			if($option['pageable']){
				//�ɷ�ҳ,��ҳ��
				if(isset($var['#page#'])) $page = $var['#page#'];
				//�м�¼��
				if(isset($var['#count#'])) $count = $var['#count#'];
				//ָ����limit
				$page_size = empty($var['#page_size#']) ? $option['limit'] : $var['#page_size#'];
			}
		}
		
		//echo $select->build_sql() .'<hr />';
		//ȡ������
		$list = $this->core->list_item(
			$select,
			array(
				'page' => &$page,
				'page_size' => $page_size,
				'count' => &$count,
				'sphinx' => $sphinx
			)
		);
		
		
		//����ɷ�ҳ
		if($option['pageable']){
			//��ȡҳ���ϵĵ�ǰ��������
			global $CAT;
			if(!empty($CAT)){
				//������ڱ�ģ��ķ�ҳ�ű���
				$CAT['is_category'] = true;
				
				//��ǰ����ķ�ҳ
				$pages = list_page(array(
					'count' => $count,
					'page' => $page,
					'page_size' => $page_size,
					'url' => p8_url($this, $CAT, 'list', false)
				));
			}
		}
		
	}else{
		$select->from($table .' AS i', $fields);
		//ָ��ID,�����ҳ,��ʹ��sphinx, ���򰴴���ID��˳����
		$select->in('i.id', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array('page_size' => 0)
		);
		
		$tmp = array_combine($option['ids'], $c);
		foreach($list as $v){
			$tmp[$v['id']] = $v;
		}
		
		$list = array_values($tmp);
	}
	//echo $select->build_sql().'<br>';
	unset($select, $tmp);
	//���û�ԭ����ģ��
	$this->set_model($orig_model);
	
	
	$dot = empty($option['title_dot']) ? '' : '...';
	//�õ�Ƭ���
	$swidth = isset($option['width']) ? $option['width'] : 300;
	$sheight = isset($option['height']) ? $option['height'] : 300;
	
	//ÿ�еĿ��,���ڶ���
	$width = isset($option['rows']) && $option['rows'] > 1 ? (100/$option['rows']-1).'%' : '99%';
	$wf ='';
	if($width!='99%'){
		$wf = "width:$width;float:left;margin-right:1%";
	}
	$title_length = empty($option['title_length']) ? 0 : $option['title_length'];
	$summary_length = empty($option['summary_length']) ? 0 : $option['summary_length'];
	
	foreach($list as $k => $v){
		$v['#category'] = &$category->categories[$v['cid']];
		$list[$k]['url'] = p8_url($this, $v, 'view');
		
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['full_title'] = $v['title'];
		$list[$k]['title'] = p8_cutstr($v['title'], $title_length, $dot);
		$list[$k]['summary'] = p8_cutstr($v['summary'], $summary_length, '');
		$list[$k]['summary'] = preg_replace('/(amp;)+/','', $list[$k]['summary']);
		$tmp = explode('|', $v['sub_title']);
		$list[$k]['sub_title'] = $tmp[0];
		$list[$k]['sub_title_url'] = isset($tmp[1]) ? $tmp[1] : '';
		
		//��������
		$list[$k]['category_name'] = $v['#category']['name'];
		//����URL
		$list[$k]['category_url'] = $v['#category']['url'];
		
		//�Ӵֺ���ɫ
		if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
		if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
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

/**
* ������ҳ�����б�
**/
function homepage_list(&$block){
	
	global $core, $SKIN, $RESOURCE, $USER;
	
	$select = select();
	$select->from($this->member_table .' AS m', 'm.iid');
	$select->inner_join($this->main_table .' AS i', 'i.*', 'm.iid = i.id');
	$select->in('m.uid', $USER['id']);
	$select->order('m.timestamp DESC');
	
	$page = 0;
	$count = 0;
	$page_size = empty($block['item_count']) ? 10 : $block['item_count'];
	$page_size = max(1, $page_size);
	
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count,
			//'sphinx' => $sphinx
		)
	);
	
	$category = &$this->system->load_module('category');
	$category->get_cache();
	
	foreach($list as $k => $v){
		$v['#category'] = &$category->categories[$v['cid']];
		$list[$k]['url'] = p8_url($this, $v, 'view');
		
		$list[$k]['frame'] = attachment_url($v['frame']);
		//$list[$k]['summary'] = p8_cutstr($v['summary'], $summary_length, '');
		$tmp = explode('|', $v['sub_title']);
		$list[$k]['sub_title'] = $tmp[0];
		$list[$k]['sub_title_url'] = isset($tmp[1]) ? $tmp[1] : '';
		
		//��������
		$list[$k]['category_name'] = $v['#category']['name'];
		//����URL
		$list[$k]['category_url'] = $v['#category']['url'];
		
		//�Ӵֺ���ɫ
		if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
		if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
	}
	
	ob_start();
	include template($this, 'block/list');
	return ob_get_clean();
	
}

}