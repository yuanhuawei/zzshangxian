<?php
defined('PHP168_PATH') or die();

/**
* 开启模块的上传功能,必须是由模块所安装的install/install.php包含过来的,不是单独使用
'system_name' => array(
	'module_name' => array(
		'enabled' => true | false,
		'filter' => array(
			
		),
		'_filter' => 'xxx'
	)
)
uploader_filter
system	module	postfix	id		filter	_filter
core			module
				role	1		xxxx
				art_cat	2		xxx

'role_filter' => array(
	'role_id' => array(
		'filter' => array(
			
		),
		'_filter' => 'xxx'
	)
)
**/

$uploader = &$core->load_module('uploader');
$config = $core->get_config('core', 'uploader');

$enables = empty($config['enables']) ? array() : $config['enables'];
if(isset($this_module)){
	//模块上传
	$enables[$this_system->name][$this_module->name] = true;
}else{
	//系统上传
	$enables[$this_system->name][''] = true;
}

$uploader->set_config(
	array(
		'enables' => $enables
	)
);