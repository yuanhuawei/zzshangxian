<?php
defined('PHP168_PATH') or die();

/**
* ����ģ����ϴ�����,��������ģ������װ��install/install.php����������,���ǵ���ʹ��
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
	//ģ���ϴ�
	$enables[$this_system->name][$this_module->name] = true;
}else{
	//ϵͳ�ϴ�
	$enables[$this_system->name][''] = true;
}

$uploader->set_config(
	array(
		'enables' => $enables
	)
);