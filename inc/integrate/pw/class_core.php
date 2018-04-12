<?php

class UC {

	var $db;
	var $db_pre;
	var $time;
	var $appid;
	var $onlineip;
	var $user = array();
	var $controls = array();
	var $models = array();
	var $cache = null;

	function __construct() {
		$this->UC();
	}

	function UC() {

		$this->time = time();
		$this->appid = UC_APPID;
		$this->onlineip = 'Unknown';

		if ($_SERVER['HTTP_X_FORWARDED_FOR'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$this->onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif ($_SERVER['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
			$this->onlineip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$_SERVER['REMOTE_ADDR'])) {
			$this->onlineip = $_SERVER['REMOTE_ADDR'];
		}
		require_once UC_CLIENT_ROOT . 'class_db.php';
		$this->db = new UcDB(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBPRE, UC_DBCHARSET, UC_DBPCONNECT);
		$this->db_pre = UC_DBPRE;
		//$this->init_db();
		//$this->init_notify(); //通知  去掉
	}
	
	//不使用
	function init_db() {
		if (UC_SERVER < 2) {
			global $db;
			$this->db =& $db;
		} else {
			$this->db = new DB(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBPRE, UC_DBCHARSET, UC_DBPCONNECT);
		}
		//require_once UC_LIB_ROOT . 'class_db.php';
		//$this->db = new UcDB(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBPCONNECT, UC_DBCHARSET);
	}
	//不使用
	function init_notify() {
		if (UC_SERVER == 2 && $this->config('uc_syncreditexists' . $this->appid)) {
			$credit = $this->load('credit');
			$credit->synupdate();
		}
		if (UC_SERVER > 0 && $this->config('uc_notifyexists' . $this->appid)) {
			$notify = $this->load('notify');
			$notify->send();
		}
	}
	//不使用
	function config($var) {
		if ($this->cache == null) {
			$this->cache = array();
			$query = $this->db->query("SELECT * FROM pw_config");
			while ($rt = $this->db->fetch_array($query)) {
				if ($rt['vtype'] == 'array' && !is_array($rt['db_value'] = mb_unserialize($rt['db_value']))) {
					$rt['db_value'] = array();
				}
				$this->cache[$rt['db_name']] = $rt['db_value'];
			}
		}
		return $this->cache[$var];
	}

	function control($model) {
		if (empty($this->controls[$model])) {
			require_once (UC_CLIENT_ROOT . "control/{$model}.php");
			eval('$this->controls[$model] = new '.$model.'control($this);');
		}
		return $this->controls[$model];
	}

	function load($model) {
		if (empty($this->models[$model])) {
			require_once (UC_CLIENT_ROOT . "model/{$model}.php");
			eval('$this->models[$model] = new '.$model.'model($this);');
		}
		return $this->models[$model];
	}

	//static function
	function escape($var, $isArray = false) {
		if (is_array($var)) {
			if (!$isArray) return " '' ";
			foreach ($var as $key => $value) {
				$var[$key] = trim(UC::escape($value));
			}
			return $var;
		} elseif (is_numeric($var)) {
			return " '".$var."' ";
		} else {
			return " '".addslashes($var)."' ";
		}
	}

	//static function
	function sqlSingle($array) {
		//Copyright (c) 2003-2103 phpwind
		$array = UC::escape($array, true);
		$str = '';
		foreach ($array as $key => $val) {
			$str .= ($str ? ', ' : ' ').$key.'='.$val;
		}
		return $str;
	}

	//static function
	function implode($array) {
		return implode(',', UC::escape($array, true));
	}

	//static function
	function sqlMulti($array) {
		$str = '';
		foreach ($array as $val) {
			if (!empty($val)) {
				$str .= ($str ? ', ' : ' ') . '(' . UC::implode($val) .') ';
			}
		}
		return $str;
	}

	//static function
	function strcode($string, $hash_key, $encode = true) {
		!$encode && $string = base64_decode($string);
		$code = '';
		$key  = substr(md5($_SERVER['HTTP_USER_AGENT'] . $hash_key),8,18);
		$keylen = strlen($key);
		$strlen = strlen($string);
		for ($i = 0; $i < $strlen; $i++) {
			$k		= $i % $keylen;
			$code  .= $string[$i] ^ $key[$k];
		}
		return ($encode ? base64_encode($code) : $code);
	}
	
	function getTable($tablename) {
		return $this->db_pre.$tablename;
	}
	
	function insertTable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
		$insertkeysql = $insertvaluesql = $comma = '';
		foreach ($insertsqlarr as $insert_key => $insert_value) {
			$insertkeysql .= $comma.'`'.$insert_key.'`';
			$insertvaluesql .= $comma.'\''.$insert_value.'\'';
			$comma = ', ';
		}
		$method = $replace?'REPLACE':'INSERT';
		 $this->db->query($method.' INTO '.$this->getTable($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
		if($returnid && !$replace) {
			$this->db->insert_id();
		}
	}
}