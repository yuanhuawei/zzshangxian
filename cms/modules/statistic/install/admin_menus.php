<?php
return array(
	array(
		'name' => 'ͳ��',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 60,
		
		'menus' => array(
			array(
				'name' => 'ͳ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_data',
				'display_order' => 99
			),
			array(
				'name' => '����',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_member',
				'display_order' => 88
			),
			array(
				'name' => '����ͳ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_cluster',
				'display_order' => 88
			),
			array(
				'name' => '��վ����ͳ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_sites_push',
				'display_order' => 88
			),
			array(
				'name' => '��վ����ͳ��',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'statistic_sites_content',
				'display_order' => 88
			)
		)
	)
);