<?php
return array(
	array(
		'name' => '内容管理',
		'system' => $this_system->name,
		'module' => '',
		'action' => '',
		'display_order' => 99,
		
		'menus' => array(
			array(
				'name' => '系统操作',
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'display_order' => 99,
				
				'menus' => array(
					array(
						'name' => '首页标签',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'main?edit_label=1&postfix=index',
						'front' => 1,
						'url' => '',
						'display_order' => 99
					),
					
					array(
						'name' => '系统配置',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'config',
						'display_order' => 90
					),
					
					array(
						'name' => '表情管理',
						'system' => $this_system->name,
						'module' => 'item',
						'action' => 'mood',
						'display_order' => 88
					)
				)
			),
			
			array(
				'name' => '评论管理',
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'display_order' => 88,
				
				'menus'=>array(
					array(
						'name' => '评论列表',
						'system' => $this_system->name,
						'module' => 'item',
						'action' => 'comment',
						'display_order' => 99,
						'menus' => array(
							array(
								'name' => '己审核',
								'system' => $this_system->name,
								'module' => 'item',
								'action' => 'comment',
								'display_order' => 99
							),
							array(
								'name' => '待审核',
								'system' => $this_system->name,
								'module' => 'item',
								'action' => 'comment?verified=0',
								'display_order' => 88
							)
						)	
					)				
				)
			),
			
			array(
				'name' => '静态化',
				'system' => $this_system->name,
				'module' => '',
				'action' => 'html',
				'display_order' => 0,
				
				'menus' => array(
					array(
						'name' => '一键静态化',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'html_all',
						'display_order' => 99
					),
					
					array(
						'name' => '主页静态化',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'index_to_html',
						'display_order' => 98
					),
					
					array(
						'name' => '栏目&内容静态化',
						'system' => $this_system->name,
						'module' => 'item',
						'action' => 'list_to_html',
						'display_order' => 97
					)
				)
			)
		)
	)
);