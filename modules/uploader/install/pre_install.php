<?php
defined('PHP168_PATH') or die();

$this_module->set_config(array(
	'thumb' => array(
		'enabled' => 1,
		'width' => 150,
		'height' => 150,
		'quality' => 75
	),
	
	'cthumb' => array(
		'width' => 600,
		'height' => 450
	),
	
	'watermark' => array(
		'enabled' => 0,
		'file' => 'images/watermark.gif',
		'position' => 3,
		'quality' => 75
	)
));

//本模块挂勾到会员模块
$this_module->hook('core', 'member', 'uid');