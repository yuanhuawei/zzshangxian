<?php
defined('PHP168_PATH') or die();

//P8_Forms::html($id)
	if(empty($id)) return false;
	
	foreach($GLOBALS as $k => $v){
		global $$k;
	}
	global $this_model;
	
	require_once PHP168_PATH .'inc/html.func.php';
	
	defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);
	
	$this->_html['query'] = $this->DB_slave->query("SELECT * FROM $this->model_table WHERE id IN (". implode(',', $id) .")");
	
	$__tmp__ = $this->CONFIG['htmlize'];
	$this->CONFIG['htmlize'] = 1;
	$__uri__ = '/index.php/'. $SYSTEM .'/'. $MODULE .'-post';
	while($__data__ = $this->DB_slave->fetch_array($this->_html['query'])){
		$_REQUEST['mid'] = $__data__['id'];
		$_SERVER['_REQUEST_URI'] = $__uri__;
		
		$this->_html['file'] = p8_html_url($this, $__data__, 'post');
		
		ob_start();
		require PHP168_PATH .'index.php';
		$__content__ = ob_get_clean();
		
		write_file($this->_html['file'], $__content__);
	}
	$this->CONFIG['htmlize'] = $__tmp__;
	
	return true;