<?php
defined('PHP168_PATH') or die();

//删除计划任务
$crontab = &$core->load_module('crontab');
$crontab->delete($this_system->CONFIG['category_cache_crontab_id']);
$crontab->delete($this_system->CONFIG['index_to_html_crontab_id']);

$DB_master->query("DROP TABLE $this_system->membet_table");
$DB_master->query("DROP TABLE $this_system->model_table");

rm(PHP168_PATH .'attachment/');