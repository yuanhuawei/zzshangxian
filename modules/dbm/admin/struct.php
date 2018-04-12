<?php
defined('PHP168_PATH') or die();

/**
* 表结构管理
**/

$this_controller->check_admin_action('') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$name = isset($_GET['name']) ? $this_controller->valid_table_name($_GET['name']) : '';
	$name or message('access_denied');
	
	$tname = str_replace($core->CONFIG['table_prefix'], '', $name);
	$list = $this_module->table_struct($name,$tname);

	$collations = $this_module->collations();
	$properties = array('binary', 'unsigned', 'unsigned zerofill', 'on update current_timestamp');
	$types = array(
		'tinyint', 'smallint', 'mediumint', 'int', 'integer', 'bigint', 
		'bit', 'real', 'float', 'double', 'decimal', 'numberic', 
		'char', 'varchar', 
		'date', 'time', 'datetime', 'timestamp',
		'tinyblob', 'blob', 'mediumblob', 'longblob',
		'tinytext', 'text', 'mediumtext', 'longtext',
		'enum', 'set', 'binary'
	);
	$key_types = array('primary', 'unique', 'fulltext', '');
	
	$keys = $this_module->table_keys($name);
	
	include template($this_module, 'struct', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	exit;
	$action = isset($_POST['act']) ? $_POST['act'] : '';
	$name = isset($_POST['name']) ? $this_controller->valid_table_name($_POST['name']) : '';
	$_POST = p8_stripslashes2($_POST);
	
	switch($action){
	
	case 'drop_field':
		$fields = isset($_POST['field']) ? (array)$_POST['field'] : array();
		
		$this_module->drop_field($name, $fields);
	break;
	
	case 'drop_key':
		$keys = isset($_POST['key']) ? (array)$_POST['key'] : array();
		
		$this_module->drop_key($name, $fields);
	break;
	
	case 'field':
		$fields = isset($_POST['field']) ? (array)$_POST['field'] : array();
		
		foreach($fields as $v){
			if(
				!($v = trim($this_controller->valid_table_name($v))) ||
				!isset($_POST['name'][$v]) || !isset($_POST['type'][$v])
			) continue;
			
			$n = $this_controller->valid_table_name($_POST['name'][$v]);
			
			$field = array(
				'name' => $n,
				'null' => empty($POST['null'][$v]) ? 0 : 1,
				'type' => isset($POST['type'][$v]) ? $POST['type'][$v] : '',
				'length' => isset($POST['length'][$v]) ? $POST['length'][$v] : '',
				'property' => isset($POST['property'][$v]) ? $POST['property'][$v] : '',
				'extra' => isset($POST['extra'][$v]) ? $POST['extra'][$v] : '',
				'default' => isset($POST['default'][$v]) ? $POST['default'][$v] : '',
				'collation' => isset($POST['collation'][$v]) ? $POST['collation'][$v] : '',
			);
			$data[$n] = $this_controller->valid_field_data($field);
		}
		
		$this_module->change_field($name, $data);
	break;
	
	case 'replace':
		@set_time_limit(0);
		
		$tables = isset($_POST['tables']) ? (array)$_POST['tables'] : array();
		
		$search = isset($_POST['search']) ? p8_stripslashes2($_POST['search']) : '';
		$replace = isset($_POST['replace']) ? p8_stripslashes2($_POST['replace']) : '';
		
		$this_module->table_replace($tables, $search, $replace);
	break;
	
	case 'key':
		$keys = isset($_POST['key']) ? (array)$_POST['key'] : array();
		
		foreach($keys as $v){
			$n = $this_controller->valid_table_name($_POST['name'][$v]);
			
			$key = array(
				'name' => $n,
				'type' => isset($POST['type'][$v]) ? $POST['type'][$v] : '',
				'field' => isset($POST['field'][$v]) ? $POST['field'][$v] : array(),
			);
			$data[$n] = $this_controller->valid_key_data($key);
		}
		
		$this_module->change_key($name, $data);
	break;
	
	}
	
	message('done', HTTP_REFERER);
	
}