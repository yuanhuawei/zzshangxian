<?php
defined('PHP168_PATH') or die();

/**
* ��Ԫ�Ƽ��Ķ��Żص��ƻ�����
**/

$sms = &$core->load_module('sms');
$int = $sms->load_interface('ccell');

//���Żص�
$int->callback();