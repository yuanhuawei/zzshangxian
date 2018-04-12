<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action('list') or message('no_privilege');
GetGP(array('begintime','endtime','department','type','act'));
$cates = $this_module->get_category();
$_begintime = $begintime? strtotime($endtime):'';
$_endtime = $endtime? strtotime($begintime):'';

$list = $this_module->getstatistics($_begintime,$_endtime);
if($act=='download'){
	$dodata = array();
	foreach($cates['department'] as $key=>$row){
		$line=array();
		$line[] = $row['name'];
		 foreach($cates['type'] as $k=>$v){
			$line[] = ($list[$key][$k]['total']?$list[$key][$k]['total']:0).' \ '.($list[$key][$k]['solve']?$list[$key][$k]['solve']:0);
		}
		$line[] = ($list['total'][$key]['total']?$list['total'][$key]['total']:0).' \ '.($list['total'][$key]['solve']?$list['total'][$key]['solve']:0);
		$dodata[] = $line;	 
	}
	$line2[] = $P8LANG['all'];
	foreach($cates['type'] as $k=>$v){
		$line2[]=($list['total'][$k]['total']?$list['total'][$k]['total']:0).' \ '.($list['total'][$k]['solve']?$list['total'][$k]['solve']:0);	
	}
	$dodata[] = $line2;
	
	$headertext=array('');
	foreach($cates['type'] as $key=>$row){
		$headertext[] = $row['name'];
	}
	$headertext[] = $P8LANG['all'];
	
	require PHP168_PATH.'/inc/excel.class.php';
	$export=new excel(1);
	$export->setFileName('letter_statistic','download',date('Y-m-d-h-i-s', P8_TIME));
	$export->fileHeader($headertext);		
	$export->fileData($dodata);
	$export->fileFooter();
	$export->exportFile();
}
//print_r($list);
include template($this_module, "statistics", 'admin');