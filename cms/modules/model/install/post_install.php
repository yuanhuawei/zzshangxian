<?php
defined('PHP168_PATH') or die();


//����Ĭ��ģ��
$import_models = to_installed_charset(include $this_system->path .'install/import_models.php');
foreach($import_models as $v){
	$this_module->import($v['name'], $v['alias']);
}
