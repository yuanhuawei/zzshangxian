<?php
defined('PHP168_PATH') or die();

//ÿ������
$this_module->add(array(
	'name' => to_installed_charset('���SESSION'),
	'script' => 'clear_session.php',
	'day' => 0,
	'week' => 0,
	'month' => 0,
	'hour' => 12,
	'minute' => 0,
	'status' => 1
));/* 

//ÿ��һ��
$this_module->add(array(
	'name' => to_installed_charset('�����������'),
	'script' => 'redundancy_attachment.php',
	'day' => 0,
	'week' => 1,
	'month' => 0,
	'hour' => 0,
	'minute' => 0,
	'status' => 1
)); */

//ÿ��һ��
$this_module->add(array(
	'name' => to_installed_charset('������ڽ�ɫ'),
	'script' => 'expired_buy_role.php',
	'day' => 1,
	'week' => 0,
	'month' => 0,
	'hour' => 0,
	'minute' => 0,
	'status' => 1
));

//ÿСʱһ��
$this_module->add(array(
	'name' => to_installed_charset('CMS��ҳ��ʱ��̬'),
	'script' => 'cms_index_to_html.php',
	'day' => 0,
	'week' => 0,
	'month' => 0,
	'hour' => 1,
	'minute' => 0,
	'status' => 1
));