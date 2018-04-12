<?php
/**
* 模型自定义默认字段
**/

return array(
	'content' => array(
		'type' => 'mediumtext',
		'widget' => 'editor',
		'name' => 'content',
		'alias' => '内容',
		'length' => 0,
		'is_unsigned' => 0,
		'not_null' => 1,
		'list_table' => 0,
		'default_value' => '',
		'display_order' => 99
	)
);