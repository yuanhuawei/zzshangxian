<?php
defined('PHP168_PATH') or die();

/**
* �����շ�֧��
**/

//û��¼Ҫ�ȵ�¼,��¼����������ҳ
$UID or message('not_login', $core->U_controller .'?forward='. urlencode($HTTP_REFERER));

if(REQUEST_METHOD == 'POST'){
	
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$id or message('access_denied');
	
	$check = $DB_slave->fetch_one("SELECT m.id, m.credit, m.credit_type, m.cid, m.uid AS to_uid, p.uid FROM $this_module->main_table AS m
	LEFT JOIN {$this_module->TABLE_}pay AS p ON p.iid = m.id AND p.uid = '$UID'
	WHERE id = '$id'");
	$check or message('access_denied');
	
	
	//����û���շ�,�����շ�,�����շѺ����û���
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
		//����Ա����,�����Ѿ�֧��,���߱��ֲ�����
		header('Location: '. $url);
		exit;
	}
	
	if(empty($check['id'])){
		//���²�����
		message('access_denied');
	}
	
	//��ȡ�û�����
	$credits = $core->get_credit($UID);
	if($credits[$check['credit_type']] < $check['credit']){
		message('credit_not_enough');
	}
	
	//�۳�����
	$core->update_credit($UID, array($check['credit_type'] => -$check['credit']));
	
	//���ӷ����ߵĻ���
	$core->update_credit($check['to_uid'], array($check['credit_type'] => $check['credit']));
	
	$DB_master->insert(
		$this_module->TABLE_ .'pay',
		array(
			'iid' => $id,
			'uid' => $UID,
			'timestamp' => P8_TIME
		)
	);
	
	//֧�����,��ת����̬ҳ
	header('Location: '. $url);
	exit;
}