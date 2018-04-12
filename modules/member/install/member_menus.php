<?php
return array(
	array(
		'name' => '我的资料',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'profile',
		'display_order' => 99,
		
		'menus' => array(
			/* array(
				'name' => '好友管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'friend',
				'display' => 1,
				'display_order' => 88
			),
			array(
				'name' => '好友分组',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'friend_category',
				'display' => 1,
				'display_order' => 77
			),
			array(
				'name' => '通讯录',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'address_list',
				'target' => '_blank',
				'display' => 0,
				'display_order' => 70
			), */
			array(
				'name' => '修改基本信息',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'profile',
				'display_order' => 66
			)/* ,
			array(
				'name' => '会员升级',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'buy_role',
				'front' => 1,
				'display' => 1,
				'target' => '_blank',
				'display_order' => 55
			) */
		)
	),
	
	array(
		'name' => '支付',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display' => 0,
		'display_order' => 97,
		
		'menus' => array(
			array(
				'name' => '充值',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'recharge',
				'front' => 1,
				'target' => '_blank',
				'display_order' => 99
			),
			array(
				'name' => '充值记录',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'recharge_log',
				'display_order' => 97
			)
		)
	)
);