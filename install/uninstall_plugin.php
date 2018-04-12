<?php
defined('PHP168_PATH') or die();

/**
* Ð¶ÔØÒ»¸ö²å¼þ
**/

require_once PHP168_PATH .'install/install.func.php';

//É¾³ýÅäÖÃ
$DB_master->delete(
	$core->TABLE_ .'config',
	"system = 'core' AND module LIKE '$this_plugin->name%'"
);

$DB_master->delete(
	$core->TABLE_ .'plugin',
	"name = '$this_plugin->name'"
);

if(is_file($this_plugin->path .'install/uninstall.php')){
	//Ö´ÐÐÐ¶ÔØ½Å±¾
	require $this_plugin->path .'install/uninstall.php';
}

//É¾³ýÕû¸öÄ¿Â¼
rm($this_plugin->path);
//Ä£°åÄ¿Â¼
rm(TEMPLATE_PATH .'plugin/'. $this_plugin->name);
//»º´æ
rm(CACHE_PATH .'core/plugin/'. $this_plugin->name);