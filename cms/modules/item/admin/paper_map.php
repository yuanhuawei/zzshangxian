<?php
defined('PHP168_PATH') or die();

/**
* 报刊的热区编辑
**/

$this_controller->check_admin_action('add') || $this_controller->check_admin_action('update') or message('no_privilege');

$this_system->init_model();

$thumb = isset($_GET['thumb']) ? $_GET['thumb'] : '';

include template($this_module, $MODEL .'/map', 'admin');