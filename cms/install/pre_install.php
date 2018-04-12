<?php
defined('PHP168_PATH') or die();

//HTML任务
md(CACHE_PATH . $this_system->name .'/html_task');
md(CACHE_PATH .'tmp/cms_model_import');


$uploader = &$core->load_module('uploader');

//创建附件表
include PHP168_PATH .'modules/uploader/inc/init_system.php';