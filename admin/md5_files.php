<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

function _md5_files($path){
	static $path_filter, $filter, $ext_filter;
	
	if(empty($path_filter)){
		$path_filter = array(
			CACHE_PATH .'label/' => 1,
			CACHE_PATH .'template/' => 1,
			CACHE_PATH .'core/modules/credit/' => 1,
		);
		
		$filter = array('.svn' => 1, '_svn' => 1, 'acl' => 1);
		
		$ext_filter = array('php' => 1, 'js' => 1);
	}
	
	$ret = array();
	
	$handle = opendir($path);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..' || isset($path_filter[$path]) || isset($filter[$item])) continue;
		
		if(is_dir($path . $item)){
			$ret += _md5_files($path . $item .'/');
		}else{
			$ext = strtolower(file_ext($item));
			if(!isset($ext_filter[$ext])) continue;
			
			$ret[str_replace(PHP168_PATH, '', $path . $item)] = md5_file($path . $item);
		}
	}
	
	return $ret;
}

@set_time_limit(0);

load_language($core, 'md5_files');

if(REQUEST_METHOD == 'GET'){
	
	$last_time = @filemtime(CACHE_PATH .'md5_files.php');
	
	include template($core, 'md5_files', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	if(!empty($_POST['diff'])){
		
		$src = @include CACHE_PATH .'md5_files.php';
		if(empty($src)){
			$src = _md5_files(PHP168_PATH);
			write_file(CACHE_PATH .'md5_files.php', "<?php\r\nreturn ". var_export($src, true) .';');
			
			message('done');
		}
		
		$new = _md5_files(PHP168_PATH);
		$diff = array();
		foreach($new as $file => $hash){
			if(!isset($src[$file])){
				$diff[$file] = array(
					'status' => 'new',
					'time' => filemtime($file)
				);
			}else if($hash != $src[$file]){
				$diff[$file] = array(
					'status' => 'mod',
					'time' => filemtime($file)
				);
			}
			
			unset($src[$file]);
		}
		
		foreach($src as $file => $hash){
			$diff[$file] = array(
				'status' => 'del',
				'time' => P8_TIME
			);
		}
		
		//$diff = array_diff($src, $new);
		
		include template($core, 'md5_files', 'admin');
		
	}else{
		
		write_file(CACHE_PATH .'md5_files.php', "<?php\r\nreturn ". var_export(_md5_files(PHP168_PATH), true) .';');
		
		message('done');
	}
}