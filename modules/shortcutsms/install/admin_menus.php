<?php

return array(

	array(

		'name' => '快捷短信管理',

		'system' => $this_system->name,

		'module' => $this_module->name,

		'action' => '',

		'display_order' => 86,

		'position' => 'extern',

		

		'menus' => array(

			

			array(

				'name' => '快捷短信管理',

				'system' => $this_system->name,

				'module' => $this_module->name,

				'action' => 'list',

				'display_order' => 99

			),

			

			array(

				'name' => '添加快捷短信',

				'system' => $this_system->name,

				'module' => $this_module->name,

				'action' => 'add',

				'display_order' => 90

			)

		)

	)

);