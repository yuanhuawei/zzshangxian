<?php
return array(
	array(
		'name' => '站内消息',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 98,
		
		'menus' => array(
			array(
				'name' => '发消息',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'send',
				'display_order' => 99
			),
			
			array(
				'name' => '收件箱',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'inbox',
				'display_order' => 98
			),
			
			array(
				'name' => '发件箱',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'outbox',
				'display_order' => 97
			)
		)
	)
);