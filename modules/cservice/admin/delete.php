<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');
GetGP(array('id'));
$this_module->delete($id);
message('done',$this_router.'-list');