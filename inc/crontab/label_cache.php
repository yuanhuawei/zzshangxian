<?php
defined('PHP168_PATH') or die();

/**
* ¸üÐÂ±êÇ©»º´æ
**/
$_crontab = $crontab;
$label_module = &$core->load_module('label');
			
$label_module->cache();
$label_module->cache_data();
if(!$crontab)$crontab=$_crontab;