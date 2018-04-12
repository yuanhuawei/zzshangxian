<?php
defined('PHP168_PATH') or die();

$this_module->set_model($ROLE_GROUP);
$this_module->get_member_info($UID);

$cs=$core->load_module('cservice');
$csinfo=$cs->get_my_info();
$message=$core->load_module('message');
$message->my_message();

$cms = $core->load_system('cms');
$item = $cms->load_module('item');
$listdb = $DB_master->fetch_all("select * from ".$item->main_table." WHERE `username` = '$USERNAME' ORDER BY id DESC limit 5");
	
foreach($listdb as $key => $val){
	$listdb[$key]['full_title']=$listdb[$key]['title'];
	$listdb[$key]['title']=p8_cutstr($listdb[$key]['title'],48);
	$listdb[$key]['url']=$item->controller."-view-id-".$val['id'];
	$listdb[$key]['edit']=$core->U_controller."/cms/item-update?id=$val[id]&model=$val[model]&verified=1";
	$listdb[$key]['addon']=$core->U_controller."/cms/item-addon?iid=$val[id]&model=$val[model]&verified=1";
}

include template($this_module, 'center');
