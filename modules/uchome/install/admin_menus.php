<?php
return array(
	array(
		'name' => 'Uchome���ݵ���',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 89,
		'position' => 'extern',
		
		'menus' => array(
			array(
				'name' => '����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'target' => '',
				'display_order' => 100
			)
		)
	)
);
