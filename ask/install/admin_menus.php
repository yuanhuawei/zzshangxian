<?php
return array(
	array(
		'name' => '问答系统',
		'system' => $this_system->name,
		'module' => '',
		'action' => '',
		
		'menus' => array(
			array(
				'name' => '系统操作',
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'display_order' => 99,
				
				'menus' => array(
					array(
						'name' => '统计信息',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'statistics',
						'display_order' => 99
					),
					array(
						'name' => '系统配置',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'config',
						'display_order' => 98
					),
					array(
						'name' => '更新缓存',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'cache_all',
						'display_order' => 96
					)
				)
			)
		)
	)
);