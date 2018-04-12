<?php
defined('PHP168_PATH') or die();

class P8_Label_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Label_Controller(&$obj){
	$this->__construct($obj);
}

function check_scope($system, $module = '', $postfix = ''){
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	//所有系统
	if(!empty($this->acl['scope']['*'])) return true;
	
	//系统下的所有模块
	if(!empty($this->acl['scope'][$system]['*'])) return true;
	
	//所有后缀
	if(!empty($this->acl['scope'][$system][$module]['*'])) return true;
	
	return !empty($this->acl['scope'][$system][$module][$postfix]);
}

/**
* 添加标签
**/
function add(&$POST){
	$data = $this->valid_data($POST);
	if(empty($data['name'])) return false;
	if($data === null) return false;
	
	//if(!$this->check_scope($data['system'], $data['module'], $data['postfix'])) return false;
	
	return $this->model->add($data);
}

/**
* 更新一条标签
**/
function update($id, &$POST){
	$data = $this->valid_data($POST);
	unset($data['name']);
	if($data === null) return false;
	
	//if(!$this->check_scope($data['system'], $data['module'], $data['postfix'])) return false;
	
	return $this->model->update($id, $data);
}

/**
* 验证标签数据
**/
function valid_data(&$POST){
	$data = array();
	
	//作用域系统
	$data['system'] = isset($POST['system']) && get_system($POST['system']) ? $POST['system'] : 'core';
	//作用域模块
	$data['module'] = isset($POST['module']) && get_module($POST['system'], $POST['module']) ? $POST['module'] : '';
	$data['site'] = !empty($POST['site']) ? $POST['site'] : '';
	$data['env'] = !empty($POST['env']) ? $POST['env'] : '';
	//数据源系统
	if(isset($POST['source_system'])){
		$data['source_system'] = get_system($POST['source_system']) ? 
			$POST['source_system'] : 
			($POST['source_system'] == 'core' ? 'core' : '');
	}else{
		$data['source_system'] = '';
	}
	//数据源模块
	$data['source_module'] = isset($POST['source_module']) && get_module($POST['source_system'], $POST['source_module']) ?
		$POST['source_module'] :
		'';
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	//标签名称
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	//标签调用代码
	$data['invoke'] = '';
	//标签选项
	$data['option'] = isset($POST['option']) ? p8_stripslashes2((array)$POST['option']) : array();
	//允许查看标签的角色
	$data['option']['allowed_roles'] = empty($data['option']['allowed_roles']) ?
		array() :
		array_flip(filter_int($data['option']['allowed_roles']));
	
	//标签编辑占位符宽度
	$data['option']['place_holder_width'] = empty($POST['place_holder_width']) ? 100 : intval($POST['place_holder_width']);
	//高度
	$data['option']['place_holder_height'] = empty($POST['place_holder_height']) ? 30 : intval($POST['place_holder_height']);
	$data['variable'] = empty($POST['option']['var_fields']) ? 0 : 1;
	
	if(empty($POST['invoke'])){
		//调用代码
		if(empty($POST['option']['var_fields'])){
			
			$data['invoke'] = html_entities(empty($data['invoke']) ? '$label['. $data['name'] .']' : $data['invoke']);
		}else{
			$var = '{';
			$comma = '';
			foreach($POST['option']['var_fields'] as $field => $v){
				$var .= "$comma'$field' => $v[var]";
				$comma = ', ';
			}
			$var .= '}';
			
			$data['invoke'] = html_entities(empty($data['invoke']) ? '$label['. $data['name'] .']'. $var : $data['invoke']);
			
			unset($var);
		}
	}else{
		$data['invoke'] = html_entities($POST['invoke']);
	}
	
	//标签类型
	$data['type'] = isset($POST['type']) ? $POST['type'] : '';
	//标签后缀
	$data['postfix'] = isset($POST['postfix']) ? preg_replace('/[^0-9a-zA-Z_]/', '', $POST['postfix']) : '';
	//标签有效期
	$data['ttl'] = isset($POST['ttl']) ? intval($POST['ttl']) : 0;
	/*
	标签的类型
	sql			自定义的SQL
	module_data	取模块数据
	html		html代码
	slide		幻灯片
	image		图片
	*/
	$types = array('sql', 'module_data', 'html', 'slide', 'image', 'flash');
	in_array($data['type'], $types) || $data['type'] = 'html';
	
	$data['content'] = isset($POST['content']) ?
		$this->very_html(p8_stripslashes2($POST['content'])) :
		'';
	
	if($data['type'] === 'sql'){
		$sql = preg_replace('!--[^\r\n]*|#[^\r\n]*|/\*[\s\S]*\*/!', '', $data['content']);
		//危险的,你懂的
		if(!preg_match('/^select/i', $sql) || preg_match('/into\s+outfile/i', $sql)) unset($data['name']);
	}
	
	return $data;
}

/*
对html代码特殊处理
*/
function very_html($content){
	$content  = preg_replace("/^&nbsp;(.*?)/is","\\1",$content);
	if(strstr($content, '<embed') && !strstr($content, 'wmode=')){
		$content  = str_replace("<embed",'<embed wmode="transparent"',$content);
	}
	return $content;
}
/**
* 模块数据标签选项公用部分
**/
function valid_module_data_option(&$POST){
	//允许排序的字段
	global $order_bys;
	$option = array();
	
	//排序
	$option['order_by'] = empty($POST['order_by']) || !is_array($POST['order_by']) ? array() : $POST['order_by'];
	$desc = empty($POST['order_by_desc']) || !is_array($POST['order_by_desc']) ? array() : $POST['order_by_desc'];
	$tmp = array();
	foreach($option['order_by'] as $k => $v){
		if(in_array($v, $order_bys)) continue;
		
		$tmp[$v] = empty($desc[$k]) ? 0 : 1;
	}
	$option['order_by'] = $tmp;
	unset($desc, $tmp);
	
	//是否可分页
	$option['pageable'] = empty($POST['pageable']) ? 0 : 1;
	//指定ID
	$option['ids'] = empty($POST['ids']) ? '' : preg_replace("/[^0-9,]/", '', $POST['ids']);
	//多余的,
	$option['ids'] = array_filter(explode(',', $option['ids']));
	$option['ids'] = implode(',', $option['ids']);
	
	//限制条数
	$option['limit'] = empty($POST['limit']) ? 0 : intval($POST['limit']);
	//模板
	$option['template'] = empty($POST['template']) ? '' : $POST['template'];
	
	//调用函数必须以label开头
	$option['method'] = isset($POST['method']) ? basename($POST['method']) : 'label';
	strpos($option['method'], 'label') === 0 || $option['method'] == 'label';
	
	//生成缓存时需要清除的选项
	$option['unset_options'] = array();
	
	return $option;
}

/**
* 检查是否是变量字段
**/
function is_var_field($field){
	return preg_match('/^\\$[a-zA-Z_\x7f-\xff]/', $field);
}

}