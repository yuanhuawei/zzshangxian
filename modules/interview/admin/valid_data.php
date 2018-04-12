<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$LABEL=&$core->load_module('label');

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

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

//标签通用部分,把验证好的数据覆盖原来的数据
$option = $controller->valid_module_data_option($option) + $option;
//验证显示内容
if(!empty($option['display_content']) && !preg_match("/^\d((,\d+)*|\d+)$/",$option['display_content'])){
	message("数据格式不正确！");
}
