<?php
return array(
	array(
		'name' => '万能表单',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'menus' => array(
			/* array(
				'name' => '我的表单',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'myforms',
				'display_order' => 99
			),
			array(
				'name' => '填写表单',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'post',
				'display_order' => 98
			),
			array(
				'name' => '我管理的表单',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'manage',
				'display_order' => 90
			) , */
			array(
				'name' => '表单管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'intranetforms',
				'target' => '_blank',
				'display_order' => 50
			) 
		)
	)
);