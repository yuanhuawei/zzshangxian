<?php
defined('PHP168_PATH') or die();

/**
* 更新缓存
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$form = <<<EOT
<form id="form" method="post" action="$this_url">
<input type="hidden" name="_referer" value="$HTTP_REFERER" />
</form>

<script type="text/javascript">
if(confirm('$P8LANG[confirm_to_do]')){
	document.getElementById('form').submit();
}else{
	window.location.href = '$HTTP_REFERER';
}
</script>
EOT;
	
	message($form);
	
}else if(REQUEST_METHOD == 'POST'){
	
	$this_module->cache();
	
	//跳回总缓存
	!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
	
	message('done', $HTTP_REFERER);
}