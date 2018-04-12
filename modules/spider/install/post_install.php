<?php
defined('PHP168_PATH') or die();

//导入规则
$rules = to_installed_charset(unserialize(file_get_contents($this_module->path .'install/rules.txt')));

foreach($rules as $v){
	$this_module->add_rule($v);
}

md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/task', true);
md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/rule', true);