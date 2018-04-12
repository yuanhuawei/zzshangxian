<?php
defined('PHP168_PATH') or die();

/**
* 单元科技的短信回调计划任务
**/

$sms = &$core->load_module('sms');
$int = $sms->load_interface('ccell');

//短信回调
$int->callback();