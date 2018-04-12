<?php
defined('PHP168_PATH') or die();

$id = 0;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['id'] = $id;
			break 2;
		break;
	}
}
!$id && message('err');
$data = $this_module->get($id) or message('data_no_est!');
//if($UID!=$data['uid'] && !$ISADMIN)message('no_privilege');
//SEO
$TITLE = $data['title'] .'_'. $core->CONFIG['site_name'];
$SEO_KEYWORDS = $core->CONFIG['site_key_word'];
$SEO_DESCRIPTION = $core->CONFIG['site_description'];

include template($this_module, 'view');
?>