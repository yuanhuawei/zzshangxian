<?php
defined('PHP168_PATH') or die();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id or exit('');
$job = isset($_GET['job'])? $_GET['job']:'';

$data = $this_module->data('read', $id);

$data or message('no_such_item_or_unverify');

//检查支付,作者或管理员不检查
if($data['credit']){
$UID or message('not_login', $core->U_controller .'?forward='. urlencode(HTTP_REFERER));
	$credit = $core->credits[$data['credit_type']];
	if( $data['uid'] != $UID && !$IS_ADMIN){
	
		$check = $DB_slave->fetch_one("SELECT m.id, m.credit, m.credit_type, m.uid AS to_uid, p.uid FROM $this_module->main_table AS m
		LEFT JOIN {$this_module->TABLE_}pay AS p ON p.iid = m.id AND p.uid = '$UID'
		WHERE id = '$id'");
		if(!$check['uid']){
		
			//获取用户积分
			$credits = $core->get_credit($UID);
			if($credits[$check['credit_type']] < $check['credit']){
				message('credit_not_enough');
			}
			//扣除积分
			$core->update_credit($UID, array($check['credit_type'] => -$check['credit']));
			
			//增加发布者的积分
			$core->update_credit($check['to_uid'], array($check['credit_type'] => $check['credit']));
			
			$DB_master->insert(
				$this_module->TABLE_ .'pay',
				array(
					'iid' => $id,
					'uid' => $UID,
					'timestamp' => P8_TIME
				)
			);	
		}	
	}
}


$this_system->init_model();
$query=$DB_slave->fetch_one("select softurl,totaldown from $this_module->addon_table where iid=$id");
if(!$query)exit('');
if($job=='totaldown'){
	exit('
	$(function(){
		$(\'.item_down\').html('. $query['totaldown'] .');
	});
	');
}


$down = array();
$ti=isset($_GET['ti'])? intval($_GET['ti']):0;
$res = $DB_slave->update($this_module->addon_table,array('totaldown'=>'totaldown+1')," iid='$id'",false);
$tmp = explode($this_module->delimiter, attachment_url($query['softurl']));
if(!$tmp)exit('');
if(is_array($tmp[0])){
	foreach($tmp as $v){
		$v = explode($this_module->col_delimiter, $v);
		$data[] = array(
		'title' => $v[0],
		'url' => isset($v[1]) ? $v[1] : '',
		);
	}
	$down=$data[$ti];
}else{
	list($down['title'],$down['url'],$down['frame']) = $tmp;
}

$path = $down['url'];
$_path = str_replace($core->attachment_url, '', $path);

//不隐藏或者不在本站
if(empty($this_model['CONFIG']['hidedownurl']) || $path == $_path){
	header("Location: $path");
	exit;
}

$att_path = PHP168_PATH . $core->CONFIG['attachment']['path'] .'/';

$_path = real_path($att_path . $_path);

//限死在附件目录
if(stristr($_path, $att_path) === false){
	exit('Hack!');
}

$filetype = file_ext($_path);


//ob_end_clean();
header('Last-Modified: '.gmdate('D, d M Y H:i:s', P8_TIME).' GMT');
header('Pragma: no-cache');
header('Content-Encoding: none');
if($core->CONFIG['page_charset'] == 'utf-8'){
	$ua = $_SERVER["HTTP_USER_AGENT"];
	$filename = urlencode($down['title']);
	$filename = str_replace("+", "%20",$filename);
	if (preg_match("/MSIE/", $ua)) {
		header('Content-Disposition: attachment;filename="' . $filename . '"');} 
	else if (preg_match("/Firefox/", $ua)){ 
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
	}
	else { 
		header('Content-Disposition: attachment; filename="' . $filename . '"');
	}
}else{
	$filename = $down['title'];
	header('Content-Disposition: attachment; filename='.$filename );
}
header('Content-type: '. $filetype);
header('Content-Length: '.filesize($_path));
readfile($_path);
exit;