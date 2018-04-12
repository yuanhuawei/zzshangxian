<?php
defined('PHP168_PATH') or die();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id or message('access_denied');

$system = isset($_GET['system']) ? $_GET['system'] : 'core';
if($system != 'core' && empty($core->systems[$system]['installed'])) message('access_denied');

$table = $system == 'core' ? $core->attachment_table : $core->systems[$system]['table_prefix'] .'attachment';
$attachment = $DB_slave->fetch_one("SELECT filename, type, path, remote FROM $table WHERE id = '$id'");
$attachment or message('access_denied');

if($attachment['remote'] != 0){
	$url = $core->CONFIG['attachment']['remote'][$attachment['remote']];
	header('Location: '. $url);
	exit;
}
print_r($attachment);EXIT;
header('Content-Disposition: inline; filename='. $attachment['filename']);
header('Content-type: '. $attachment['type']);
header('Content-Encoding: none');

readfile($this_module->attachment_path . $attachment['path']);
//header('Location: '. $core->url . '/attachment/'. $attachment['path']);
