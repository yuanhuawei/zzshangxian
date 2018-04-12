<?php
defined('PHP168_PATH') or die();

$core->load_module('member')->logout();

unset($_P8SESSION['#admin_login#']);

message('logout_success', $core->url);