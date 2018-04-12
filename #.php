<?php
return array(
	/*忽略项*/
	'admin_actions' => array(	/*后台操作*/
		'login'				=> '后台登录',
		'log'				=> '日志管理',
		'config'			=> '配置',
		'set_acl'			=> '前台权限分配',
		'set_admin_acl'		=> '后台权限分配',
		'memcache'			=> 'memcache管理',
		'db_slave'			=> 'MYSQL从服务器配置',
		'menu'				=> '后台菜单管理',
		'navigation_menu_list' 	=> '头部导航管理',
		'member_menu'		=> '会员中心菜单管理',
		'system_list'		=> '系统列表',
		'module_list'		=> '模块列表',
		'plugin_list'		=> '插件列表',
		'plugin'			=> '插件配置',
		'install_system'	=> '安装系统',
		'uninstall_system'	=> '卸载系统',
		'install_module'	=> '安装模块',
		'uninstall_module'	=> '卸载模块',
		'install_plugin'	=> '安装插件',
		'uninstall_plugin'	=> '卸载插件',
		'cache' 			=> '更新缓存',
		'cache_label' 			=> '更新分站缓存',
		'phpinfo' 			=> '查看服务器信息',
		'template_system' 	=> '模板管理',
		'base_config' 		=> '基本配置',
		'global_config' 	=> '全局配置',
		'reg_config' 		=> '注册配置',
		'homepage_config' 	=> '个人主页配置',
		'stop_ip' 			=> 'IP黑名单',
		'allow_ip' 			=> 'IP白名单',
		'word_filter' 		=> '词语过滤',
		'connection_flood' 	=> '防止CC攻击',
		'md5_files' 		=> '文件改动扫描',
		'area' 				=> '地区管理'
	),
	
	/*前台*/
	'actions' => array(	
	),
	/*忽略项*/
	
	
	/*手动添加项*/
	
	/*编码转换函数集*/
	'encode_conv_functions' => array(
		'default' => '',
		'mb_convert_encoding' => 'mb_convert_encoding',
		'iconv' => 'iconv',
	),
	
	/*手动添加项*/
	
	'lang' => 'zh-cn',
	
	'template' => 'default',
	'credit' => '1',
	
	/*for_config*/

	'mysql_connect_type' => 'mysql',
	'mysql_connect_types' => array(
		'mysql' => 'P8_mysql',
		'mysqli' => 'P8_mysqli'
	),
	'mysql_charset' => 'utf8',
	'core_table_prefix' => '',
	'encode_conv_func' => 'iconv',
	'page_charset' => 'utf-8',
	/*for_config*/

	'next_crontab' => P8_TIME,
	
);