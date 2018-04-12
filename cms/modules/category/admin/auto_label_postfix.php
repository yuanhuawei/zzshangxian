<?php
defined('PHP168_PATH') or die();
if(REQUEST_METHOD == 'GET'){
	$this_module->get_cache(false);
	$dates = $this_module->categories;
	$cids = array_keys($dates);
	asort($cids);
	echo array_pop($cids)+1;
}

?>