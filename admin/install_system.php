<?php
defined('PHP168_PATH') or die();

/**
* 安装一个系统
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'POST'){
	
	
	
	require PHP168_PATH .'install/install_system.php';

	unset($admin_menu);
	$admin_menu = new P8_Admin_Menu();

	unset($member_menu);
	$member_menu = new P8_Member_Menu();


	//require_once PHP168_PATH .'inc/cache.func.php';
	
	//cache_all();8386948

$form = <<<FORM
<form name="form" id="form" action="$core->admin_controller/core-cache"   method="post">
<input type="hidden" value="all" name="type">
</form>
<script type="text/javascript">
document.getElementById('form').submit();
</script>
FORM;
message($form);
	unset($_P8SESSION['role@system'][$system_name]);
	
	message('done');
}