<?php
defined('PHP168_PATH') or die();

/**
* 首页静态
**/

//抗干扰
unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);

//定义生成静态的常量
defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);

$_SERVER['_REQUEST_URI'] = '/index.php/opinion-main';

ob_start();
require PHP168_PATH .'index.php';

$content = ob_get_clean();

write_file(PHP168_PATH .'opinion-main.html', $content);
@chmod(PHP168_PATH .'opinion-main.html', 0644);