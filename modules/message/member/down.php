<?php
defined('PHP168_PATH') or die();

$UID or exit('[]');
/**
 * 将信息下载为TXT文本形式
 */
if(REQUEST_METHOD == 'POST'){
	$type = isset($_POST['type']) ? $_POST['type'] : 'in';
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	$id or message('no_such_item');
	
	$ids = implode(',', $id);
	$and = ' AND '. ($type == 'in' ? 'sendee_uid' : 'sender_uid') .' = \''. $UID .'\'';
	$query = $DB_slave->query("SELECT * FROM $this_module->table WHERE id in($ids) $and ORDER BY timestamp DESC");
	
	$content = '';
	while($arr = $DB_slave->fetch_array($query)){
		$content .= p8lang(
			$P8LANG['message_export_template'],
			$arr['username'] == '' ? $P8LANG['system_message'] : $arr['username'],
			$arr['title'],
			date('Y-m-d H:i:s', $arr['timestamp']),
			$arr['content']
		);
	}
	
	$filename = 'Message-'.$USERNAME.'-'.date('Y-m-d_H-i-s', P8_TIME).'.txt';
	header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME) .' GMT');
	header('Pragma: no-cache');
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='. $filename);
	header('Content-Length: '. strlen($content));
	header('Content-type: txt');
	echo $content;
	exit;
}else{
	message('error');
	exit;
}