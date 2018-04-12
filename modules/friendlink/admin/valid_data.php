<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$LABEL=&$core->load_module('label');
if($action == 'explain'){
	$_POST = p8_stripslashes2(from_utf8($_POST));
}
//������
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';

if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

//����Դģ����Ϣ
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//��ǩ����Ϊģ������
$_POST['type'] = 'module_data';

//��ʼ����select
$select = select();
$select->from($this_module->table_link .' AS i', 'i.*');

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

$select->in('i.fid', explode(',',$option['display_content']));
//��ǩͨ�ò���,����֤�õ����ݸ���ԭ��������
$option = $controller->valid_module_data_option($option) + $option;
//��֤��ʾ����
if(!empty($option['display_content'])&&!preg_match("/\\d+/",$option['display_content'])){
	message("error");
}
