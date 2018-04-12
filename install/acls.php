<?php
return array(
	$core->CONFIG['administrator_role'] => array(
		'admin_actions' => array(
			'login' => true,
			'log' => true,
			'md5_files' => true,
			'cache' => true,
			'system_list' => true,
			'module_list' => true,
			'plugin_list' => true,
			'install_system' => true,
			'install_module' => true,
			'install_plugin' => true,
			'uninstall_system' => true,
			'uninstall_module' => true,
			'uninstall_plugin' => true,
			'config' => true,
			'base_config' => true,
			'global_config' => true,
			'memcache' => true,
			'memcached' => true,
			'menu' => true,
			'member_menu' => true,
			'navigation_menu' => true,
			'phpinfo' => true,
			'edit_template' => true,
			'word_filter' => true,
			'plugin' => true,
			'set_acl' => true,
			'set_admin_acl' => true,
		),
		
		'allow_tags' => array(
			'iframe', 'script'
		),
		
		'disallow_tags' => array()
	)
);