<?php
defined('PHP168_PATH') or die();

/**
* 内容查看次数
**/

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id or exit('');

$data = $DB_slave->fetch_one("SELECT views, comments, model FROM $this_module->main_table WHERE id = '$id'");
$data or exit('');


if(
	$DB_master->update(
		$this_module->main_table,
		array('views' => 'views +1'),
		"id = '$id'",
		false
	)
){
	
	$this_module->set_model($data['model']);
	
	$DB_master->update(
		$this_module->table,
		array('views' => 'views +1'),
		"id = '$id'",
		false
	);
}

exit('
$(function(){
	$(\'.item_views\').html('. $data['views'] .');
	$(\'.item_comments\').html('. $data['comments'] .');
});
');