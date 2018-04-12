<?php
defined('PHP168_PATH') or die();

//载入分类模块
$category = &$this_system->load_module('category');
$category->cache();

//生成统计信息缓存
$this_system->cache_statistics();

message('done', $this_router . '-config');

?>