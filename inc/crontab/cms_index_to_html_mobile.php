﻿<?php
defined('PHP168_PATH') or die();

/**
* 首页静态
**/
if(empty($core->CONFIG['enable_mobile']))return;
$system = &$core->load_system('cms');
//抗干扰
unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);

//定义生成静态的常量
defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);

$_SERVER['_REQUEST_URI'] = '/index.php/cms';

ob_start();
require PHP168_PATH .'m/index.php';

$content = ob_get_clean();

$index_file = $system->index_files[$system->CONFIG['index_file']];
if($core->CONFIG['index_system'] == $system->name){
	write_file(PHP168_PATH . 'm/'.$index_file, $content);
	@chmod(PHP168_PATH . $index_file, 0644);
}
