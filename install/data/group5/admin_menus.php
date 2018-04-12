<?php
return array(
	array(
		'name' => '系统设置',
		'system' => 'core',
		'module' => '',
		'action' => 'main',
		'display_order' => 80,
		
		'menus' => array(
			array(
				'name' => '系统配置',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 99,
				
				'menus' => array(
					array(
						'name' => '核心配置',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 99,
						'menus' => array(
							array(
								'name' => '基本配置',
								'system' => 'core',
								'module' => '',
								'action' => 'base_config',
								'display_order' => 99
							),
							array(
								'name' => '全局配置',
								'system' => 'core',
								'module' => '',
								'action' => 'global_config',
								'display_order' => 88
							),
							array(
								'name' => '注册配置',
								'system' => 'core',
								'module' => '',
								'action' => 'reg_config',
								'display_order' => 77
							)
						)
					),
					array(
						'name' => '系统管理',
						'system' => 'core',
						'module' => '',
						'action' => 'system_list',
						'display_order' => 88
					),
					array(
						'name' => '模块管理',
						'system' => 'core',
						'module' => '',
						'action' => 'module_list',
						'display_order' => 77
					),
					array(
						'name' => '插件管理',
						'system' => 'core',
						'module' => '',
						'action' => 'plugin_list',
						'display_order' => 66
					),
					array(
						'name' => '服务器管理',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 55,
						'display' => S_version() == 'company' ? 0 : 1,
						'menus'=>array(
							array(
								'name' => '查看php配置',
								'system' => 'core',
								'module' => '',
								'action' => 'phpinfo',
								'display_order' =>79
							),
							array(
								'name' => 'MYSQL 从服务器',
								'system' => 'core',
								'module' => '',
								'action' => 'db_slave',
								'display_order' => 88
							)
						)
					),
					
					array(
						'name' => 'memcache 管理',
						'system' => 'core',
						'module' => '',
						'action' => 'memcache',
						'display_order' => 44,
						'display' => S_version() == 'company' ? 0 : 1,
						'menus'=>array(
					
							array(
								'name' => 'memcache 配置',
								'system' => 'core',
								'module' => '',
								'action' => 'memcache',
								'display_order' => 99
							),
							array(
								'name' => 'memcache 管理',
								'system' => 'core',
								'module' => '',
								'action' => 'memcached',
								'display_order' => 88
							)
						)
					),
					
					array(
						'name' => '系统缓存',
						'system' => 'core',
						'module' => '',
						'action' => 'cache',
						'display_order' => 44
					),
					
					array(
						'name' => '日志管理',
						'system' => 'core',
						'module' => '',
						'action' => 'log',
						'display_order' => 33
					),
				)
			),
			
			array(
				'name' => '菜单管理',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 97,
				
				'menus' => array(
					array(
						'name' => '头部导航',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 99,
						'menus' => array(
							array(
								'name' => '头部导航管理',
								'system' => 'core',
								'module' => '',
								'action' => 'navigation_menu_list',
								'display_order' => 99
							),
							array(
								'name' => '添加头部导航',
								'system' => 'core',
								'module' => '',
								'action' => 'navigation_menu_add',
								'display_order' => 88
							)
						)
					),
					array(
						'name' => '后台菜单',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 88,
						'menus' => array(
							array(
								'name' => '后台菜单管理',
								'system' => 'core',
								'module' => '',
								'action' => 'menu_list',
								'display_order' => 99
							),
							array(
								'name' => '添加后台菜单',
								'system' => 'core',
								'module' => '',
								'action' => 'menu_add',
								'display_order' =>  88
							)
						)
					),
					
					array(
						'name' => '会员中心菜单',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 77,
						'menus' => array(
							array(
								'name' => '会员中心菜单管理',
								'system' => 'core',
								'module' => '',
								'action' => 'member_menu_list',
								'display_order' => 99
							),
							array(
								'name' => '添加会员中心菜单',
								'system' => 'core',
								'module' => '',
								'action' => 'member_menu_add',
								'display_order' => 88
							)
						)
					)
				)
			),
			
			array(
				'name' => '模板管理',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 96,
				
				'menus' => array(
					array(
						'name' => '系统模板',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 99,
						
						'menus' => array(
							array(
							'name' => '系统模板',
							'system' => 'core',
							'module' => '',
							'action' => 'template_system',
							'display_order' => 99
							)
						)
					),
					array(
						'name' => '会员中心模板',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 97,
						
						'menus' => array(
							array(
								'name' => '会员中心模板',
								'system' => 'core',
								'module' => '',
								'action' => 'template_user_center',
								'display_order' => 99
							),
							array(
								'name' => '会员主页模板',
								'system' => 'core',
								'module' => '',
								'action' => 'template_user_index',
								'display_order' => 77
							),
						)
					)
				)
			),
			
			array(
				'name' => '系统整合',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 90,
				'display' => S_version() == 'company' ? 0 : 1,
				'menus' => array(
					array(
						'name' => '系统整合',
						'system' => 'core',
						'module' => 'member',
						'action' => 'integrate',
						'display_order' => 93
					)
				)
			),
			
			
			array(
				'name' => '地区管理',
				'system' => 'core',
				'module' => '',
				'action' => 'area',
				'display_order' => 89,
				'display' => S_version() == 'company' ? 0 : 1,
				'menus' => array(
					array(
						'name' => '地区管理',
						'system' => 'core',
						'module' => '',
						'action' => 'area',
						'display_order' => 99
					)
				)
			),
			
			array(
				'name' => '安全设置',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 88,
				
				'menus' => array(
					array(
						'name' => 'IP黑名单',
						'system' => 'core',
						'module' => '',
						'action' => 'stop_ip',
						'display_order' => 99
					),
					array(
						'name' => 'IP白名单',
						'system' => 'core',
						'module' => '',
						'action' => 'allow_ip',
						'display_order' => 98
					),
					array(
						'name' => '词语过滤',
						'system' => 'core',
						'module' => '',
						'action' => 'word_filter',
						'display_order' =>96
					),
					array(
						'name' => '防止CC攻击',
						'system' => 'core',
						'module' => '',
						'action' => 'connection_flood',
						'display_order' => 94
					),
					array(
						'name' => '文件改动扫描',
						'system' => 'core',
						'module' => '',
						'action' => 'md5_files',
						'display_order' => 93
					)
				)
			),
		)
	),
	
	array(
		'name' => '模块中心',
		'system' => 'core',
		'module' => '',
		'action' => 'plugin',
		'display_order' => 95
	),
	
	array(
		'name' => '扩展模块',
		'system' => 'core',
		'module' => '',
		'action' => 'extern',
		'display_order' => 77,
		'display' => 0
	),
	
	array(
		'name' => '模板与菜单',
		'system' => 'core',
		'module' => '',
		'action' => '',
		'url' => 'core-navigation_menu_list',
		'display_order' => 90
	)
);