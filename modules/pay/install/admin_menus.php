<?php
return array(
	array(
		'name' => '֧��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 90,
		//��װ�����λ��
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => '֧���ӿ�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'interface',
				'display_order' => 98
			),
			
			array(
				'name' => '��������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'order',
				'display_order' => 97
			)
		)
	)
);