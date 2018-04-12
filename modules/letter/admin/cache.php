<?php
defined('PHP168_PATH') or die();

 if(REQUEST_METHOD == 'POST'){
$this_module->cacheManager();
///Ìø»Ø×Ü»º´æ
!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
message('done');
 }