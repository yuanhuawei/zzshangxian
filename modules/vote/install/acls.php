<?php

return array(
	
	//管理员权限
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'list' => true,
			'add' => true,
			'update' => true,
			'delete' => true,
			'truncate' => true,
		),
	)
);