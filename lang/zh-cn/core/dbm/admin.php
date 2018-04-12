<?php
//后台管理语言包

return array(
	
	'_module_manage_admin_log' => '管理数据库',
	'_module_backup_admin_log' => '备份数据库',
	'_module_restore_admin_log' => '还原数据库',

	'dbm_backup_init' => '正在初始化。共 {$1} 个表',
	'dbm_restore_init' => '正在初始化',
	'dbm_backup_done' => '备份完成，耗时 {$1} 秒',
	'dbm_restore_done' => '还原完成，耗时 {$1} 秒',
	'dbm_backup_process' => '{$1} 个表剩余，当前表{$2}。<br />正在备份第 {$3} 行，共 {$4} 行',
	'dbm_restore_process' => '共 {$1} 个文件，正在还原第 {$2} 个文件',
	'dbm_backup_locked' => '备份已经在进行，锁定中。备份中断会锁定。你可以手动解锁进行再次备份。',
	
);