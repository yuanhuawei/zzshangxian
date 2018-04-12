<?php

class P8_mysqli{

var $connected = false;
var $link;
var $query_num = 0;
var $version;

var $host, $user, $password, $db, $charset, $pconnect, $port;

function P8_mysqli($host, $user, $password, $db, $charset = 'gbk', $port = 3306){
	$this->host = $host;
	$this->user = $user;
	$this->password = $password;
	$this->db = $db;
	$this->charset = $charset;
	$this->port = $port ? $port : 3306;
}

function connect(){
	if($this->connected) return true;
	
	$this->link = mysqli_connect($this->host, $this->user, $this->password, $this->db, $this->port);
	
	if($this->link === false) return -1;
	$this->connected = true;
	
	if($this->version() > '4.1'){
		$serverset = $this->charset ? "character_set_connection='$this->charset',character_set_results='$this->charset',character_set_client=binary" : '';
		$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
		$serverset && mysqli_query($this->link, "SET $serverset");
	}
	
	/* if($this->db && !mysqli_select_db($this->db, $this->link)){
		die('');
	} */
	
	//register_shutdown_function(array(&$this, 'close'));
	
	return true;
}

function select_db($db){
	if($this->connected)
		return mysqli_select_db($this->link, $db);
	return false;
}

function query($query, $type = ''){
	if(!$this->connected) $this->connect();
	//echo "$query<br />\r\n";
	$this->query_num++;
	$result = mysqli_query($this->link, $query);
	if(defined('SQL_DEBUG')){
		//if($this->errno()){
			$fp = fopen(CACHE_PATH .'debug_sql.txt', 'a');
			fputs($fp, date('Y-m-d H:i:s', P8_TIME) ."\t". $this->errno() .":". $this->error() ."\t". $query ."\r\n");
			fclose($fp);
		//}
	}
	//���ݿⱨ����ʾ,�����ʽ��׷��ԭ��!
	if(!$result){
		global $core;
		if(empty($core->CONFIG['debug'])) return $result;
		
		echo mysqli_error($this->link)."<br>\r\n";
		echo '<font color=red>SQL ERROR:</font>'.$query."<br>\r\n<pre>";
		foreach(debug_backtrace() as $v){
			echo "$v[file]: $v[line]\r\n";
		}
		echo "\r\n</pre><br>";
		//exit;
	}
	return $result;
}

function fetch_array($query, $type = MYSQLI_ASSOC){
	return mysqli_fetch_array($query, $type);
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
	return mysqli_affected_rows($this->link);
}

function insert_id()
{
	return mysqli_insert_id($this->link);
}

function fetch_row($query) {
	return mysqli_fetch_row($query);
}

function fetch_fields($query) {
	$fs = mysqli_fetch_fields($query);
	$ret = array();
	foreach($fs as $k => $v)
		$ret[$k] = $v->name;
	return $ret;
}

function error(){
	return mysqli_error($this->link);
}

function errno(){
	return mysqli_errno($this->link);
}

function escape_string($s){
	if(is_array($s)){
		foreach($s as $k => $v){
			$s[$k] = $this->escape_string($v);
		}
		return $s;
	}
	return $this->version() > '4.1' ? mysqli_real_escape_string($this->link, $s) : mysql_escape_string($s);
}

function version(){
	if(!empty($this->version)) return $this->version;
	if(!$this->connected) $this->connect();
	
	$this->version = mysqli_get_server_info($this->link);
	return $this->version;
}

function close(){
	$this->connected = false;
	return @mysqli_close($this->link);
}

function free_result($r){
	return mysqli_free_result($r);
}

/**
* �������ݵ����ݿ�
* @param string $table Ҫ����ı�
* @param array $datas Ҫ���������,����Ƕ��в���,$datasΪ�ֶ��б�
* ------------------
* ����$datas = array('id' => 1, 'cid' => 2);
* insert('t', $datas)
* insert('t', $datas, true);	�ӵ�3������֤����replace into
* ------------------
* ��������
* $fields = array('id', 'cid');
* $data = array(array(1, 2), array(3, 4));
* insert($table, $fields, $data)
* insert($table, $fields, $data, true);	�ӵ�4������֤����replace into
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
* ���±�
* @param string $table Ҫ���µı�
* @param array $datas Ҫ���µ��ֶμ�����ӳ������
* @param object|string Ҫ���µ�����,����ֱ��дa = 1Ҳ���Դ�����select�����������
* @param bool �Ƿ��ֵ������,�������,����д�����SQL,��a = a+1
* @return int ��Ӱ�������
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
* ɾ������
* @param string $table Ҫɾ�����ݵı�
* @param object|string ɾ��������,����ֱ��дa = 1 AND b = 2,Ҳ���Դ�����select�����������
* @return int ��Ӱ�������
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