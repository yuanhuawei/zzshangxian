<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$form = <<<EOT
<form id="form" method="post" action="$this_url">
<input type="hidden" name="mycache" value="1" />
<input type="hidden" name="_referer" value="$HTTP_REFERER" />
</form>

<script type="text/javascript">
if(confirm('$P8LANG[confirm_to_do]')){
	document.getElementById('form').submit();
}else{
	window.close();
}
</script>
EOT;
	
	message($form);
	
}else if(REQUEST_METHOD == 'POST'){

	function _poster($message = ''){
			$input = '';
			foreach($_POST as $k => $v){
				$input .= '<input type="hidden" name="'. $k .'" value="'. $v .'" />';
			}
			
			global $this_url;
			$form = <<<FORM
$message
<form action="$this_url" method="post" id="form">
$input
</form>
<script type="text/javascript">
setTimeout(function(){document.getElementById('form').submit();}, 1);
</script>
FORM;
			message($form);
		}
	
	if(empty($_POST['m_start'])){
			
			//初始化
			$_POST['m_start'] = 1;
			$_POST['m_offset'] = 0;
			$_POST['m_step'] = 'cache_acl';
	
			_poster($P8LANG['cache_role_init']);
		}
		
		define('NO_ADMIN_LOG', true);
		
		if(!empty($_POST['m_done'])){
			
			//跳回总缓存
			!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
			
			if(isset($_POST['mycache']))message('done', $this_router.'-list');//若是本模块手动，则不继续。
			
			$this_url = $core->admin_controller.'/core-cache';
			unset($_POST['m_start']);
			unset($_POST['m_offset']);
			unset($_POST['m_step']);
			unset($_POST['m_done']);
			$_POST['offset'] +=1;
			_poster($P8LANG['cache_role_success']);
		}
		
		$m_offset = intval($_POST['m_offset']);
	
	switch($_POST['m_step']){
		case 'cache_acl':
			if(!$_POST['m_offset']){
				$_POST['last_cache'] = '@'. $core->CONFIG['last_acl_cache'];
				//设置上次权限更新缓存时间
				if(!defined('P8_CLUSTER')){
					$core->set_config(array(
						'last_acl_cache' => P8_TIME
					));
					$_POST['this_cache'] = '@'. P8_TIME;
				}
			
			}
			$status = $this_module->cache_acl_step($m_offset, $_POST['this_cache'], $_POST['last_cache']);
			if(!$status){
				$_POST['m_step'] = 'cache_role';
				unset($_POST['last_cache']);
				unset($_POST['this_cache']);
				unset($_POST['m_offset']);
			}
			$_POST['m_offset'] += 100;
			_poster($P8LANG['cache_acl'].'--'.$m_offset);
		break;
		case 'cache_role':
			$this_module->cache_role();
			$_POST['m_step'] = 'cache_group';
			_poster($P8LANG['cache_role']);
		break;
		case 'cache_group':
			$this_module->cache_group();
			$_POST['m_done'] = 1;
			_poster($P8LANG['cache_group']);
		break;
	}
}