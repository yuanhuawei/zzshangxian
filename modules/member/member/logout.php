<?php
defined('PHP168_PATH') or die();

/**
* ÍË³ö
**/

if(REQUEST_METHOD == 'GET'){
	
	//·ÀÖ¹·¢Í¼µ·µ°
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$core->CONFIG['page_charset']}" />
</head>
<body>
<form action="$this_url" method="post" id="f">
<input type="hidden" name="_referer" value="$HTTP_REFERER" />
</form>
<script type="text/javascript">if(confirm('$P8LANG[confirm_to_logout]')){document.getElementById('f').submit();}else{window.location.href='$HTTP_REFERER';}</script>
</body>
</html>
EOT;
	
}else if(REQUEST_METHOD == 'POST'){
	$data = $this_module->logout();
	if(P8_AJAX_REQUEST){
		$ret = array('status'=>$P8LANG['logout_success'],'message'=>$data['message']);
		echo p8_json($ret);
		exit;
	}
	message($P8LANG['logout_success']. $data['message'], $_POST['_referer']);
	
}

