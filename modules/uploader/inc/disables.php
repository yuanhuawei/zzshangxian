<?php
defined('PHP168_PATH') or die();

/**
* 关闭系统或模块的上传功能,必须是由模块所安装的install/install.php包含过来的,不是单独使用
**/

$uploader = &$core->load_module('uploader');
$config = $core->get_config('core', 'uploader');

$enables = empty($config['enables']) ? array() : $config['enables'];

if(isset($this_module)){
	//模块上传
	unset($enables[$this_system->name][$this_module->name]);
}else{
	//系统上传
	unset($enables[$this_system->name]['']);
}

$uploader->set_config(
	array(
		'enables' => $enables
	)
);