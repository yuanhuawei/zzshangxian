<?php
return array(
	array(
		'name' => '���ݹ���',
		'system' => $this_system->name,
		'module' => '',
		'action' => '',
		'display_order' => 99,
		
		'menus' => array(
			array(
				'name' => 'ϵͳ����',
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'display_order' => 99,
				
				'menus' => array(
					array(
						'name' => '��ҳ��ǩ',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'main?edit_label=1&postfix=index',
						'front' => 1,
						'url' => '',
						'display_order' => 99
					),
					
					array(
						'name' => 'ϵͳ����',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'config',
						'display_order' => 90
					),
					
					array(
						'name' => '�������',
						'system' => $this_system->name,
						'module' => 'item',
						'action' => 'mood',
						'display_order' => 88
					)
				)
			),
			
			array(
				'name' => '���۹���',
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'display_order' => 88,
				
				'menus'=>array(
					array(
						'name' => '�����б�',
						'system' => $this_system->name,
						'module' => 'item',
						'action' => 'comment',
						'display_order' => 99,
						'menus' => array(
							array(
								'name' => '�����',
								'system' => $this_system->name,
								'module' => 'item',
								'action' => 'comment',
								'display_order' => 99
							),
							array(
								'name' => '�����',
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
				'name' => '��̬��',
				'system' => $this_system->name,
				'module' => '',
				'action' => 'html',
				'display_order' => 0,
				
				'menus' => array(
					array(
						'name' => 'һ����̬��',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'html_all',
						'display_order' => 99
					),
					
					array(
						'name' => '��ҳ��̬��',
						'system' => $this_system->name,
						'module' => '',
						'action' => 'index_to_html',
						'display_order' => 98
					),
					
					array(
						'name' => '��Ŀ&���ݾ�̬��',
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