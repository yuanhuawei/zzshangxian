<?php
return array(
	array(
		'name' => 'վ����Ϣ',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 98,
		
		'menus' => array(
			array(
				'name' => '����Ϣ',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'send',
				'display_order' => 99
			),
			
			array(
				'name' => '�ռ���',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'inbox',
				'display_order' => 98
			),
			
			array(
				'name' => '������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'outbox',
				'display_order' => 97
			)
		)
	)
);