<?php
return array(
	array(
		'name' => '�û�����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 98,
		
		'menus' => array(
			array(
				'name' => '�û��б�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			array(
				'name' => 'ר���û�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'expertor',
				'display_order' => 98
			),
			array(
				'name' => '�ʴ�֮��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'star',
				'display_order' => 97
			)
		)
	),

);