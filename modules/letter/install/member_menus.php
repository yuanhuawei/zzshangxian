<?php
return array(
	array(
		'name' => '�쵼����',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 55,
		'menus' => array(
			array(
				'name' => '��д���ż�',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list'
			),
			array(
				'name' => '��Ҫд��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'target'=> '_blank',
				'front' => 1,
				'action' => 'post'
			),
			array(
				'name' => '�������',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'target'=> '_blank',
				'action' => 'manager'
			)
		)
	)
);