<?php
return array(
	array(
		'name' => 'ϵͳ����',
		'system' => 'core',
		'module' => '',
		'action' => 'main',
		'display_order' => 80,
		
		'menus' => array(
			array(
				'name' => 'ϵͳ����',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 99,
				
				'menus' => array(
					array(
						'name' => '��������',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 99,
						'menus' => array(
							array(
								'name' => '��������',
								'system' => 'core',
								'module' => '',
								'action' => 'base_config',
								'display_order' => 99
							),
							array(
								'name' => 'ȫ������',
								'system' => 'core',
								'module' => '',
								'action' => 'global_config',
								'display_order' => 88
							),
							array(
								'name' => 'ע������',
								'system' => 'core',
								'module' => '',
								'action' => 'reg_config',
								'display_order' => 77
							)
						)
					),
					array(
						'name' => 'ϵͳ����',
						'system' => 'core',
						'module' => '',
						'action' => 'system_list',
						'display_order' => 88
					),
					array(
						'name' => 'ģ�����',
						'system' => 'core',
						'module' => '',
						'action' => 'module_list',
						'display_order' => 77
					),
					array(
						'name' => '�������',
						'system' => 'core',
						'module' => '',
						'action' => 'plugin_list',
						'display_order' => 66
					),
					array(
						'name' => '����������',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 55,
						'display' => S_version() == 'company' ? 0 : 1,
						'menus'=>array(
							array(
								'name' => '�鿴php����',
								'system' => 'core',
								'module' => '',
								'action' => 'phpinfo',
								'display_order' =>79
							),
							array(
								'name' => 'MYSQL �ӷ�����',
								'system' => 'core',
								'module' => '',
								'action' => 'db_slave',
								'display_order' => 88
							)
						)
					),
					
					array(
						'name' => 'memcache ����',
						'system' => 'core',
						'module' => '',
						'action' => 'memcache',
						'display_order' => 44,
						'display' => S_version() == 'company' ? 0 : 1,
						'menus'=>array(
					
							array(
								'name' => 'memcache ����',
								'system' => 'core',
								'module' => '',
								'action' => 'memcache',
								'display_order' => 99
							),
							array(
								'name' => 'memcache ����',
								'system' => 'core',
								'module' => '',
								'action' => 'memcached',
								'display_order' => 88
							)
						)
					),
					
					array(
						'name' => 'ϵͳ����',
						'system' => 'core',
						'module' => '',
						'action' => 'cache',
						'display_order' => 44
					),
					
					array(
						'name' => '��־����',
						'system' => 'core',
						'module' => '',
						'action' => 'log',
						'display_order' => 33
					),
				)
			),
			
			array(
				'name' => '�˵�����',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 97,
				
				'menus' => array(
					array(
						'name' => 'ͷ������',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 99,
						'menus' => array(
							array(
								'name' => 'ͷ����������',
								'system' => 'core',
								'module' => '',
								'action' => 'navigation_menu_list',
								'display_order' => 99
							),
							array(
								'name' => '���ͷ������',
								'system' => 'core',
								'module' => '',
								'action' => 'navigation_menu_add',
								'display_order' => 88
							)
						)
					),
					array(
						'name' => '��̨�˵�',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 88,
						'menus' => array(
							array(
								'name' => '��̨�˵�����',
								'system' => 'core',
								'module' => '',
								'action' => 'menu_list',
								'display_order' => 99
							),
							array(
								'name' => '��Ӻ�̨�˵�',
								'system' => 'core',
								'module' => '',
								'action' => 'menu_add',
								'display_order' =>  88
							)
						)
					),
					
					array(
						'name' => '��Ա���Ĳ˵�',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 77,
						'menus' => array(
							array(
								'name' => '��Ա���Ĳ˵�����',
								'system' => 'core',
								'module' => '',
								'action' => 'member_menu_list',
								'display_order' => 99
							),
							array(
								'name' => '��ӻ�Ա���Ĳ˵�',
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
				'name' => 'ģ�����',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 96,
				
				'menus' => array(
					array(
						'name' => 'ϵͳģ��',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 99,
						
						'menus' => array(
							array(
							'name' => 'ϵͳģ��',
							'system' => 'core',
							'module' => '',
							'action' => 'template_system',
							'display_order' => 99
							)
						)
					),
					array(
						'name' => '��Ա����ģ��',
						'system' => 'core',
						'module' => '',
						'action' => '',
						'display_order' => 97,
						
						'menus' => array(
							array(
								'name' => '��Ա����ģ��',
								'system' => 'core',
								'module' => '',
								'action' => 'template_user_center',
								'display_order' => 99
							),
							array(
								'name' => '��Ա��ҳģ��',
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
				'name' => 'ϵͳ����',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 90,
				'display' => S_version() == 'company' ? 0 : 1,
				'menus' => array(
					array(
						'name' => 'ϵͳ����',
						'system' => 'core',
						'module' => 'member',
						'action' => 'integrate',
						'display_order' => 93
					)
				)
			),
			
			
			array(
				'name' => '��������',
				'system' => 'core',
				'module' => '',
				'action' => 'area',
				'display_order' => 89,
				'display' => S_version() == 'company' ? 0 : 1,
				'menus' => array(
					array(
						'name' => '��������',
						'system' => 'core',
						'module' => '',
						'action' => 'area',
						'display_order' => 99
					)
				)
			),
			
			array(
				'name' => '��ȫ����',
				'system' => 'core',
				'module' => '',
				'action' => '',
				'display_order' => 88,
				
				'menus' => array(
					array(
						'name' => 'IP������',
						'system' => 'core',
						'module' => '',
						'action' => 'stop_ip',
						'display_order' => 99
					),
					array(
						'name' => 'IP������',
						'system' => 'core',
						'module' => '',
						'action' => 'allow_ip',
						'display_order' => 98
					),
					array(
						'name' => '�������',
						'system' => 'core',
						'module' => '',
						'action' => 'word_filter',
						'display_order' =>96
					),
					array(
						'name' => '��ֹCC����',
						'system' => 'core',
						'module' => '',
						'action' => 'connection_flood',
						'display_order' => 94
					),
					array(
						'name' => '�ļ��Ķ�ɨ��',
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
		'name' => 'ģ������',
		'system' => 'core',
		'module' => '',
		'action' => 'plugin',
		'display_order' => 95
	),
	
	array(
		'name' => '��չģ��',
		'system' => 'core',
		'module' => '',
		'action' => 'extern',
		'display_order' => 77,
		'display' => 0
	),
	
	array(
		'name' => 'ģ����˵�',
		'system' => 'core',
		'module' => '',
		'action' => '',
		'url' => 'core-navigation_menu_list',
		'display_order' => 90
	)
);