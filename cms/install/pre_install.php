<?php
defined('PHP168_PATH') or die();

//HTML����
md(CACHE_PATH . $this_system->name .'/html_task');
md(CACHE_PATH .'tmp/cms_model_import');


$uploader = &$core->load_module('uploader');

//����������
include PHP168_PATH .'modules/uploader/inc/init_system.php';