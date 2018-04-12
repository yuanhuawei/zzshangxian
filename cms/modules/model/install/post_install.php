<?php
defined('PHP168_PATH') or die();


//导入默认模型
$import_models = to_installed_charset(include $this_system->path .'install/import_models.php');
foreach($import_models as $v){
	$this_module->import($v['name'], $v['alias']);
}
