<?php
defined('PHP168_PATH') or die();

//��鵱ǰ����Ȩ��
$this_controller->check_action('post') or message('no_privilege');

$reward = array();
GetGP(array('cid','exper'));
$cid = intval($cid);
//�������ģ��
$category = $this_system->load_module('category');

$json['exper']='{}';
if($exper){
$member = $this_system->load_module('member');
	$makeexpertorjson=$member->makeexpertorjson($exper);
	$json['exper'] = json_encode($makeexpertorjson);
	$expertor=$member->getexpertor($exper);
}
$title = isset($_GET['title']) ? ($_GET['title']) : '';

//��������۳�����
$urgent_credit = intval($this_system->CONFIG['urgent_credit']);
//�����б�
$reward = explode("\r\n",$this_system->CONFIG['reply_credit']);

$position = $this_system->position . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_question'];

//SEO
$sitename = $P8LANG['ask_question'] . ' - ' . $this_system->sitename;
$meta_keywords = $this_system->meta_keywords;
$meta_description = $this_system->meta_description;

include template($this_module, 'ask');