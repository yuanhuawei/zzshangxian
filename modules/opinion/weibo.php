<?php
defined('PHP168_PATH') or die();

/**
* �鿴��������ļ�
**/
//$this_controller->check_action('list') or message('no_privilege');
$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
$TITLE = $core->CONFIG['site_name'];

//��ʼ����ǩ
$LABEL_POSTFIX = array();
//����������Լ��ı�ǩ��׺
array_push($LABEL_POSTFIX, 'weibo');

include template($this_module, 'weibo');
