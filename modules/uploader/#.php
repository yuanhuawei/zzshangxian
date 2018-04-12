<?php
return array(
	//忽略项
	'alias' => '上传模块',
	'class' => 'P8_Uploader',
	'controller_class' => 'P8_Uploader_Controller',
	
	'admin_actions' => array(
		'config' => '配置',
		'role_filter' => '角色上传过滤',
		'list' => '附件列表',
		'delete' => '删除附件'
	),
	
	'actions' => array(
		'list' => '附件列表',
		'upload' => '上传',
		'mylist' => '我的附件',
		'capture' => '抓取网络文件',
		'image_cut' => '剪裁图片',
		'delete' => '删除附件'
	),
	//忽略项
	
	//保护项
	/* 'ftp_config' => array(		//远程FTP附件
		'enabled' => true,
		'host' => 'attachment.16865.com',
		'port' => 21,
		'user' => 'user',
		'password' => 'user',
		'dir' => '/',
		'timeout' => 60,
		'ssl' => false,
	), */
	//保护项
	
	//'split_interval' => 4,		//几小时分文件夹
);