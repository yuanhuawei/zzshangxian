<?php
defined('PHP168_PATH') or die();

class P8_DBM extends P8_Module{

var $_fields = array();

function __construct(&$system, $name){
	$this->system = &$system;
	$this->configurable = false;
	//不可配置
	parent::__construct($name);
	
}

function P8_DBM(&$system, $name){
	$this->__construct($system, $name);
}

function table_status($table = ''){
	return $this->DB_master->fetch_all("SHOW TABLE STATUS". ($table ? " LIKE '$table'" : ''));
}

/**
* 表结构
**/
function table_struct($table,$tname){
	$query = $this->DB_master->query("SHOW FULL FIELDS FROM `$table`");
	$list = array();
	$k = 0;
	while($arr = $this->DB_master->fetch_array($query)){
		$list[$k] = $arr;
		if(preg_match('/([^(]+)(?:\(([^\)]+)\))?(?:\s*(\w*))?/', $arr['Type'], $m)){
			$list[$k]['Type'] = strtolower($m[1]);
			$list[$k]['Length'] = $m[2];
			$list[$k]['Property'] = strtolower($m[3]);
		}
		$Field = $list[$k]['Field'];
		$list[$k]['Extra'] = strtolower($arr['Extra']);		
		$aliasname = include $this_module->path .'admin/tables/'.$tname.'.php';	
		$list[$k]['aliasname'] = $aliasname[$Field];		
		$k++;
	}
	
	return $list;
}

/**
* 表索引
**/
function table_keys($table){
	$query = $this->DB_master->query("SHOW KEYS FROM `$table`");
	$keys = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$k = $arr['Key_name'];
		$keys[$k]['field'] = isset($keys[$k]) ? 
			$keys[$k]['field'] .','. $arr['Column_name'] :
			$arr['Column_name'];
		
		$keys[$k]['unique'] = empty($arr['Non_unique']);
		
		if($k == 'PRIMARY'){
			$keys[$k]['type'] = 'primary';
		}else if($keys[$k]['unique']){
			$keys[$k]['type'] = 'unique';
		}else if($arr['Index_type'] == 'FULLTEXT'){
			$keys[$k]['type'] = 'fulltext';
		}else{
			$keys[$k]['type'] = '';
		}
	}
	
	return $keys;
}

function tables($table){
	$tables = $comma = '';
	foreach((array)$table as $v){
		$tables .= "$comma`$v`";
		$comma = ',';
	}
	
	return $tables;
}

/**
* 修复表
**/
function repair_table($table){
	$tables = $this->tables($table);
	if(!$tables) return;
	
	return $this->DB_master->query("REPAIR TABLE $tables");
}

/**
* 优化表
**/
function optimize_table($table){
	$tables = $this->tables($table);
	if(!$tables) return;
	
	return $this->DB_master->query("OPTIMIZE TABLE $tables");
}

/**
* 删表
**/
function drop_table($table){
	$tables = $this->tables($table);
	if(!$tables) return;
	
	return $this->DB_master->query("DROP TABLE $tables");
}

/**
* 删字段
**/
function drop_field($table, $field){
	$fields = $comma = '';
	foreach((array)$table as $v){
		$fields .= "$comma DROP `$v`";
		$comma = ',';
	}
	if(!$fields) return;
	
	return $this->DB_master->query("ALTER TABLE `$table` $fields");
}

/**
* 修改字段
**/
function change_field($table, $fields){
	$s = $comma = '';
	foreach((array)$fields as $field => $data){
		if(!strlen( $data['name'] = trim($data['name']) )) continue;
		
		$collate = empty($data['collation']) ? '' : 'COLLATE '. $data['collate'];
		$null = empty($data['null']) ? 'NOT NULL' : 'NULL';
		$length = strlen($data['length']) ? '('. $data['length'] .')' : '';
		$s .= "$comma CHANGE `$field` `$data[name]` $data[type] $length $collate $null $data[property] $data[extra]";
		$comma = ',';
	}
	if(!$s) return;
	
	return $this->DB_master->query("ALTER TABLE `$table` $s");
}

/**
* 表字符替换
**/
//function field_replace($table, $data){
function table_replace($table, $search, $replace){
	$search = $this->DB_master->escape_string($search);
	$replace = $this->DB_master->escape_string($replace);
	
	foreach((array)$table as $v){
		$struct = $this->table_struct($v);
		$sql = $comma = '';
		foreach($struct as $vv){
			$sql .= "$comma`$vv[Field]` = REPLACE(`$vv[Field]`, '$search', '$replace')";
			$comma = ',';
		}
		
		$this->DB_master->query("UPDATE `$v` SET ". $sql);
	}
	if(!$sql) return false;
}

function change_key($table, $keys){
	$s = $comma = '';
	foreach((array)$keys as $key => $data){
		if(empty($data['field'])) continue;
		
		$s .= "$comma DROP INDEX `$key`, ADD $data[type] INDEX `$data[name]` ($data[field])";
	}
	if(!$s) return;
	
	return $this->DB_master->query("ALTER TABLE `$table` $s");
}

/**
* 删除索引
**/
function drop_key($table, $keys){
	$keys = $comma = '';
	foreach((array)$table as $v){
		$keys .= "$comma DROP KEY `$v`";
		$comma = ',';
	}
	if(!$keys) return;
	
	return $this->DB_master->query("ALTER TABLE `$table` $keys");
}

/**
* 清空表
**/
function truncate_table($table){
	$tables = $this->tables($table);
	if(!$tables) return;
	
	return $this->DB_master->query("TRUNCATE TABLE $tables");
}

/**
* 字符集
**/
function charsets(){
	if(empty($this->charsets)){
		$query = $this->DB_master->query('SHOW CHARACTER SET');
		while($arr = $this->DB_master->fetch_array($query)){
			$this->charsets[] = $arr['Charset'];
		}
	}
	
	return $this->charsets;
}

/**
* 字符整理
**/
function collations(){
	if(empty($this->collations)){
		foreach($this->charsets() as $c){
			$query = $this->DB_master->query("SHOW COLLATION LIKE '$c%'");
			while($arr = $this->DB_master->fetch_array($query)){
				$this->collations[$c][] = $arr['Collation'];
			}
		}
	}
	
	return $this->collations;
}

/**
* 备份
* @param string $table 表名
* @param int $rows 行数
* @param int $offset 偏移
* @param string $charset 字符集
**/
function backup($table, $param = array('rows' => 1000, 'offset' => 0, 'charset' => '', 'prefix' => '')){
	
	$new_table = empty($param['prefix']) ? $table : str_replace($this->core->CONFIG['table_prefix'], $param['prefix'], $table);
	
	$ret = array('sql' => 'INSERT INTO `'. $new_table .'` VALUES ');
	
	$primary = isset($param['primary']) ? $param['primary'] : '';
	
	if($primary){
		$sql = "SELECT * FROM `$table`". (isset($param['last_max']) ? " WHERE `$primary` > $param[last_max] " : '') ." ORDER BY $primary ASC LIMIT $param[rows]";
		$ret['primary'] = $primary;
		$ret['last_max'] = null;
	}else{
		$sql = "SELECT * FROM `$table` LIMIT $param[offset],$param[rows]";
	}
	$ret['_sql'] = $sql;
	$query = $this->DB_master->query($sql);
	
	$i = 0;
	$comma = '';
	$charset = !empty($param['charset']) && $param['charset'] != $this->core->CONFIG['page_charset'] ? $param['charset'] : '';
	while($data = $this->DB_master->fetch_array($query)){
		$datas = $comma2 = '';
		
		if($primary){
			$ret['last_max'] = max($ret['last_max'], $data[$primary]);
		}
		
		foreach($data as $v){
			if($charset){
				//不解释,你懂的
				if(preg_match('/^a:\d+:\{/', $v)){
					if(($_v = mb_unserialize($v)) !== false){
						//really unserializable
						$v = serialize(convert_encode($this->core->CONFIG['page_charset'], $charset, $_v));
						unset($_v);
					}
				}else{
					$v = convert_encode($this->core->CONFIG['page_charset'], $charset, $v);
				}
			}
			
			$v = $this->DB_master->escape_string($v);
			$v = str_replace("\r\n", '\r\n', $v);
			$v = str_replace("\n", '\n', $v);
			$datas .= "$comma2'$v'";
			$comma2 = ',';
		}
		
		$ret['sql'] .= "$comma($datas)";
		
		$comma = ',';
		$i++;
	}
	$this->DB_master->free_result($query);
	
	$ret['sql'] = $i ? $ret['sql'] .= ";\r\n" : '';
	return $ret;
}

}