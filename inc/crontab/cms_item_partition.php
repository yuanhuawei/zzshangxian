<?php
defined('PHP168_PATH') or die();

/**
* 按时间分区表
**/

$system = &$core->load_system('cms');
$module = &$system->load_module('item');

$models = $system->get_models();

list($y, $m) = explode('|', date('Y|n', P8_TIME));

$time = mktime(0, 0, 0, $m+1, 1, $y);
$date = date('Y_m', $time);

$DB_master->query("ALTER TABLE $module->main_table ADD PARTITION (PARTITION $date VALUES LESS THAN ($time))");
$DB_master->query("ALTER TABLE $module->member_table ADD PARTITION (PARTITION $date VALUES LESS THAN ($time))");
$DB_master->query("ALTER TABLE $module->search_table ADD PARTITION (PARTITION $date VALUES LESS THAN ($time))");

foreach($models as $k => $vv){
	$module->set_model($k);
	
	$DB_master->query("ALTER TABLE $module->table ADD PARTITION (PARTITION $date VALUES LESS THAN ($time))");
	$DB_master->query("ALTER TABLE $module->addon_table ADD PARTITION (PARTITION $date VALUES LESS THAN ($time))");
}