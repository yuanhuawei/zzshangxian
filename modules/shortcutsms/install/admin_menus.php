<?php

return array(

	array(

		'name' => '��ݶ��Ź���',

		'system' => $this_system->name,

		'module' => $this_module->name,

		'action' => '',

		'display_order' => 86,

		'position' => 'extern',

		

		'menus' => array(

			

			array(

				'name' => '��ݶ��Ź���',

				'system' => $this_system->name,

				'module' => $this_module->name,

				'action' => 'list',

				'display_order' => 99

			),

			

			array(

				'name' => '��ӿ�ݶ���',

				'system' => $this_system->name,

				'module' => $this_module->name,

				'action' => 'add',

				'display_order' => 90

			)

		)

	)

);