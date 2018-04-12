<?php
return array(
	array(
		'name' => '支付',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 90,
		//安装到插件位置
		'position' => 'plugin',
		
		'menus' => array(
			
			array(
				'name' => '支付接口',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'interface',
				'display_order' => 98
			),
			
			array(
				'name' => '订单管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'order',
				'display_order' => 97
			)
		)
	)
);