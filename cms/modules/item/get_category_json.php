<?php
defined('PHP168_PATH') or die();

$category = &$this_system->load_module('category');
$json = $category->get_json();

exit('{"json":'. $json['json'] .',"path":'. $json['path'] .'}');