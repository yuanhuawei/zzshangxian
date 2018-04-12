<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){
	$name = isset($_GET['n'])?$_GET['n']:'';
	$id = isset($_GET['id'])?intval($_GET['id']):0;
	$page = isset($_GET['p'])?intval($_GET['p']):0;
	$page = max(1, $page);

	global $__label;
	global $SYSTEM, $MODULE, $LABEL_POSTFIX, $LABEL_PAGE; 
	$MODULE = 'core';
	$this_module->init($SYSTEM, $MODULE, $LABEL_PAGE);
	//$this_module->postfix(isset($LABEL_POSTFIX) ? $LABEL_POSTFIX : array());
	$this_module->get_data_cache();
	
	$label = $this_module->display($name);
	
	$label = str_replace(array("'","\r\n","\r"),array("\'",' ',' '),$label);
	echo "document.write('".$label."');";
	exit;
}else if(REQUEST_METHOD == 'POST'){
	exit;
	
}