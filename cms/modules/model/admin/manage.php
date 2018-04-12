<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

$model = isset($_GET['model']) ? $this_controller->valid_name($_GET['model']) : '';
$this_model = $this_system->get_model($model) or message('no_such_cms_model');

load_language($core, 'config');
include template($this_module, 'manage', 'admin');