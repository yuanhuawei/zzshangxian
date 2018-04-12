<?php
//默认权限,由模型创建的时候调用

return array(
	
	//管理员权限
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'add' => true,
			'list' => true,
			'update' => true,
			'delete' => true,
			'add_group' => true,
			'list_group' => true,
			'update_group' => true,
			'delete_group' => true,
		),
	)
);