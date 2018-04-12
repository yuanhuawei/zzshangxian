<?php
//模块安装顺序,顺序不能搞乱

/**
 菜单顺序	后台	前台
 核心操作	99
 菜单		
 member		97		99
 role		96		
 uploader	95
 credit		94
 label		93
 crontab	92
 message	91		98
 pay		90		
 mail		89
 cluster	
 **/

return array(
	'role',
	'credit',
	'member',
	'uploader',
	'crontab',
	'label',
	'message',
	'pay',
	'mail',
	'page',
	'form'
);