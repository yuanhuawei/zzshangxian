<?php
defined('PHP168_PATH') or die();

function refresh_sphinx_config($data = array()){
	
	$content = read_file(CACHE_PATH .'/csft.conf.php');
	
	global $core;
	
	$data = array_merge(array(
		'db_host' => $core->DB_master->host,
		'db_user' => $core->DB_master->user,
		'db_password' => $core->DB_master->password,
		'db_port' => $core->DB_master->port,
		'db_sock' => '/tmp/mysql.sock',
		'db_name' => $core->DB_master->db,
		'db_charset' => $core->DB_master->charset,
		'charset' => $core->CONFIG['page_charset']
	), $data);
	
	if(preg_match('/## main index \{template\}\{[\s\S]+## delta index \{template\}\}/', $content, $index)){
		$index = preg_replace('/^#/m', '', $index[0]);
		
		foreach($data as $k => $v){
			if(is_array($v)) continue;
			
			$index = str_replace('#{'. $k .'}#', $v, $index);
		}
		
		preg_match('/# main index \{template\}\{[\s\S]+# main index \{template\}\}/', $index, $main);
		
		preg_match('/# delta index \{template\}\{[\s\S]+# delta index \{template\}\}/', $index, $delta);
		$main = str_replace(
			'index {template}',
			'index '. $data['index_name'],
			$main[0]
		);
		$delta = str_replace(
			'index {template}',
			'index '. $data['index_name'],
			$delta[0]
		);
		
		foreach($data['main'] as $k => $v){
			$main = str_replace('#{'. $k .'}#', $v, $main);
		}
		
		foreach($data['delta'] as $k => $v){
			$delta = str_replace('#{'. $k .'}#', $v, $delta);
		}
		
		$index = $main ."\r\n\r\n\r\n". $delta;
	}else{
		return $content;
	}
	
	$reg = '/# main index '. $data['index_name'] .'\{[\s\S]+# delta index '. $data['index_name'] .'\}/';
	if(preg_match($reg, $content)){
		$content = preg_replace($reg, $index, $content);
	}else{
		$content = str_replace(
			'### new index ###', 
			$index . str_repeat("\r\n", 10) ."\r\n### new index ###\r\n",
			$content
		);
	}
	
	write_file(CACHE_PATH .'csft.conf.php', $content);
}

function remove_sphinx_config_index($index_name){
	$content = read_file(CACHE_PATH .'csft.conf.php');
	
	$content = preg_replace('/# main index '. $index_name .'\{[\s\S]+# delta index '. $index_name .'\}\s+?/', "\r\n", $content);
	
	write_file(CACHE_PATH .'csft.conf.php', $content);
}
