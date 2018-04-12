<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$form = <<<EOT
<form id="form" method="post" action="$this_url">
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
	
	@set_time_limit(0);
	
	$this_module->cache();
	
	//Ìø»Ø×Ü»º´æ
	!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
	
	message('done', $this_router .'-list');
}