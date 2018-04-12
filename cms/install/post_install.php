<?php
defined('PHP168_PATH') or die();

cp(PHP168_PATH .'inc/index.html', $this_system->path .'index.html');
chmod_r($this_system->path .'index.html', 0666);


$crontab = &$core->load_module('crontab');

//��Ӽƻ�����
/*if($DB_master->version() > '5.1.0'){
	//֧�ֱ�������������ƻ�����
	$crontab_id = $crontab->add(array(
		'name' => to_installed_charset('CMS��ʱ������ݱ�'),
		'script' => $this_system->name .'_item_partition.php',
		'day' => 0,
		'week' => 0,
		'month' => 1,
		'hour' => 0,
		'minute' => 0,
		'status' => 1
	));
	
	$this_system->set_config(array('model_partition_crontab' => $crontab_id));
	
	require $crontab->path .'inc/run.php';
}*/

/* $index_html_crontab_id = $crontab->add(array(
	'name' => to_installed_charset('CMS��ҳ��ʱ��̬'),
	'script' => $this_system->name .'_index_to_html.php',
	'day' => 0,
	'week' => 0,
	'month' => 0,
	'hour' => 3,
	'minute' => 0,
	'status' => 1
));
 */
/**��ϵͳ���Է��**/
$this_system->set_config(array(
	'forbidden_dynamic' => 0,
	'index_to_html_crontab_id' => $index_html_crontab_id,
	'index_file' => 1,
	'template' => S_version()? S_version() : 'media',
	'mobile_template' => 'default'
));

foreach($this_system->modules as $__m => $__v){
	$_mod = $this_system->load_module($__m);
	$_mod->set_config(array('template' => S_version()? S_version() : 'media','mobile_template' => 'default'));
}


//���һЩ��ʼ������
 $sql = get_install_sql(
	$DB_master,
	file_get_contents($this_system->path .'install/init_data.php'),
	$this_system->TABLE_
);
foreach($sql as $v){
	$DB_master->query($v);
}