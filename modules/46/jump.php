<?php

/* if(strtoupper($_SERVER['REQUEST_METHOD']) == 'GET'){
	$input = '';
	foreach($_GET as $k => $v){
		$input .= '<input type="hidden" name="'. $k .'" value="'. $v .'" />';
	}
	
	echo '<html><body><form method="POST" action="'. $_SERVER['PHP_SELF'] .'" id="form">'. $input .'</form><script>document.getElementById("form").submit();</script></body></html>';
	exit;
} */

defined('PHP168_PATH') or die();

/**
* 广告跳转
**/

//广告ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id or message('access_denied');

//投放ID
$bid = isset($_GET['bid']) ? intval($_GET['bid']) : 0;
$postfix = isset($_GET['postfix']) ? preg_replace('/[a-zA-Z0-9_\-]/', '', $_GET['postfix']) : '';

$ad = $CACHE->read('core/modules', $MODULE, $id);
if(empty($ad)) message('access_denied');

if($ad['expense_type'] == 'click'){
	
	if(
		$bid && !empty($ad['uid'][$postfix]) && $UID != $ad['uid'][$postfix] && 
		isset($core->credits[$ad['credit_type']]) && $ad['credit'] &&
		$this_module->click_log($bid, true)
	){
		
		$credit = $core->get_credit($ad['uid'][$postfix]);
		if($credit[$ad['credit_type']] < $ad['credit']){
			//欠费,重新生成广告
			$this_module->js($bid, $postfix);
		}else{
			//扣费
			$core->update_credit($ad['uid'], array($ad['credit_type'] => -$ad['credit']));
		}
	}
	
}else{
	$this_module->click_log($bid);
}

$url = isset($_GET['url']) ? p8_stripslashes2($_GET['url']) : '';
//echo $url;
header('Location: '. $url);
exit;