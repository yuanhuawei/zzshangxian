<?php
defined('PHP168_PATH') or die();

/**
* 更新分类缓存
**/

$cms = &$core->load_system('cms');
		
$cms->models = $cms->core->CACHE->read($cms->name .'/modules', 'model', 'models');

$module = $cms->load_module('category');

$module->cache();


$Model = $cms->load_module('model');
$Model->cache();