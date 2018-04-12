<?php
defined('PHP168_PATH') or die();

//删除计划任务
$crontab = &$core->load_module('crontab');
$crontab->delete($this_system->CONFIG['index_to_html_crontab_id']);