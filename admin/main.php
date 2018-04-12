<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$db_version = $DB_master->version();

	$systems = $core->list_systems();
	$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
	$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
	$countCmsToday['count'] = $countCmsMonth['count'] = $countCmsUnverified['count'] = 0;
	$countSitesToday['count'] = $countSitesUnverified['count'] = 0;
	if(isset($systems['cms'])){
		$cms = $core->load_system('cms');
		$item = $cms->load_module('item');
		$countCmsToday = $DB_master->fetch_one("select count(*) as count from ".$item->main_table." where `timestamp`>".$beginToday);
		$countCmsMonth = $DB_master->fetch_one("select count(*) as count from ".$item->main_table." where `timestamp`>".$beginThismonth);
		$countCmsUnverified = $DB_master->fetch_one("select count(*) as count from ".$item->unverified_table);
		
		$listdb = $DB_master->fetch_all("select * from ".$item->main_table." ORDER BY id DESC limit 9");
		
		foreach($listdb as $key => $val){
			$listdb[$key]['title']=p8_cutstr($listdb[$key]['title'],68);
			$listdb[$key]['url']=$item->controller."-view-id-".$val['id'];
			$listdb[$key]['edit']=$core->admin_controller."/cms/item-update?id=$val[id]&model=$val[model]&verified=1";
			$listdb[$key]['delete']=$core->admin_controller."/cms/item-delete?id=$val[id]&model=$val[model]&verified=1";
		}
		$listdb2 = $DB_master->fetch_all("select * from ".$item->unverified_table." WHERE verified != -99 ORDER BY id DESC limit 8");
		
		foreach($listdb2 as $key => $val){
			$listdb2[$key]['title']=p8_cutstr($listdb2[$key]['title'],48);
			$listdb2[$key]['url']=$item->controller."-view-id-".$val['id']."?verified=0";
			$listdb2[$key]['edit']=$core->admin_controller."/cms/item-update?id=$val[id]&model=$val[model]&verified=0";
			$listdb2[$key]['delete']=$core->admin_controller."/cms/item-delete?id=$val[id]&model=$val[model]&verified=0";
		}
	}
	if(isset($systems['sites'])){
		$sites = $core->load_system('sites');
		$item = $sites->load_module('item');
		$countSitesToday = $DB_master->fetch_one("select count(*) as count from ".$item->main_table." where `timestamp`>".$beginToday);
		$countSitesMonth = $DB_master->fetch_one("select count(*) as count from ".$item->main_table." where `timestamp`>".$beginThismonth);
		$countSitesUnverified = $DB_master->fetch_one("select count(*) as count from ".$item->unverified_table);
	}
	if(is_file(PHP168_PATH.'data/installcache.lock'))$cache = true;
	include template($core, 'main', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	if(isset($_POST['detect_ssi'])){
		write_file(CACHE_PATH .'ssi.html', 'ssi');
		write_file(CACHE_PATH .'ssi.shtml', '<!--#include virtual="ssi.html"-->');
		
		$core->set_config(array('ssi' => file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/data/ssi.shtml') == 'ssi'));
	}
	
	message('done');
}