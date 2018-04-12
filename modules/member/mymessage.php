<?php

$data = array();
//个人信息
$role_module = $core->load_module('role');
$role_module->roles || $role_module->get_cache();
$this_module->set_model($ROLE_GROUP);
$this_module->get_member_info($UID);
$user['name'] = $USERNAME;
$user['role'] = $role_module->roles[$ROLE]['name'];
$user['icon'] = $this_module->icon? $this_module->icon : $RESOURCE .'/skin/'. $core->CONFIG['member_template']."/nomenpic.gif";
$user['credit'] = $this_module->credit_1? $this_module->credit_1 : 0;
$user['lastlogin'] = date('y-m-d h:i',$this_module->last_login);
$user['lastip'] = $this_module->last_login_ip;
$data['user'] = $user;
//信件
$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."message WHERE sendee_uid = '$UID' AND new=1");
$mail['name'] = 'mail';
$mail['show'] = 1;
$mail['count'] = $query['count'];
$mail['link'] = $core->U_controller.'/core/message-intranetmail';
$data[] = $mail;

//通知
if(!empty($core->modules['notify']['installed'])){
$query = $core->DB_master->fetch_one("SELECT COUNT(*) AS count FROM ".$core->TABLE_."notify_sign_in WHERE uid = '$UID' AND receive ='0'");
$notify['name'] = 'notify';
$notify['show'] = 1;
$notify['count'] = $query['count'];
$notify['link'] = $core->U_controller.'/core/notify-list';
$data[] = $notify;
}

//待办表单
if(!empty($core->modules['forms']['installed'])){
$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."forms_item WHERE status ='0' AND uid = '$UID'");
$forms['name'] = 'forms';
$forms['show'] = 1;
$forms['count'] = $query['count'];
$forms['link'] = $core->U_controller.'/core/forms-intranetforms?se=0';
$data[] = $forms;

//管理表单
$froms_manage['name'] = 'froms_manage';
$froms_manage['show'] = 0;
$froms_manage['count'] = 0;
$forms = &$core->load_module('forms');
$forms_controller = $core->controller($forms);
$my_forms_manage = $forms_controller->get_acl('my_forms_manage');
$mids = $my_forms_manage? array_keys($my_forms_manage) : array();
$mids = implode(',',$mids);
$where = $IS_FOUNDER? '' : " AND mid in($mids)";
if($my_forms_manage || $IS_FOUNDER){
	$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."forms_item WHERE status='0' $where");
	$froms_manage['count'] = $query['count'];
	$froms_manage['show'] = 1;
}
$froms_manage['link'] = $core->U_controller.'/core/forms-intranetforms?ac=manage&se=0';
$data[] = $froms_manage;
}

if(!empty($core->systems['ask']['installed'])){
//待答提问
$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."ask_item_ WHERE uid = '$UID' AND status !='3' AND verify ='1' AND endtime > '". P8_TIME."' AND closed != '1' ");
$ask['name'] = 'ask';
$ask['show'] = 1;
$ask['count'] = $query['count'];
$ask['link'] = $core->U_controller."?main_page=/ask/item-my_ask";
$data[] = $ask;

//管理提问
$ask_manage['name'] = 'ask_manage';
$ask_manage['show'] = 0;
$ask_manage['count'] = 0;
$ask_manage['link'] = $core->U_controller."?main_page=/ask/item-verify";
$ask = $core->load_system('ask');
$item = &$ask->load_module('item');
$item_controller = $core->controller($item);
$my_category_to_verify = $item_controller->get_acl('my_category_to_verify');
if(isset($my_category_to_verify[0]) || $IS_FOUNDER){
	$where='';
	$ask_manage['show'] = 1;
}elseif(!empty($my_category_to_verify)){
	$my_category_to_verify =implode(',',array_keys($my_category_to_verify));
	$where=" AND cid in($my_category_to_verify)";
	$ask_manage['show'] = 1;
}else{
	$where=" AND id='0'";
}
$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."ask_item_ WHERE status !='3' AND verify ='1' AND endtime > '". P8_TIME."' AND closed = '0' $where");

$ask_manage['count'] = $query['count'];

$data[] = $ask_manage;
}

//办事

if(!empty($core->systems['work']['installed'])){
$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."work_item WHERE uid = '$UID' AND verified != '99'");
$query2 = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$core->TABLE_."work_item_unverified WHERE uid = '$UID' AND verified != '-99'");
$workdb['name'] = 'work';
$workdb['count'] = $query['count']+$query2['count'];
$workdb['link'] = $core->controller.'/work/item-work?src='.urlencode($core->U_controller.'/work/item-my_list?verified=0');
$data[] = $workdb;

//管理办事
$work = $core->load_system('work');
$item = &$work->load_module('item');
$verify['name'] = 'verify';
$verify['count'] = 0;
$item_controller = $core->controller($item);
$my_category_step_verify = $item_controller->get_acl('my_category_step_verify');
$mycats = array();
if($my_category_step_verify && !$IS_FOUNDER){
	foreach($my_category_step_verify as $step=>$catarr){
		$mycats += $catarr;
	}
	$cids = array_keys($mycats);
	$cids = implode(",", $cids);
	
	if($cids){
		$where = " AND cid in($cids)";
	}
	
}
$verify['show'] = 0;
$verify['count'] = 0;
if($my_category_step_verify || $IS_FOUNDER){
	$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$item->main_table." WHERE verified < '99' AND verified > '0' $where");
	$query2 = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$item->unverified_table." WHERE verified < '1' AND verified > '-99' $where");
	$verify['count'] = $query['count']+$query2['count'];
	$verify['show'] = 1;
}
$verify['link'] = $core->controller.'/work/item-work?src='.urlencode($core->U_controller.'/work/item-verify');
$data[] = $verify;
}

//管理cms
$cms = $core->load_system('cms');
$item = &$cms->load_module('item');
$item_controller = $core->controller($item);
$my_category_to_verify = $item_controller->get_acl('my_category_to_verify');
$cmss['name'] = 'cms';
$where = '';
if(isset($my_category_to_verify[0]) || $IS_FOUNDER){
	$where = ' where 1=1';
}elseif(!empty($my_category_to_verify)){
	$where = " WHERE cid IN(".implode(',',array_keys($my_category_to_verify)).")";
}
if($where!=''){
	$query = $core->DB_master->fetch_one("SELECT COUNT(id) AS count FROM ".$item->unverified_table." $where");
$cmss['count'] = $query['count'];
$cmss['show'] = 1;
}else{
	$cmss['count'] = 0;
	$cmss['show'] = 0;
}
$cmss['link'] = $core->U_controller.'?main_page='.urlencode('/cms/item-verify?verified=0');
$data[] = $cmss;

$json = p8_json($data);
if(P8_AJAX_REQUEST)exit($json);
echo 'var my_mesg='.$json .';';
exit();