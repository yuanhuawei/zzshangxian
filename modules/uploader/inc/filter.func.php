<?php

function valid_upload_filter($filter){
	$ret = array(
		'filter' => array(),
		'_filter' => ''
	);
	
	if(!empty($filter)){
		//原始文本
		$ret['_filter'] = $filter;
		//文件过滤器
		$_filter = array();
		foreach(array_filter(explode("\r\n", $filter)) as $v){
			$v = explode('|', $v);
			$size = 0;
			if(isset($v[1])){
				$v[1] = trim($v[1]);
				if(strtolower(substr($v[1], -1, 1)) == 'm'){
					//M为单位
					$size = abs(intval($v[1])) * 1024 * 1024;
				}else{
					//K为单位
					$size = abs(intval($v[1])) * 1024;
				}
			}
			
			$v[0] = trim($v[0]);
			$rp = array('.', '\\', '/', '|', '*', ':', '?', '"', '<', '>');
			$v[0] = str_replace($rp, '', $v[0]);
			$_filter[strtolower($v[0])] = $size;
		}
		$ret['filter'] = $_filter;
	}
	
	return $ret;
}

function set_upload_filter($key, $filter, $_filter){
	global $core, $CACHE;
	
	$DB_master->insert(
		$core->TABLE_ .'uploader_filter',
		array(
			'id' => $key,
			'filter' => $DB_master->escape_string(serialize($filter)),
			'_filter' => $DB_master->escape_string($_filter),
		),
		array(
			'multiple' => true
		)
	);
	
	$CACHE->write('', 'uploader_filter', $key, $filter);
}

function get_upload_filter($key){
	global $core;
	$tmp = $DB_master->fetch_one('SELECT _filter FROM '. $core->TABLE_ .'uploader_filter WHERE id = \''. $key .'\'');
	return empty($tmp) ? '' : $tmp['_filter'];
}

function cache_upload_filter(){
	global $core, $CACHE;
	
	foreach(glob(CACHE_PATH .'uploader_filter/*.php') as $v){
		@unlink($v);
	}
	
	$filters = $DB_master->fetch_all('SELECT id, filter FROM '. $core->TABLE_ .'uploader_filter');
	$_filters = array();
	foreach($filters as $f){
		$f['filter'] = mb_unserialize($f['filter']);
		$CACHE->write('', 'uploader_filter', $f['id'], $f['filter']);
	}
}