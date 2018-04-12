<?php
defined('PHP168_PATH') or die();

//本模块挂勾到会员模块,删除会员会删除会员作为买家的相关的订单
$this_module->hook('core', 'member', 'buyer_uid');

$this_module->list_interface(true);
$this_module->enable_interface('offline', true);

$this_module->interface_config('offline', 0, array(
	'bank' => array(
		to_installed_charset(array(
			'name' => '中国工商银行',
			'account' => '6222*********',
			'payee' => '某先生(小姐)',
			'logo' => 'icbc.gif',
		))
	)
));