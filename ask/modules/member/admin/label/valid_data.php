<?php
defined('PHP168_PATH') or die();

//������
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';

if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

if($module && !get_module($system, $module)){
	message('no_such_module');
}

//����Դģ����Ϣ
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//��ǩ����Ϊģ������
$_POST['type'] = 'module_data';

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

//��ǩͨ�ò���,����֤�õ����ݸ���ԭ��������
$option = $controller->valid_module_data_option($option) + $option;
$option['var_fields'] = array();

//�Ƿ���sphinx��������
$option['sphinx'] = !empty($option['sphinx']) && !empty($this_module->CONFIG['sphinx']) ? $this_module->CONFIG['sphinx'] : array();
empty($option['sphinx']) || $option['sphinx']['enabled'] = 1;

//����
$option['category'] = empty($option['category']) ? array() : $option['category'];
//��Ա����
$option['mbtype'] = empty($option['mbtype']) ? 0 : $option['mbtype'];


//��ʼ����select
$select = select();
$select -> from($this_module->table . ' AS i', '*');

if(!empty($option['type'])) $select->in('i.'.$option['type'], '1');

if($option['category'] && $option['mbtype']=='expert'){
	$select->left_join($this_module->table_expertor . ' AS E', 'E.uid', 'i.id=E.uid');
	if($controller->is_var_field($option['category'])){//������ǩ
			
				$select->in(' E.cid', $option['category']);
				$option['var_fields']['E.cid'] = array('operator' => 'in', 'var' => $option['category']);
			$option['unset_options'][] = 'category';
				
	}else{
			$option['category'] = preg_replace("/[^0-9,]/", '', $option['category']);
			//�����,
			$option['category'] = array_filter(explode(',', $option['category']));
			
			$select->in('E.cid', $option['category']);
			
			$option['category'] = implode(',', $option['category']);
	}
	
}

//����
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}

$select->limit(0, $option['limit']);