<?php
defined('PHP168_PATH') or die();

/**
* �ر�ϵͳ��ģ����ϴ�����,��������ģ������װ��install/install.php����������,���ǵ���ʹ��
**/

$uploader = &$core->load_module('uploader');
$config = $core->get_config('core', 'uploader');

$enables = empty($config['enables']) ? array() : $config['enables'];

if(isset($this_module)){
	//ģ���ϴ�
	unset($enables[$this_system->name][$this_module->name]);
}else{
	//ϵͳ�ϴ�
	unset($enables[$this_system->name]['']);
}

$uploader->set_config(
	array(
		'enables' => $enables
	)
);