<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$this_module->cache();

//Ìø»Ø×Ü»º´æ
!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);

message('done', $this_router . '-list', 3);
