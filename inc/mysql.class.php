<?php

class P8_mysql{

var $connected = false;
var $link;
var $query_num = 0;
var $version;

var $host, $user, $password, $db, $charset, $pconnect, $port;

function P8_mysql($host, $user, $password, $db, $charset = 'utf8', $port = 0, $pconnect = false){
	$this->host = $host;
	$this->user = $user;
	$this->password = $password;
	$this->db = $db;
	$this->charset = $charset;
	$this->pconnect = $pconnect;
	$this->port = $port ? $port : 3306;
}

function connect(){
	if($this->connected) return 0;
	
	$_host = $this->port ? $this->host .':'. $this->port : $this->host;	//支持3306以外的端口
	
	$this->link = $this->pconnect ? @mysql_pconnect($_host, $this->user, $this->password) : @mysql_connect($_host, $this->user, $this->password, true);
	
	if(!$this->link) return -1;
	$this->connected = true;
	
	if($this->version() > '4.1'){
		$serverset = $this->charset ? "character_set_connection='$this->charset',character_set_results='$this->charset',character_set_client=binary" : '';
		$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
		$serverset && mysql_query("SET $serverset", $this->link);
	}
	
	if($this->db && !mysql_select_db($this->db, $this->link)){
		return -2;
	}
	
	//register_shutdown_function(array(&$this, 'close'));
	
	return 0;
}

function select_db($db){
	if($this->connected) return @mysql_select_db($db, $this->link);
	
	return false;
}

function query($query, $type = ''){
	if(!$this->connected) $this->connect();
	//echo "$query<br />\r\n";
	$this->query_num++;
	$result = $type == 'U_B' ? mysql_unbuffered_query($query, $this->link) : mysql_query($query, $this->link);
	if(defined('SQL_DEBUG')){
		//if($this->errno()){
			$fp = fopen(CACHE_PATH .'debug_sql.txt', 'a');
			fputs($fp, date('Y-m-d H:i:s', P8_TIME) ."\t". $this->errno() .":". $this->error() ."\t". $query ."\r\n");
			fclose($fp);
		//}
	}
	//数据库报错提示,方便调式与追查原因!
	if(!$result){
		global $core;
		if(empty($core->CONFIG['debug'])) return $result;
		
		echo mysql_error($this->link)."<br>\r\n";
		echo '<font color=red>SQL ERROR:</font>'.$query."<br>\r\n<pre>";
		foreach(debug_backtrace() as $v){
			echo "$v[file]: $v[line]\r\n";
		}
		echo "\r\n</pre><br>";
		//exit;
	}
	return $result;
}

function fetch_array($query, $type = MYSQL_ASSOC){
	return mysql_fetch_array($query, $type);
}

function fetch_one($query){
	$result = $this->fetch_array($this->query($query));
	return $result ? $result : array();
}

function fetch_all($query){
	$que = $this->query($query);
	$ret = array();
	while($arr = $this->fetch_array($que)){
		$ret[] = $arr;
	}
	$this->free_result($que);
	return $ret;
}

function affected_rows() {
	return mysql_affected_rows($this->link);
}

function insert_id()
{
	return mysql_insert_id($this->link);
}

function fetch_row($query) {
	return mysql_fetch_row($query);
}

function fetch_fields($query) {
	$num = mysql_num_fields($query);
	$ret = array();
	for($i = 0; $i < $num; $i++)
		$ret[$i] = mysql_field_name($query, $i);
		
	return $ret;
}

function error(){
	return mysql_error($this->link);
}

function errno(){
	return mysql_errno($this->link);
}

function escape_string($s){
	if(is_array($s)){
		foreach($s as $k => $v){
			$s[$k] = $this->escape_string($v);
		}
		return $s;
	}return addslashes($s);
	return $this->version() > '4.1' ? mysql_real_escape_string($s, $this->link) : mysql_escape_string($s);
}

function version(){
	if(!empty($this->version)) return $this->version;
	if(!$this->connected) $this->connect();
	
	$this->version = @mysql_get_server_info($this->link);
	return $this->version;
}

function close(){
	$this->connected = false;
	return @mysql_close($this->link);
}

function free_result($r){
	return mysql_free_result($r);
}

/**
* 插入数据到数据库
* @param string $table 要插入的表
* @param array $datas 要插入的数据,如果是多行插入,$datas为字段列表
* ------------------
* 单行$datas = array('id' => 1, 'cid' => 2);
* insert('t', $datas)
* insert('t', $datas, true);	加第3个参数证明是replace into
* ------------------
* 多行例子
* $fields = array('id', 'cid');
* $data = array(array(1, 2), array(3, 4));
* insert($table, $fields, $data)
* insert($table, $fields, $data, true);	加第4个参数证明是replace into
**/
function insert($table, $datas, $option = array('multiple' => array(), 'replace' => false)){
	if(empty($datas)) return false;
	
	$SQL = empty($option['replace']) ? "INSERT INTO $table " : "REPLACE INTO $table ";
	
	if(empty($option['multiple'])){
		$fields = $comma = $values = '';
		foreach($datas as $k => $v){
			$fields .= $comma . '`'. $k .'`';
			$values .= "$comma'$v'";
			$comma = ',';
		}
		$SQL .= '('. $fields .') VALUES ('. $values .')';
	}else{
		$fields = $comma = '';
		foreach($option['multiple'] as $v){
			$fields .= $comma . $v;
			$comma = ',';
		}
		$SQL .= "($fields) VALUES ";
		
		$comma = '';
		foreach($datas as $v){
			$values = $_comma = '';
			$values .= $comma .'(';
			
			foreach($v as $vv){
				$values .= "$_comma'$vv'";
				$_comma = ',';
			}
			$SQL .= $values .= ')';
			$comma = ',';
		}
	}
	//echo $SQL;
	$status = $this->query($SQL);
	
	//$id = $this->insert_id();
	return empty($option['return_id']) ? $status : $this->insert_id();
	
	//return $id ? $id : $status;
}

/**
* 更新表
* @param string $table 要更新的表
* @param array $datas 要更新的字段及数据映射数组
* @param object|string 要更新的条件,可以直接写a = 1也可以传个用select对象构造的条件
* @param bool 是否把值括起来,如果不括,可以写灵活点的SQL,如a = a+1
* @return int 受影响的条数
**/
function update($table, $datas, $select, $quote = true){
	
	if(empty($datas)) return false;
	
	$SQL = "UPDATE $table SET ";
	$comma = '';
	foreach($datas as $k => $v){
		if($quote)
			$SQL .= "$comma`$k`='$v'";
		else
			$SQL .= "$comma`$k`=$v";
		
		$comma = ',';
	}

	if(is_object($select)){
		$SQL .= $select->build_where() . $select->build_order() . $select->build_limit();
	}else{
		$SQL .= empty($select) ? '' : " WHERE ". $select;
	}
	//echo $SQL;
	$status = $this->query($SQL);
	$rows = $this->affected_rows();return $rows;
	return $rows ? $rows : $status;
}

/**
* 删除数据
* @param string $table 要删除数据的表
* @param object|string 删除的条件,可以直接写a = 1 AND b = 2,也可以传个用select对象构造的条件
* @return int 受影响的条数
**/
function delete($table, $select){
	$SQL = "DELETE FROM $table ";
	
	if(is_object($select)){
		$SQL .= $select->build_where() . $select->build_order() . $select->build_limit();
	}else{
		$SQL .= empty($select) ? '' : " WHERE ". $select;
	}
	$status = $this->query($SQL);
	$rows = $this->affected_rows();return $rows;
	return $rows ? $rows : $status;
}

}