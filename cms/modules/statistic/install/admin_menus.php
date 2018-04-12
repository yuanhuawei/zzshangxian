<?php
return array(
	array(
		'name' => '统计',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 60,
		
		'menus' => array(
			array(
				'name' => '统计',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_data',
				'display_order' => 99
			),
			array(
				'name' => '考核',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_member',
				'display_order' => 88
			),
			array(
				'name' => '推送统计',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_cluster',
				'display_order' => 88
			),
			array(
				'name' => '分站推送统计',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_sites_push',
				'display_order' => 88
			),
			array(
				'name' => '分站内容统计',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_sites_content',
				'display_order' => 88
			)
		)
	)
);