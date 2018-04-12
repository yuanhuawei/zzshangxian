<?php
defined('PHP168_PATH') or die();

$sms = &$core->load_module('sms');

require $sms->path .'interface//crontab.php';


$int = $sms->load_interface($name);

$callback = $int->fetch();

foreach($callback as $v){
	$v['sender'] 
	
	$ret = array();
	if(preg_match('/\{\[\(([^\)]+?)\)\]\}/', $v['mt'], $m)){
		
	}
	
	$sms->callback_parse($v['mt']);
	
	if(){
		
	}
}
