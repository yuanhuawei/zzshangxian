<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or die();

P8_AJAX_REQUEST or die();

$category = $this_system->load_module('category');

include template($this_module, 'select_category', 'admin');