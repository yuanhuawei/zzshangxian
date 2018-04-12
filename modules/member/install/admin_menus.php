<?php
return array(
	array(
		'name' => '用户管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 97,
		'menus' => array(
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99,
			),
			
			array(
				'name' => '添加会员/管理员',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 98,
				'menus' => array(
					array(
						'name' => '添加会员',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'add',
						'display_order' => 99
					),
					array(
						'name' => '批量添加会员',
						'system' => $this_system->name,
						'module' => $this_module->name,
						'action' => 'impory',
						'display_order' => 88
					)
				)
			),	
			array(
				'name' => '会员管理',
				'system' => 'core',
				'module' => 'member',
				'action' => 'list',
				'display_order' => 88
			),
			array(
				'name' => '会员充值管理',
				'system' => 'core',
				'module' => 'member',
				'action' => 'recharge',
				'display_order' => 87,
				'menus' => array(
					array(
						'name' => '会员充值记录',
						'system' => 'core',
						'module' => 'member',
						'action' => 'recharge',
						'display_order' => 87
					),
					array(
						'name' => '充值卡管理',
						'system' => 'core',
						'module' => 'member',
						'action' => 'recharge_card',
						'display_order' => 86
					),
					array(
						'name' => '会员升级记录',
						'system' => 'core',
						'module' => 'member',
						'action' => 'buy_role',
						'display_order' => 85
					)
				)	
			),
			array(
				'name' => '角色/权限设置',
				'system' => 'core',
				'module' => 'role',
				'action' => 'list',
				'display_order' => 77,
				'menus' => array(
					array(
						'name' => '角色列表',
						'system' => 'core',
						'module' => 'role',
						'action' => 'list',
						'display_order' => 99
					),
					array(
						'name' => '添加角色',
						'system' => 'core',
						'module' => 'role',
						'action' => 'add',
						'display_order' => 88
					)
				)
			),
			
			array(
				'name' => '角色组管理',
				'system' => 'core',
				'module' => 'role',
				'action' => 'list_group',
				'display_order' => 66,
				'menus' => array(
					array(
						'name' => '角色组管理',
						'system' => 'core',
						'module' => 'role',
						'action' => 'list_group',
						'display_order' => 99
					),
					array(
						'name' => '添加角色组',
						'system' => 'core',
						'module' => 'role',
						'action' => 'add_group',
						'display_order' => 88
					)
				
				)
			)
		)
	)
);