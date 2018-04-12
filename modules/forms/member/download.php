<?php
defined('PHP168_PATH') or die();
$this_controller->check_action($ACTION) or message('no_privilege');
include $this_module->path .'call/download_call.php';