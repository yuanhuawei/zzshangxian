<?php
return array(
	array(
		'name' => '���ܱ�',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'menus' => array(
			/* array(
				'name' => '�ҵı�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'myforms',
				'display_order' => 99
			),
			array(
				'name' => '��д��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'post',
				'display_order' => 98
			),
			array(
				'name' => '�ҹ���ı�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'manage',
				'display_order' => 90
			) , */
			array(
				'name' => '������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'intranetforms',
				'target' => '_blank',
				'display_order' => 50
			) 
		)
	)
);