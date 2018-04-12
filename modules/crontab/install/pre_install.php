<?php
defined('PHP168_PATH') or die();

//每天两次
$this_module->add(array(
	'name' => to_installed_charset('清除SESSION'),
	'script' => 'clear_session.php',
	'day' => 0,
	'week' => 0,
	'month' => 0,
	'hour' => 12,
	'minute' => 0,
	'status' => 1
));/* 

//每周一次
$this_module->add(array(
	'name' => to_installed_charset('清除垃圾附件'),
	'script' => 'redundancy_attachment.php',
	'day' => 0,
	'week' => 1,
	'month' => 0,
	'hour' => 0,
	'minute' => 0,
	'status' => 1
)); */

//每天一次
$this_module->add(array(
	'name' => to_installed_charset('清除过期角色'),
	'script' => 'expired_buy_role.php',
	'day' => 1,
	'week' => 0,
	'month' => 0,
	'hour' => 0,
	'minute' => 0,
	'status' => 1
));

//每小时一次
$this_module->add(array(
	'name' => to_installed_charset('CMS首页定时静态'),
	'script' => 'cms_index_to_html.php',
	'day' => 0,
	'week' => 0,
	'month' => 0,
	'hour' => 1,
	'minute' => 0,
	'status' => 1
));