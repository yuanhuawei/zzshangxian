<?php

return array(
	$core->CONFIG['member_role'] => array(
		'actions' => array(
			'upload' => true,
			'delete' => true,
			'capture' => true,
			'list' => true,
			'mylist' => true
		)
	),
	
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'config' => true,
			'delete' => true,
			'list' => true,
			'image_cut' => true,
			'role_filter' => true,
		),
		
		'actions' => array(
			'upload' => true,
			'delete' => true,
			'capture' => true
		)
	)
);