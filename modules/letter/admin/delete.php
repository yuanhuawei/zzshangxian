<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('list') or message('no_privilege');
GetGP(array('id'));
$this_module->delete(array('ids'=>array($id)));
message('done',$this_router.'-list');