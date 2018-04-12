<?php
defined('PHP168_PATH') or die();

class P8_Mail extends P8_Module{

var $queue_table;	//队列表
var $send_type;		//发送类型
var $send_to;		//发送给
var $_send_to;		//发送给

var $subject;		//标题
var $_subject;		//标题
var $message;		//内容
var $_message;		//内容

var $server;		//smtp 服务器
var $port;			//smtp 端口
var $email;			//发送者
var $password;		//密码

var $headers;		//发送头部
var $CRLF;			//换行符

function __construct(&$system, $name){
	$this->system = &$system;

	parent::__construct($name);
	
	$this->send_type = empty($this->CONFIG['send_type']) ? 'smtp' : $this->CONFIG['send_type'];
	$this->headers = '';
	$this->queue_table = $this->TABLE_ .'queue';
}

function P8_Mail(&$system, $name){
	$this->__construct($system, $name);
}

/**
* @param string $email 发送者
* @param string $password 发送者密码
* @param string $subject 标题
* @param string $message 内容
* @param string $server 服务器地址
* @param string $port 服务器端口
**/
function set($param){
	
	//账户信息
	$this->email = empty($param['email']) ? $this->CONFIG['email'] : $param['email'];
	//$this->_email = preg_match('/^(.+?) \<(.+?)\>$/',$this->email, $m) ? ($this->email ? '=?'. $this->core->CONFIG['page_charset'] .'?B?'.base64_encode($m[1])."?= <$m[2]>" : $m[2]) : $this->email;
	$this->password = empty($param['password']) ? $this->CONFIG['password'] : $param['password'];
	//账户信息
	
	//必需参数
	$this->send_to = $param['send_to'];
	$mails = array_filter(array_map('trim', explode(',', $this->send_to)));
	$this->_send_to = $comma = '';
	foreach($mails as $v){
		$this->_send_to .= $comma;
		$this->_send_to .= preg_match('/^(.+?) \<(.+?)\>$/',$v, $m) ? ($this->email ? '=?'. $this->core->CONFIG['page_charset'] .'?B?'. base64_encode($m[1]) ."?= <$m[2]>" : $m[2]) : $v;
		$comma = ',';
	}
	
	$this->subject = $param['subject'];
	$this->_subject = "=?{$this->core->CONFIG['page_charset']}?B?". base64_encode(str_replace(array("\r","\n"), array('',' '),$this->subject)) .'?=';
	
	$this->message = $param['message'];
	$this->_message = chunk_split(base64_encode(str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $this->message)))))));
	//必需参数
	
	//服务器相关
	$this->server = empty($param['server']) ? $this->CONFIG['server'] : $param['server'];
	$this->port = empty($param['port']) ? $this->CONFIG['port'] : $param['port'];
	//服务器相关
	
	$CRLF = empty($param['CRLF']) ? $this->CONFIG['CRLF'] : $param['CRLF'];
	
	switch($CRLF){
	
	case 'rn': $this->CRLF = "\r\n"; break;
	case 'n': $this->CRLF = "\n"; break;
	case 'r': $this->CRLF = "\r"; break;
	
	}
	
	$this->headers = "From: {$this->email}{$this->CRLF}MIME-Version: 1.0{$this->CRLF}Content-type: text/html; charset={$this->core->CONFIG['page_charset']}{$this->CRLF}Content-Transfer-Encoding: base64{$this->CRLF}";
	
}

/**
* 发送
* @param bool $queue 是否入队待发送,false为立即发送
**/
function send($queue = false){
	
	if($queue){
		$this->DB_master->insert(
			$this->queue_table,
			array(
				'email' => $this->_send_to,
				'timestamp' => P8_TIME,
				'data' => $this->DB_master->escape_string(serialize(array(
					'email' => $this->email,
					'sendto' => $this->_send_to,
					'subject' => $this->_subject,
					'headers' => $this->headers,
					'message' => $this->_message,
				)))
			)
		);
		
		return true;
	}
	
	switch($this->send_type){
	
	case 'mail':
		return $this->mail();
	break;
	
	case 'smtp':
		return $this->smtp();
	break;
	
	case '_mail':
		return $this->_mail();
	break;
	
	}
}

/**
* 队列发送
**/
function queue($num = 0){
	
	$lock = $this->core->CACHE->read('core/modules', 'mail', 'lock', 'serialize');
	//锁定了
	if($lock) return false;
	
	$query = $this->DB_slave->query("SELECT * FROM $this->queue_table ORDER BY id ASC LIMIT ". (empty($num) ? '1' : $num));
	
	$flag = true;
	
	while($data = $this->DB_slave->fetch_array($query)){
		
		if($flag){
			//加锁
			$this->core->CACHE->write('core/modules', 'mail', 'lock', array(P8_TIME), 'serialize');
			$flag = false;
		}
		
		$data['data'] = unserialize($data['data']);
		
		$this->set($data['data']);
		$this->send();
		
		$this->DB_master->delete($this->queue_table, "id = '$data[id]'");
	}
	
	if(!$flag){
		//解锁
		$this->core->CACHE->delete('core/modules', 'mail', 'lock');
	}
}

/**
* smtp发送
**/
function smtp(){
	if(!($fp = fsockopen($this->server, $this->port, $errno, $errstr, 30))) return false;
	
	stream_set_blocking($fp, true);

	$lastmessage = fgets($fp, 512);
	if(substr($lastmessage, 0, 3) != 220){
		$this->log("$this->server:$this->port CONNECT - $lastmessage");
		return false;
	}

	fputs($fp, (1 ? 'EHLO' : 'HELO')." php168\r\n");
	$lastmessage = fgets($fp, 512);
	if(substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250){
		$this->log("$this->server:$this->port HELO/EHLO - $lastmessage");
		return false;
	}

	while(true){
		if(substr($lastmessage, 3, 1) != '-' || empty($lastmessage)){
			break;
		}
		$lastmessage = fgets($fp, 512);
	}

	if(1){	//$this->auth
		fputs($fp, "AUTH LOGIN\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 334) {
			$this->log("$this->server:$this->port AUTH LOGIN - $lastmessage");
			return false;
		}

		fputs($fp, base64_encode($this->email)."\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 334) {
			$this->log("$this->server:$this->port USERNAME - $lastmessage");
			return false;
		}

		fputs($fp, base64_encode($this->password)."\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 235){
			$this->log("$this->server:$this->port PASSWORD - $lastmessage");
			return false;
		}
		
	}

	$email_from = $this->email;
	fputs($fp, "MAIL FROM: <".preg_replace('/.*\<(.+?)\>.*/', '$1', $email_from).">\r\n");
	$lastmessage = fgets($fp, 512);
	if(substr($lastmessage, 0, 3) != 250){
		fputs($fp, "MAIL FROM: <".preg_replace('/.*\<(.+?)\>.*/', '$1', $email_from).">\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 250){
			$this->log("$this->server:$this->port MAIL FROM - $lastmessage");
			return false;
		}
	}

	fputs($fp, "RCPT TO: <".preg_replace('/.*\<(.+?)\>.*/', '$1', $this->_send_to).">\r\n");
	$lastmessage = fgets($fp, 512);
	if(substr($lastmessage, 0, 3) != 250){
		fputs($fp, "RCPT TO: <".preg_replace('/.*\<(.+?)\>.*/', '$1', $this->_send_to).">\r\n");
		$lastmessage = fgets($fp, 512);
		$this->log("$this->server:$this->port RCPT TO - $lastmessage");
		return false;
	}

	fputs($fp, "DATA\r\n");
	$lastmessage = fgets($fp, 512);
	if(substr($lastmessage, 0, 3) != 354){
		$this->log("$this->server:$this->port DATA - $lastmessage");
		return false;
	}

	$this->headers .= 'Message-ID: <'. gmdate('YmdHs') .'.'. substr(md5($this->message . microtime()), 0, 6) . rand(100000, 999999) .'@'. $_SERVER['HTTP_HOST'] .">{$this->CRLF}";

	fputs($fp, "Date: ". gmdate('r') ."\r\n");
	fputs($fp, "To: $this->_send_to\r\n");
	fputs($fp, "Subject: $this->_subject\r\n");
	fputs($fp, $this->headers ."\r\n");
	fputs($fp, "\r\n\r\n");
	fputs($fp, "$this->_message\r\n.\r\n");
	$lastmessage = fgets($fp, 512);
	
	if(substr($lastmessage, 0, 3) != 250) {
		$this->log("$this->server:$this->port END - $lastmessage");
	}
	fputs($fp, "QUIT\r\n");
	return true;
}

/**
* mail函数发送
**/
function mail(){
	return mail($this->_send_to, $this->_subject, $this->_message, $this->headers);
}

/**
* 
**/
function _mail(){
	ini_set('SMTP', $this->server);
	ini_set('smtp_port', $this->port);
	ini_set('sendmail_from', $this->email);
	
	return @mail($this->_send_to, $this->_subject, $this->_message, $this->headers);
}

function log($message){
	if(empty($this->CONFIG['logged'])) return;
	
	write_file(CACHE_PATH .'/mail_log.php', '<?php exit;?>'. $message, 'a');
}

}