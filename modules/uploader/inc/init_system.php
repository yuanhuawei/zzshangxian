<?php
defined('PHP168_PATH') or die();

/**
* Ϊһ��ϵͳ���ɸ�����,��������ϵͳ����װ��install/install.php����������,���ǵ���ʹ��
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