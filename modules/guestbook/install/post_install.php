<?php
defined('PHP168_PATH') or die();

$this_module->set_config(array(
			'GuestBookNum'=>50
		)
	);
//���һЩ��ʼ������
if(is_file($this_module->path .'install/init_data.php')){
	 $sql = get_install_sql(
		$DB_master,
		file_get_contents($this_module->path .'install/init_data.php'),
		$this_module->TABLE_
	);
	foreach($sql as $v){
		$DB_master->query($v);
	} 
}