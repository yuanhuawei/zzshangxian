<?php

function S_version(){
	static $v;
	if($v === null) $v = trim(@file_get_contents(PHP168_PATH .'inc/version'));
	
	return $v;
}
function S_build(){
	static $b;
	if($b === null) $b = trim(@file_get_contents(PHP168_PATH .'inc/build'));
	
	return $b;
}
 function record($msg){
 $content = '['.date('Y-m-d h:i:s').']'."\t".$msg."\r\n";
 write_file('install.txt',$content,'a+');
 }
/**
* 添加后台菜单
* @param array $menus 菜单数据
* @param int $parent 菜单父节点ID
**/
function insert_admin_menu($menus, $parent = 0){
	global $admin_menu;
	
	foreach($menus as $v){
		$p = $admin_menu->add(array(
			'name' => $v['name'],
			'parent' => $parent,
			'system' => $v['system'],
			'module' => $v['module'],
			'action' => $v['action'],
			'url' => empty($v['url']) ? '' : $v['url'],
			'front' => empty($v['front']) ? 0 : 1,
			'target' => empty($v['target']) ? '' : $v['target'],
			'display' => isset($v['display']) ? $v['display'] : 1,
			'display_order' => empty($v['display_order']) ? 0 : $v['display_order']
		));
		
		if($p && isset($v['menus'])){
			insert_admin_menu($v['menus'], $p);
		}
	}
}

/**
* 添加会员中心菜单
**/
function insert_member_menu($menus, $parent = 0){
	global $member_menu;
	
	foreach($menus as $v){
		$p = $member_menu->add(array(
			'name' => $v['name'],
			'parent' => $parent,
			'system' => $v['system'],
			'module' => $v['module'],
			'action' => $v['action'],
			'url' => empty($v['url']) ? '' : $v['url'],
			'front' => empty($v['front']) ? 0 : 1,
			'target' => empty($v['target']) ? '' : $v['target'],
			'display' => isset($v['display']) ? $v['display'] : 1,
			'display_order' => empty($v['display_order']) ? 0 : $v['display_order']
		));
		
		if($p && isset($v['menus'])){
			insert_member_menu($v['menus'], $p);
		}
	}
}
/**
* 添加导航菜单
**/
function insert_navigation_menu($menus, $parent = 0){
	global $navigation_menu;
	
	foreach($menus as $v){
		$p = $navigation_menu->add(array(
			'name' => $v['name'],
			'parent' => $parent,
			'system' => $v['system'],
			'color' => empty($v['color']) ? '' : $v['color'],
			'url' => empty($v['url']) ? '' : $v['url'],
			'target' => empty($v['target']) ? '' : $v['target'],
			'display' => isset($v['display']) ? $v['display'] : 1,
			'display_order' => empty($v['display_order']) ? 0 : $v['display_order']
		));
		
		if($p && isset($v['menus'])){
			insert_navigation_menu($v['menus'], $p);
		}
	}
}

/**
* 添加个人主页菜单
**/
function insert_homepage_menu($menus, $parent = 0){
	global $homepage_menu;
	
	foreach($menus as $v){
		$p = $homepage_menu->add(
			array(
				'name' => $v['name'],
				'parent' => $parent,
				'system' => $v['system'],
				'module' => $v['module'],
				'action' => $v['action'],
				'url' => empty($v['url']) ? '' : $v['url'],
				'front' => empty($v['front']) ? 0 : 1,
				'target' => empty($v['target']) ? '' : $v['target'],
				'display' => isset($v['display']) ? $v['display'] : 1,
				'display_order' => empty($v['display_order']) ? 0 : $v['display_order']
			)
		);
		
		if($p && isset($v['menus'])){
			insert_homepage_menu($v['menus'], $p);
		}
	}
}

function test_mysql_partition(&$db){
	static $part;
	
	if($part !== null) return $part;
	
	$partition = $db->fetch_one("SHOW VARIABLES LIKE 'have_partitioning'");
	
	$part = empty($partition) || strtolower($partition['Value']) != 'yes' ? false : true;
	return $part;
}

/**
* 从SQL中取得安装的SQL
* p8_	>	php168_
* p8_test_item > php168_test_item
* @param object $db 数据库操作对象
* @param string $sql SQL语句
* @param string $table_prefix 表名前缀
* @param bool $drop_table 是否删除表
**/
function get_install_sql(&$db, $sql, $table_prefix, $drop_table = false){
	$default_charset = '';
	if($db->version() > '4.1'){
		$default_charset = ' DEFAULT CHARSET='.$db->charset;
	}
	
	if(!test_mysql_partition($db)){
		//不支持表分区
		$sql = preg_replace('#/\*\!50100 ([\s\S]+?)\*/#s', '', $sql);
	}
	
	global $__install_table_prefix;
	$__install_table_prefix = $table_prefix;
	
	//替换表名前缀`p8_config`|p8_config被替换成php168.{$tp}config或{$tp}config
	$sql = preg_replace_callback('/\s+`?(?:p8_([\w\_]*)|p8_([\w\_]*))`?\s*/', '_table_prefix_callback', $sql);//更精确匹配
    //$sql = preg_replace_callback('/\s+`?(?:p8_(.*?)|p8_(.*?))`?\s+/', '_table_prefix_callback', $sql);
	$sql = preg_replace("/default charset=[a-z0-9]+/i", '', $sql);			//先去掉字符集
	//$sql = preg_replace("/(type|engine)\s*?=\s*?memory/is", 'TYPE=HEAP', $sql);		//兼容heap
	$sql = preg_replace("/(type|engine)\s*?=\s*?([a-z0-9]+)/i", 'ENGINE=\\2'. $default_charset, $sql);	//添加字符集
	//分割每个SQL
	$sql = str_replace(";\r", ";\n", $sql);
	//去除空行,转换编码
	$sql = array_filter(array_map('trim', explode(";\n", $sql)));
	if(function_exists('convert_encode')){
		$sql = to_installed_charset($sql);
	}
	
	if($drop_table){
		foreach($sql as $v){
			if(preg_match("/CREATE TABLE ([a-z0-9\_\-`.]+).+?\s/i", $v, $m))
				array_unshift($sql, "DROP TABLE IF EXISTS {$m[1]};");
		}
	}
	
	return $sql;
}

function _table_prefix_callback($str){
	global $__install_table_prefix;
	//$prefix=$str[1]? $__install_table_prefix : substr($__install_table_prefix,0,-1);//去掉表名后面的下划线_?
	//$table = ' '. $prefix . $str[1] .' ';
	$table = ' '. $__install_table_prefix . $str[1] .' ';
	return $table;
}

/**
* 把编码转换到当前安装系统所使用的编码,注意,务必使每个发行的安装程序,SQL的编码是ANSI
**/
function to_installed_charset($str){
	global $core;
	if('gbk' == $core->CONFIG['page_charset']) return $str;	//编码相同不鸟
	
	return convert_encode('gbk', $core->CONFIG['page_charset'], $str);
}

/**
* 转换文件的编码
**/
function convert_file_encode($file, $from, $to, $filter = ''){
	$from = strtoupper($from);
	$to = strtoupper($to);
	if($from == $to) return;
	
	global $core;
	
	if(is_file($file) && preg_match('/('. $filter .')$/', $file)){
		write_file($file, convert_encode($from, $to, file_get_contents($file)));
	}else{
		$handle = opendir($file);
		while(false !== ($item = readdir($handle))){
			if($item == '.' || $item == '..') continue;
			
			if(is_file($file . $item)){
				convert_file_encode($file . $item, $from, $to, $filter);
			}else if(is_dir($file . $item)){
				convert_file_encode($file . $item .'/', $from, $to, $filter);
			}
		}
	}
}