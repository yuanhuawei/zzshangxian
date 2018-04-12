<?php
return array(
	array(
		'name' => '采集',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 86,
		'position' => 'plugin',
		'display' => S_version() == 'company' ? 0 : 1,
		'menus' => array(
			
			array(
				'name' => '分类管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'category',
				'display_order' => 99
			),
			
			array(
				'name' => '规则管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'rule',
				'display_order' => 98
			),
			
			array(
				'name' => '采集内容管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'item',
				'display_order' => 97
			),
		)
	)
);