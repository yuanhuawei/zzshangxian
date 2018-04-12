<?php
defined('PHP168_PATH') or die();

if(!empty($this_module->CONFIG['model_partition_crontab'])){
	$crontab = &$core->load_module('crontab');
	$crontab->delete($this_module->CONFIG['model_partition_crontab']);
}


$DB_master->query("DROP TABLE $this_module->main_table");
$DB_master->query("DROP TABLE $this_module->attribute_table");
$DB_master->query("DROP TABLE $this_module->member_table");
$DB_master->query("DROP TABLE {$this_module->TABLE_}comment");
$DB_master->query("DROP TABLE {$this_module->TABLE_}comment_id");
$DB_master->query("DROP TABLE {$this_module->TABLE_}comment_unverified");

$models = $this_system->get_models();
foreach($models as $k => $v){
	$this_module->set_model($k);
	$DB_master->query("DROP TABLE $this_module->table");
	$DB_master->query("DROP TABLE $this_module->addon_table");
}