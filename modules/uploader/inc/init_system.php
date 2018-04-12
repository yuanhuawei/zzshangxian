<?php
defined('PHP168_PATH') or die();

/**
* 为一个系统生成附件表,必须是由系统所安装的install/install.php包含过来的,不是单独使用
**/

require_once PHP168_PATH .'install/install.func.php';

$sql = get_install_sql(
	$DB_master,
	file_get_contents(PHP168_PATH .'modules/uploader/install/system_sql.php'),
	$this_system->TABLE_,
	true
);

foreach($sql as $v){
	$DB_master->query($v);
}