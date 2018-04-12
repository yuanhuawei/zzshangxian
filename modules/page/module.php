<?php
defined('PHP168_PATH') or die();

class P8_Page extends P8_Module{

var $table;
var $table_page;

function P8_Page(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->table_page = $this->TABLE_ . "page";
}

function add($data){
	
	$id = $this->DB_master->insert(
		$this->table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	
	$this->html($this->DB_master->query("SELECT * FROM $this->table WHERE id = '$id'"));
	
	return $id;
}

function edit($data){
	
	$status = $this->DB_master->update(
		$this->table, 
		$this->DB_master->escape_string($data),
		"id='". $data['id']."'"
	);
	
	$this->html($this->DB_master->query("SELECT * FROM $this->table WHERE id = '$data[id]'"));
	
	return $status;
}

function delete($id){
	$this->DB_master->delete(
		$this->table,
		"id='". $id."'"
	);
}

function addcontent($data){
	$this->DB_master->update(
		$this->table, 
		array(
			
			'content' => $data['content']
		),
		"id='". $data['id']."'"
	);
}

function html($query){
	defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);
	global $LABEL_POSTFIX;
	require_once PHP168_PATH .'inc/html.func.php';
	
	foreach(array_keys($GLOBALS) as $v){
		global $$v;
	}
	
	while($__arr__ = $DB_master->fetch_array($query)){
		$id = $__arr__['id'];
		$__file__ = p8_html_url($this_module, $__arr__, 'view');
		$basename = basename($__file__);
		$path = str_replace($basename, '', $__file__);
		md($path);
		
		$__view_uri__ = '/index.php/core/page-view-id-{$id}';
		eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__view_uri__ .'";');
		ob_start();
		require PHP168_PATH .'index.php';
		$content = ob_get_clean();
		
		write_file($__file__, $content);
	}
}

}