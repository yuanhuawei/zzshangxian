<?php
return array(
	array(
		'name' => '内容管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 96,
		
		'menus' => array(
			array(
				'name' => '发布内容',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99,
			),
			array(
				'name' => '所有内容',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88,
				
				'menus' => array(
					array(
						'name' => '所有内容',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list',
						'display_order' => 99
					),
					array(
						'name' => '待审核内容',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list?verified=0',
						'display_order' => 88
					),
					array(
						'name' => '审核未通过内容',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'list?verified=-99',
						'display_order' => 77
					)
				)	
			),
			
			/* array(
				'name' => '分级审核',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify_acl',
				'display_order' => 66
			), */
			
			array(
				'name' => '属性权限',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'attribute_acl',
				'display_order' => 65
			),
			
			array(
				'name' => '采集入库',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'spider',
				'display_order' => 60
			),
			
			array(
				'name' => 'Tag(标签)管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'tag',
				'display_order' => 59
			),
			
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 55
			)
		)
	)
);