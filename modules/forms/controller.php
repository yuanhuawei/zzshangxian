<?php
defined('PHP168_PATH') or die();

class P8_Forms_Controller extends P8_Controller{

var $category_acl;
function __construct(&$obj){
	//$this->no_base_acl = true;
	parent::__construct($obj);
}

function P8_Forms_Controller(&$obj){
	$this->__construct($obj);
}

function _init(){
	//获取基于分类的权限控制表
	$this->category_acl = $this->get_acl('category_acl');
}

/**
* 提交表单
**/
function add(&$POST){
	
	//检查权限,站群免检
	//$this_controller->check_category_action('post', $mid) or message('no_privilege');
	
	global  $UID, $USERNAME;
	
	//验证数据
	$data = $this->valid_data($POST);

	if($data === null) return false;
	
	$data['main']['timestamp'] = P8_TIME;
	$data['main']['uid'] = $UID;
	$data['main']['username'] = $USERNAME;
	$data['main']['mid'] = $this->model->model['id'];
	$data['main']['ip'] = P8_IP;
	$id = $this->model->add($data);
	
	return $id;
}

function update($id, &$POST){
	//验证数据
	$data = $this->valid_data($POST);
	
	if($data === null) return false;
	$data['main']['update_time'] = P8_TIME;
	return  $this->model->update($id, $data);
}

function delete_model($post){
	$mid = intval($post['id']);
	if(!$this->model->get_model($mid,true))return false;
	return  $this->model->delete_model($mid);
}
/**
* 验证数据
* field# 数组为自定义字段的值
**/
function valid_data(&$POST){
	global $IS_FOUNDER;
	
	$data = array(
		'main' => array(),
		'item' => array()
	);
	$func = 'html_entities';	
	//关联附件哈希
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
		
	//验证公共部分
	$data['main']['title'] = isset($POST['title']) ? filter_word($func($POST['title'])) : $this->model->model['alias'];
	$data['main']['title_color'] = isset($POST['title_color']) ? $func($POST['title_color']) : '';
	
	$data['main']['status'] = isset($POST['status'])? $POST['status'] : 0;
	//排序
	if($this->check_admin_action('list_order')){
		$data['main']['list_order'] = isset($POST['list_order']) && ($list_order = strtotime($POST['list_order'])) ? $list_order : P8_TIME;
	}else{
		$data['main']['list_order'] = P8_TIME;
	}

	
	//自定义字段的过滤
	if(isset($POST['field#']) && is_array($POST['field#'])){
		$F = &$POST['field#'];
	}else{
		$F = array();
	}
	
	foreach($this->model->model['fields'] as $field => $v){
		//检测是否正确的提交字段
		$posted = true;//$v['editable']; //isset($POST['#field_'. $field .'_posted']) || defined('P8_CLUSTER');
		
		$null_flag = false;
		
		//存放在哪个表
		$table = 'item';
		
		switch($v['widget']){
		
		//文本框,多行文本框,单选,单选下拉框,单个上传框
		case 'text': case 'textarea': case 'radio': case 'select':
			
			if($v['not_null'] && !strlen($F[$field])) message($v['alias'].' can not empty');
			
			switch($v['type']){
			
			//整型
			case 'tinyint': case 'smallint': case 'mediumint': case 'int': case 'bigint':
				$data[$table][$field] = $posted && isset($F[$field]) ?
					(int)$F[$field] :
					$v['default_value'];
			break;
			
			//浮点
			case 'float': case 'double': case 'decimal':
				$data[$table][$field] = $posted && isset($F[$field]) ?
					(float)$F[$field] :
					$v['default_value'];
			break;
			
			//字符
			case 'char': case 'varchar':
				$data[$table][$field] = $posted && isset($F[$field]) ?
					filter_word($func($F[$field])) :
					$v['default_value'];
			break;
			
			//默认
			default: 
				$data[$table][$field] = $posted && isset($F[$field]) ?
					filter_word($func($F[$field])) :
					$v['default_value'];
			}
			
		break;
		
		//多选框,多选下拉框
		case 'checkbox': case 'multi_select':
			if($posted){
				if($v['not_null'] && empty($F[$field])) message($v['alias'].' can not empty');
				
				$data[$table][$field] = isset($F[$field]) ?
					implode($this->model->delimiter, $func((array)$F[$field])) :
					'';
			}else{
				$data[$table][$field] = implode($this->model->delimiter, $v['default_value']);
			}
		break;
		
		//上传器
		case 'uploader': case 'image_uploader':
			if($posted){
				if($v['not_null'] && empty($F[$field])) message($v['alias'].' can not empty');
				$title = isset($F[$field]['title']) ? filter_word($F[$field]['title']) : '';
				$url = isset($F[$field]['url']) ? $F[$field]['url'] : '';
				$thumb = isset($F[$field]['thumb']) ? $F[$field]['thumb'] : '';
				
				$data[$table][$field] = attachment_url($title . $this->model->delimiter . $url . $this->model->delimiter . $thumb, true);
			}else{
				$data[$table][$field] = $v['default_value'];
			}
		break;
		
		//时间选择器
		case 'textdate':
			if($v['not_null'] && !strlen($F[$field])) message($v['alias'].' can not empty');
			
			$data[$table][$field] = isset($F[$field]) ? strtotime($F[$field]) : '';
		break;
		//批量上传
		case 'multi_uploader':
			if($posted){
				if($v['not_null'] && empty($F[$field])) message($v['alias'].' can not empty');

				$title = isset($F[$field]['title']) ? (array)$F[$field]['title'] : array();
				$url = isset($F[$field]['url']) ? (array)$F[$field]['url'] : array();
				$thumb = isset($F[$field]['thumb']) ? (array)$F[$field]['thumb'] : array();
				
				$data[$table][$field] = $comma = '';
				foreach($url as $k => $v){
					if(!strlen($v)) continue;
					
					$data[$table][$field] .= $comma . 
						filter_word($title[$k]) . $this->model->col_delimiter .
						$v . $this->model->col_delimiter .
						$thumb[$k];
					
					$comma = $this->model->delimiter;
				}
				
				$data[$table][$field] = attachment_url($data[$table][$field], true);
			}
		break;
		
		//编辑器,编辑器的内容很危险
		case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
			if($posted && isset($F[$field])){
				if($v['not_null'] && !strlen($F[$field])) message($v['alias'].' can not empty');
				
				$acl = $this->core->load_acl('core', '', $this->ROLE);
				$data[$table][$field] = p8_html_filter($F[$field], $acl['allow_tags'], $acl['disallow_tags']);
				//本地化图片
				if(!empty($POST['capture_image'])){
					$this->_att_ids = '';
					
					$data[$table][$field] = preg_replace_callback(
						'#<img[^>]*?src=(?:\'|")?([^\'"]+)(?:\'|")?[^>]*?>#',
						array(&$this, 'capture_image'),
						$data[$table][$field]
					);
					
					$_COOKIE[$this->core->CONFIG['cookie']['prefix'] . 'uploaded_attachments'][$data['attachment_hash']] .= $this->_att_ids;
				}
				
				$data[$table][$field] = attachment_url( filter_word($data[$table][$field]), true);
			}else{
				$data[$table][$field] = $v['default_value'];
			}
		break;
		
		//多级联动
		case 'linkage':
			if($posted  && !empty($F[$field])){
				$c = $v['data']['select_size'];
				foreach($F[$field] as $k=>$vl){
					if($vl)
					$data[$table][$field] = $vl;
				}
				if($v['not_null'] && empty($data[$table][$field])){
					message($v['alias'].' can not empty');
				}
			}else{
				$data[$table][$field] = $v['default_value'];
			}			
		break;
		
		default:
			if($v['not_null'] && !strlen($F[$field])) message($v['alias'].' can not empty');
			
			$data[$table][$field] = $posted && isset($F[$field]) ?
				filter_word($func($F[$field])) :
				$v['default_value'];
		}
		
	}
	//处理自定义字段结束}

	return $data;
}







/**
* 添加一个表单模型
**/
function add_model(&$POST){

	$data = $this->valid_model_data($POST);
	if(!$this->check_model_name($data['name'])) return false;
	return $this->model->add_model($data);
}

/**
* 修改模型
**/
function update_model(&$POST){
	$mid = intval($POST['id']) or message('no_such_model');
	$data = $this->valid_model_data($POST);
	
	
	$config = &$data['config'];
		if(!empty($config['parts'])){
			function cmp($a, $b){
				return strcmp($b['order'], $a['order']);
			}
			uasort($config['parts'],'cmp');
		}
	unset($data['name']);//模型名不允许修改
	return $this->model->update_model($mid, $data);
}


/**
* 验证模型数据
* @param array $POST
**/
function valid_model_data(&$POST){
	$data = array();
	$data['name'] = isset($POST['name']) ? $this->valid_name($POST['name']) : '';
	$data['alias'] = isset($POST['alias']) ? html_entities($POST['alias']) : '';
	$data['verified'] = empty($POST['verified']) ? '' : implode(',', $POST['verified']);
	$data['enabled'] = empty($POST['enabled']) ? false : true;
	$data['recommend'] = empty($POST['recommend']) ? 0 : 1;
	$data['post_template'] = empty($POST['post_template']) ? '' : $POST['post_template'];
	$data['list_template'] = empty($POST['list_template']) ? '' : $POST['list_template'];
	$data['view_template'] = empty($POST['view_template']) ? '' : $POST['view_template'];
	$data['config'] = isset($POST['config']) && is_array($POST['config']) ? $POST['config'] : array();
	
	return $data;
}


/**
* 添加一个字段
* @param array $POST 数据
**/
function add_field(&$POST){
	$data = $this->valid_field_data($POST);
	
	if(!$this->check_field_name($data['name'])) return false;
	
	if(!isset($this->model->field_types[$data['type']])) return false;	//不允许的类型
	if(!isset($this->model->widgets[$data['widget']])) return false;	//不允许的类型

	return $this->model->add_field($data);
}
/**
* 修改一个字段
* @param int $id ID
* @param array $POST 数据
**/
function update_field($id, &$POST){
	$data = $this->valid_field_data($POST);
	if(!isset($this->model->field_types[$data['type']])) return false;	//不允许的类型
	if(!isset($this->model->widgets[$data['widget']])) return false;	//不允许的类型
	if($data['parent'] == $id) $data['parent'] = 0;
	
	return $this->model->update_field($id, $data);
}

/**
* 验证模型字段数据
* @param array $POST
**/
function valid_field_data(&$POST){
	
	$data = array();
	
	$data['type'] = isset($POST['type']) ? $POST['type'] : '';
	$data['widget'] = isset($POST['widget']) ? $POST['widget'] : '';
	$data['widget_addon_attr'] = isset($POST['widget_addon_attr']) ? $POST['widget_addon_attr'] : '';
	$data['model'] = $this->model->MODEL;
	$data['name'] = isset($POST['name']) ? $this->valid_name($POST['name']) : '';
	$data['parent'] = isset($POST['parent']) ? intval($POST['parent']) : 0;
	$data['alias'] = isset($POST['alias']) ? html_entities($POST['alias']) : '';
	$data['length'] = isset($POST['fieldlength']) ? preg_replace("/[^0-9,]/", '', $POST['fieldlength']) : 0;
	$data['is_unsigned'] = empty($POST['is_unsigned']) ? 0 : 1;
	$data['editable'] = empty($POST['editable']) ? 0 : 1;
	$data['not_null'] = empty($POST['not_null']) ? 0 : 1;
	$data['list_table'] = empty($POST['list_table']) ? 0 : 1;
	$data['filterable'] = empty($POST['filterable']) ? 0 : 1;
	//$data['orderby'] = empty($POST['orderby']) ? 0 : 1;
	$data['default_value'] = isset($POST['default_value']) ? html_entities($POST['default_value']) : '';
	$data['units'] = isset($POST['units']) ? html_entities($POST['units']) : '';
	$data['description'] = isset($POST['description']) ? html_entities($POST['description']) : '';
	$data['part'] = empty($POST['part']) ? '' : $POST['part'].'-'.(empty($POST['part_row'])? '' : $POST['part_row']);
	

	$data_key = isset($POST['data_key']) ? (array)$POST['data_key'] : array();
	$data_value = isset($POST['data_value']) ? (array)$POST['data_value'] : array();
	
	$data['data'] = array();
	foreach($data_key as $k => $v){
		if($data['widget']!=='linkage' && ($v=='select_size' || $v=='select_data')) continue;
		if(!isset($data_value[$k])) continue;
		$data['data'][html_entities($v)] = html_entities($data_value[$k]);
	}
	
	$data['display_order'] = isset($POST['display_order']) ? intval($POST['display_order']) : 0;
	$data['jsreg'] = isset($POST['jsreg']) ? $POST['jsreg'] : '';
	$data['jsregmsg'] = isset($POST['jsregmsg']) ? html_entities($POST['jsregmsg']) : ($data['jsreg']? $P8LANG['error']:'');
	$data['color'] = isset($POST['color']) ? html_entities($POST['color']) : '';
	$data['config'] = isset($POST['config']) ? p8_stripslashes2((array)$POST['config']) : array();
	$fields = array_flip(array('id', 'config', 'type', 'widget', 'widget_addon_attr', 'model', 'name', 'alias', 'length', 'is_unsigned', 'not_null', 'list_table', 'filterable', 'orderby', 'default_value', 'data', 'display_order', 'part'));
	/*
	foreach($data['config'] as $k => $v){
		if(isset($fields)) unset($data[$k]);
	}*/
	
	unset($data_key, $data_value);
	
	return $data;
}

/**
* 验证是否是正确的模型名,字段名,必须以字母开头
* @param string $name
**/
function valid_name($name){
	return preg_replace('/[^0-9a-zA-Z_]/', '', $name);
}
/**
* 检查模型名称是不是合法的
* @param string $name 模型名称
* @return bool
**/

function check_model_name($name){
	
	if(!preg_match('/^[a-zA-z]/', $name) && preg_match('/[^0-9A-Za-z_]/', $name)){
		return false;
	}
	
	if(empty($name)) return false;
	
	//不能用以下的名称作为模型名称
	if(in_array($name, array('core', 'config', 'label', 'global', 'inc', 'call', 'admin', 'install', '#', 'acl', 'modules', 'model', 'widget', 'member', 'homepage', 'special', 'models'))) return false;
	
	//检查模型名是否有重复
	$tmp = $this->model->get_model($name);
	return empty($tmp);
}
/**
* 检查一个字段名是否合法
* @param int $mid 模型ID
* @param string $name 字段名称
* @return bool
**/
function check_field_name($name){
	
	if(!preg_match('/^[a-zA-z]/', $name) && preg_match('/[^0-9A-Za-z_]/', $name)){
		return false;
	}
	
	if(empty($name)) return false;
	
	//不能用以下的名称作为字段名称
	if(in_array($name, array('category', 'page', 'data', 'addon'))) return false;
	
	
	//字段不能与两个数据表的重复
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM {$this->model->table} LIKE '$name'");
	if(!empty($tmp)){
		return false;
	}
	
	$tmp = $this->DB_master->fetch_one("SHOW FIELDS FROM {$this->model->data_table} LIKE '$name'");
	if(!empty($tmp)){
		return false;
	}
	
	return true;
}
/**
* 检查模型权限
**/
function check_model_action($action, $mid = 0){
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	//如果没有上一级权限
	if(!parent::check_action($action)) return false;
	
	//如果拥有所有分类的权限
	if(!empty($this->category_acl[0]['actions'][$action])) return true;
	return !empty($this->category_acl[$mid]['actions'][$action]);
}

function get_select_data($data, $iid){
	
	$select_data = array();
	if($data){
		$select_data = stripslashes(html_decode_entities($data));
		$select_data = mb_unserialize($select_data);
		if($iid){
			$p = explode('-',$iid);
			$l = count($p);
			foreach($p as $key=>$val){
				if($key==0)
					$select_data = !empty($select_data[$val])? $select_data[$val] : array();
				else
					$select_data = !empty($select_data['s'])? $select_data['s'][$val] : array();
			}
			$select_data = !empty($select_data['s'])? $select_data['s'] : array();
		}
	}
	return $select_data;
}
function update_linkage($post){
	$fid = intval($post['fid']);
	$iid = $post['iid'];
	$file_data = $this->model->get_field($fid);
	$select = mb_unserialize($file_data['data']);
	$select_data = $this->get_select_data($select['select_data'], $iid);
	$nemes = $post['name'];
	foreach($select_data as $key=>$val){
		if($val['n']!= $nemes[$key])
			$select_data[$key]['n'] = $nemes[$key];
	}
	
	if(!empty($post['n_name'])){
		foreach($post['n_name'] as $key=>$val){
			$select_data[$key]=array(
				'i'=> ($iid? $iid.'-'.$key : $key),
				'n'=> $val,
				's'=>''
			);
		}
	}
	
	$path = explode('-',$iid);
	$main_select_data = $this->get_select_data($select['select_data'], 0);
	$temp = &$main_select_data;
	if($main_select_data && $iid){
		foreach($path as $key=>$val){
			$temp = &$temp[$val]['s'];
		}
	}
	$order = $post['order'];
	arsort($order);
	
	$_temp = array();
	foreach($order as $k=>$v){
		$_temp[$k] = $select_data[$k];
	}
	$temp = $_temp;
	$data = array(
		'data'=>array(
			'select_size'=>$select['select_size'],
			'select_data'=>html_entities(addslashes(serialize($main_select_data)))
		)
	);
	return $this->model->update_field_data($fid, $data);

}


function delete_linkage_item($post){
	$fid = intval($post['fid']);
	$iid = $post['iid'];
	$file_data = $this->model->get_field($fid);
	$select = mb_unserialize($file_data['data']);
	$select_data = $this->get_select_data($select['select_data'], $iid);
		
	$path = explode('-',$iid);
	$main_select_data = $this->get_select_data($select['select_data'], 0);
	$temp = &$main_select_data;
	$lid = array_pop($path);
	if($main_select_data && $iid){
		foreach($path as $key=>$val){
			$temp = &$temp[$val]['s'];
		}
	}
	unset($temp[$lid]);
	$data = array(
		'data'=>array(
			'select_size'=>$select['select_size'],
			'select_data'=>htmlspecialchars(addslashes(serialize($main_select_data)))
		)
	);
	return $this->model->update_field_data($fid, $data);
}

}