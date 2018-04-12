<?php
defined('PHP168_PATH') or die();

	$date = isset($_GET['date'])?$_GET['date']:date('Y-m-d');
	$w = date('w',strtotime($date));
	
	$w = $P8LANG['week_'.($w?$w:7)];
	$nextdate = date('Y-m-d',time()+86400);
	
	$predate = date('Y-m-d',strtotime($date)-86400);
	$nextdate = date('Y-m-d',strtotime($date)+86400);
	$url = $this_plugin->controller;
	$list = $this_plugin->get_date($date);
	//用数据包含模板取得标签内容
		ob_start();
		include $this_plugin->template('_display');
		$content = ob_get_clean();
	echo $content;

?>