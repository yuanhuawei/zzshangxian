<?php
return array(
	array(
		'name' => '�ʴ�ϵͳ',
		'system' => $this_system->name,
		'module' => '',
		'action' => '',
		
		'menus' => array(
			array(
				'name' => 'ϵͳ����',
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'display_order' => 99,
				
				'menus' => array(
					array(
						'name' => 'ͳ����Ϣ',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'statistics',
						'display_order' => 99
					),
					array(
						'name' => 'ϵͳ����',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'config',
						'display_order' => 98
					),
					array(
						'name' => '���»���',
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