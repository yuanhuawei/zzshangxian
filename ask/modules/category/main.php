<?php
defined('PHP168_PATH') or die();

$this_module->get_cache(true);

//载入问题模块
//$item = &$this_system->load_module('item');

$position = $this_system->position . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_all_category'];

$sitename = $P8LANG['ask_all_category'] . ' - ' . $this_system->CONFIG['sitename'];
$meta_keywords = $this_system->meta_keywords;
$meta_description = $this_system->meta_description;

include template($this_module, 'index');
