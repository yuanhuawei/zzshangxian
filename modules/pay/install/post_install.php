<?php
defined('PHP168_PATH') or die();

//��ģ��ҹ�����Աģ��,ɾ����Ա��ɾ����Ա��Ϊ��ҵ���صĶ���
$this_module->hook('core', 'member', 'buyer_uid');

$this_module->list_interface(true);
$this_module->enable_interface('offline', true);

$this_module->interface_config('offline', 0, array(
	'bank' => array(
		to_installed_charset(array(
			'name' => '�й���������',
			'account' => '6222*********',
			'payee' => 'ĳ����(С��)',
			'logo' => 'icbc.gif',
		))
	)
));