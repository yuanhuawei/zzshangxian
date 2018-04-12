<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$LABEL=&$core->load_module('label');
if($action == 'explain'){
	$_POST = p8_stripslashes2(from_utf8($_POST));
}
//作用域
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';

if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

//数据源模块信息
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//标签类型为模块数据
$_POST['type'] = 'module_data';

//开始构造select
$select = select();
$select->from($this_module->table_link .' AS i', 'i.*');

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

$select->in('i.fid', explode(',',$option['display_content']));
//标签通用部分,把验证好的数据覆盖原来的数据
$option = $controller->valid_module_data_option($option) + $option;
//验证显示内容
if(!empty($option['display_content'])&&!preg_match("/\\d+/",$option['display_content'])){
	message("error");
}
