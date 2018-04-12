<?php
defined('PHP168_PATH') or die();

/**
* CMS×Ô¶¯ÉóºË
**/

$system = &$core->load_system('cms');
$item = &$cms->load_module('item');

$query = $DB_slave->query("SELECT id FROM $this->unverified_table ORDER BY timestamp ASC LIMIT 10");
$comma = $ids = '';
while($arr = $DB_slave->fetch_array($query)){
	$ids .= $comma . $ids;
	$comma = ',';
}

if(empty($ids)) return;

$item->verify("{$item->unverified_table}.id IN ($ids)", 1, 0);