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
	
	//����ϵͳ
	if(!empty($this->acl['scope']['*'])) return true;
	
	//ϵͳ�µ�����ģ��
	if(!empty($this->acl['scope'][$system]['*'])) return true;
	
	//���к�׺
	if(!empty($this->acl['scope'][$system][$module]['*'])) return true;
	
	return !empty($this->acl['scope'][$system][$module][$postfix]);
}

/**
* ��ӱ�ǩ
**/
function add(&$POST){
	$data = $this->valid_data($POST);
	if(empty($data['name'])) return false;
	if($data === null) return false;
	
	//if(!$this->check_scope($data['system'], $data['module'], $data['postfix'])) return false;
	
	return $this->model->add($data);
}

/**
* ����һ����ǩ
**/
function update($id, &$POST){
	$data = $this->valid_data($POST);
	unset($data['name']);
	if($data === null) return false;
	
	//if(!$this->check_scope($data['system'], $data['module'], $data['postfix'])) return false;
	
	return $this->model->update($id, $data);
}

/**
* ��֤��ǩ����
**/
function valid_data(&$POST){
	$data = array();
	
	//������ϵͳ
	$data['system'] = isset($POST['system']) && get_system($POST['system']) ? $POST['system'] : 'core';
	//������ģ��
	$data['module'] = isset($POST['module']) && get_module($POST['system'], $POST['module']) ? $POST['module'] : '';
	$data['site'] = !empty($POST['site']) ? $POST['site'] : '';
	$data['env'] = !empty($POST['env']) ? $POST['env'] : '';
	//����Դϵͳ
	if(isset($POST['source_system'])){
		$data['source_system'] = get_system($POST['source_system']) ? 
			$POST['source_system'] : 
			($POST['source_system'] == 'core' ? 'core' : '');
	}else{
		$data['source_system'] = '';
	}
	//����Դģ��
	$data['source_module'] = isset($POST['source_module']) && get_module($POST['source_system'], $POST['source_module']) ?
		$POST['source_module'] :
		'';
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	//��ǩ����
	$data['name'] = isset($POST['name']) ? html_entities($POST['name']) : '';
	//��ǩ���ô���
	$data['invoke'] = '';
	//��ǩѡ��
	$data['option'] = isset($POST['option']) ? p8_stripslashes2((array)$POST['option']) : array();
	//����鿴��ǩ�Ľ�ɫ
	$data['option']['allowed_roles'] = empty($data['option']['allowed_roles']) ?
		array() :
		array_flip(filter_int($data['option']['allowed_roles']));
	
	//��ǩ�༭ռλ�����
	$data['option']['place_holder_width'] = empty($POST['place_holder_width']) ? 100 : intval($POST['place_holder_width']);
	//�߶�
	$data['option']['place_holder_height'] = empty($POST['place_holder_height']) ? 30 : intval($POST['place_holder_height']);
	$data['variable'] = empty($POST['option']['var_fields']) ? 0 : 1;
	
	if(empty($POST['invoke'])){
		//���ô���
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
	
	//��ǩ����
	$data['type'] = isset($POST['type']) ? $POST['type'] : '';
	//��ǩ��׺
	$data['postfix'] = isset($POST['postfix']) ? preg_replace('/[^0-9a-zA-Z_]/', '', $POST['postfix']) : '';
	//��ǩ��Ч��
	$data['ttl'] = isset($POST['ttl']) ? intval($POST['ttl']) : 0;
	/*
	��ǩ������
	sql			�Զ����SQL
	module_data	ȡģ������
	html		html����
	slide		�õ�Ƭ
	image		ͼƬ
	*/
	$types = array('sql', 'module_data', 'html', 'slide', 'image', 'flash');
	in_array($data['type'], $types) || $data['type'] = 'html';
	
	$data['content'] = isset($POST['content']) ?
		$this->very_html(p8_stripslashes2($POST['content'])) :
		'';
	
	if($data['type'] === 'sql'){
		$sql = preg_replace('!--[^\r\n]*|#[^\r\n]*|/\*[\s\S]*\*/!', '', $data['content']);
		//Σ�յ�,�㶮��
		if(!preg_match('/^select/i', $sql) || preg_match('/into\s+outfile/i', $sql)) unset($data['name']);
	}
	
	return $data;
}

/*
��html�������⴦��
*/
function very_html($content){
	$content  = preg_replace("/^&nbsp;(.*?)/is","\\1",$content);
	if(strstr($content, '<embed') && !strstr($content, 'wmode=')){
		$content  = str_replace("<embed",'<embed wmode="transparent"',$content);
	}
	return $content;
}
/**
* ģ�����ݱ�ǩѡ��ò���
**/
function valid_module_data_option(&$POST){
	//����������ֶ�
	global $order_bys;
	$option = array();
	
	//����
	$option['order_by'] = empty($POST['order_by']) || !is_array($POST['order_by']) ? array() : $POST['order_by'];
	$desc = empty($POST['order_by_desc']) || !is_array($POST['order_by_desc']) ? array() : $POST['order_by_desc'];
	$tmp = array();
	foreach($option['order_by'] as $k => $v){
		if(in_array($v, $order_bys)) continue;
		
		$tmp[$v] = empty($desc[$k]) ? 0 : 1;
	}
	$option['order_by'] = $tmp;
	unset($desc, $tmp);
	
	//�Ƿ�ɷ�ҳ
	$option['pageable'] = empty($POST['pageable']) ? 0 : 1;
	//ָ��ID
	$option['ids'] = empty($POST['ids']) ? '' : preg_replace("/[^0-9,]/", '', $POST['ids']);
	//�����,
	$option['ids'] = array_filter(explode(',', $option['ids']));
	$option['ids'] = implode(',', $option['ids']);
	
	//��������
	$option['limit'] = empty($POST['limit']) ? 0 : intval($POST['limit']);
	//ģ��
	$option['template'] = empty($POST['template']) ? '' : $POST['template'];
	
	//���ú���������label��ͷ
	$option['method'] = isset($POST['method']) ? basename($POST['method']) : 'label';
	strpos($option['method'], 'label') === 0 || $option['method'] == 'label';
	
	//���ɻ���ʱ��Ҫ�����ѡ��
	$option['unset_options'] = array();
	
	return $option;
}

/**
* ����Ƿ��Ǳ����ֶ�
**/
function is_var_field($field){
	return preg_match('/^\\$[a-zA-Z_\x7f-\xff]/', $field);
}

}