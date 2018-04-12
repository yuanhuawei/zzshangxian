<?php

class P8_Csv{

var $file;
var $data;
var $fp;
var $delimiter;

function __construct($file = '', $delimiter = ','){
	$this->data = array();
	$this->delimiter = $delimiter;
	
	if($file) $this->open($this->file = $file);
}

function P8_Csv($file = '', $delimiter = ','){
	$this->__construct($file, $delimiter);
}

function open($file){
	global $core;
	
	$locale = 'zh_CN.gbk';
	//if($core->CONFIG['page_charset'] == 'utf-8') $locale = 'en_US.UTF-8';
	
	setlocale(LC_ALL, $locale);
	//setlocale(LC_ALL, NULL);
	if(!($this->fp = fopen($file, 'r'))){
		return array();
	}
	
	while(($data = $this->_fgetcsv($this->fp)) !== false){
		if($core->CONFIG['page_charset'] == 'utf-8'){
			foreach($data as $k=>$v){
				$data[$k] = convert_encode('gbk','utf8',$v);
			}
		}
		$this->data[] = $data;
	}

	register_shutdown_function(array(&$this, 'close'));
}

function save($file = ''){
	$fp = fopen($file ? $file : $this->file, 'w');
	foreach($this->data as $v){
		fputcsv($fp, $v, $this->delimiter);
	}
	fclose($fp);
}

function close(){
	@fclose($this->fp);
}
function _fgetcsv(& $handle, $length = null, $d = ',', $e = '"') {
     $d = preg_quote($d);
     $e = preg_quote($e);
     $_line = "";
     $eof=false;
     while ($eof != true) {
         $_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
         $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
         if ($itemcnt % 2 == 0)
             $eof = true;
     }
     $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
     $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
     preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
     $_csv_data = $_csv_matches[1];
     for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
         $_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1' , $_csv_data[$_csv_i]);
         $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
     }
     return empty ($_line) ? false : $_csv_data;
}
}