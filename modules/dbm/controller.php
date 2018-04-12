<?php
defined('PHP168_PATH') or die();

class P8_DBM_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_DBM_Controller(&$obj){
	$this->__construct($obj);
}

function valid_table_name($name){
	return preg_replace('/[^0-9a-zA-Z_\-]/', '', $name);
}

function valid_field_data(&$POST){
	$data = array(
		'name' => addslashes(trim($POST['name'])),
		'null' => empty($POST['null']) ? 0 : 1,
		'type' => isset($POST['type']) ? addslashes($POST['type']) : '',
		'length' => isset($POST['length']) ? $POST['length'] : '',
		'property' => isset($POST['property']) ? addslashes($POST['property']) : '',
		'extra' => isset($POST['extra']) ? addslashes($POST['extra']) : '',
		'default' => isset($POST['default']) ? addslashes($POST['default']) : '',
		'collation' => isset($POST['collation']) ? addslashes($POST['collation']) : '',
	);
	
	if(in_array($data['type'], array('tinytext', 'text', 'mediumtext', 'longtext', 'tinyblob', 'blob', 'mediumblob', 'longblob'))){
		$data['length'] = '';
	}
	
	return $data;
}

function valid_key_data(&$POST){
	$data = array(
		'name' => $POST['name'],
		'type' => $POST['type'],
	);
	$fields = isset($POST['field']) ? (array)$_POST['field'] : array();
	$data['field'] = $comma = '';
	foreach($fields as $v){
		$v = addslashes($v);
		$data['field'] .= "$comma`$v`";
		$comma = ',';
	}
	
	return $data;
}

}