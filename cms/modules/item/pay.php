<?php
defined('PHP168_PATH') or die();

/**
* 内容收费支付
**/

//没登录要先登录,登录后跳回上上页
$UID or message('not_login', $core->U_controller .'?forward='. urlencode($HTTP_REFERER));

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('access_denied');
	
	$check = $DB_slave->fetch_one("SELECT m.id, m.credit, m.credit_type, m.cid, m.uid AS to_uid, p.uid FROM $this_module->main_table AS m
	LEFT JOIN {$this_module->TABLE_}pay AS p ON p.iid = m.id AND p.uid = '$UID'
	WHERE id = '$id'");
	$check or message('access_denied');
	
	
	//本身没有收费,分类收费,分类收费忽略用户组
	if(
		!$check['credit_type'] && ($cat = $this_system->fetch_category($check['cid'])) &&
		empty($cat['CONFIG']['fee']['ignore_roles'][$core->ROLE])
	){
		$check['credit'] = $cat['CONFIG']['fee']['credit'];
		$check['credit_type'] = $cat['CONFIG']['fee']['credit_type'];
	}
	
	$this_module->CONFIG['htmlize'] = 0;
	$url = p8_url($this_module, $check, 'view');
	
	if(
		$IS_ADMIN || $check['uid'] || $UID == $check['uid'] ||
		empty($core->credits[$check['credit_type']])
	){
		//管理员或本人,或者已经支付,或者币种不存在
		header('Location: '. $url);
		exit;
	}
	
	if(empty($check['id'])){
		//文章不存在
		message('access_denied');
	}
	
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
	
	//支付完成,跳转到动态页
	header('Location: '. $url);
	exit;
}