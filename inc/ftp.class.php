<?php
defined('PHP168_PATH') or die();

class P8_Ftp{

var $host;
var $port;
var $user;
var $password;
var $dir;
var $timeout;
var $ssl;
var $link;
var $connected;

function P8_Ftp($host, $port, $user, $password, $dir = '/', $timeout = 60, $ssl = false){
	$this->host = $host;
	$this->port = $port;
	$this->user = $user;
	$this->password = $password;
	$this->dir = $dir;
	$this->timeout = $timeout ? $timeout : 60;
	$this->ssl = $ssl;
	$this->connected = false;
	
}

function connect(){
	if($this->connected) return 0;
	
	$this->link = $this->ssl ? 
		@ftp_ssl_connect($this->host, $this->port, $this->timeout) :
		@ftp_connect($this->host, $this->port, $this->timeout);
	
	if(!$this->link)
		return -1;
	
	if(!@ftp_login($this->link, $this->user, $this->password))
		return -2;
	
	$this->connected = true;
	register_shutdown_function(array(&$this, 'close'));
	return 0;
}

function mkdir($dir){
	return @ftp_mkdir($this->link, $dir);
}

function rmdir($dir){
	return @ftp_rmdir($this->link, $dir);
}

function put($local_file, $remote_file, $mode = FTP_BINARY, $startpos = 0){
	return @ftp_put($this->link, $remote_file, $local_file, $mode, $startpos);
}

function get($local_file, $remote_file, $mode, $resumepos = 0){
	$resumepos = intval($resumepos);
	return @ftp_get($this->link, $local_file, $remote_file, $mode, $resumepos);
}

function ls($dir){
	$list = @ftp_rawlist($this->link, $dir);
	
	$ret = array(
		'dir' => array(),
		'file' => array()
	);
	
	if(empty($list)) return $ret;
	
	foreach($list as $v){
		$v = preg_replace("/^(-|d).* ([^ ]+)$/", "\\1\\2", $v);
		if(substr($v, 0, 1) == 'd'){	//Ä¿Â¼
			$ret['dir'][] = substr($v, 1);
		}else{	//ÎÄ¼ş
			$ret['file'][] = substr($v, 1);
		}
	}
	return $ret;
}

function pwd(){
	return @ftp_pwd($this->link);
}

function size($remote_file){
	return @ftp_size($this->link, $remote_file);
}

function delete($file){
	return @ftp_delete($this->link, $file);
}

function pasv($pasv){
	return @ftp_pasv($this->link, $pasv);
}

function chdir($dir){
	return @ftp_chdir($this->link, $dir);
}

function site($cmd){
	return @ftp_site($this->link, $cmd);
}

function chmod($filename, $mode){
	return @ftp_chmod($this->link, $mode, $filename);
}

function close(){
	return @ftp_close($this->link);
}

}