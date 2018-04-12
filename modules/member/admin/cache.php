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
			
			//��ʼ��
			$_POST['m_start'] = 1;
			$_POST['m_offset'] = 0;
			$_POST['m_step'] = 'cache_acl';
	
			_poster($P8LANG['cache_acl_init']);
		}
		
		define('NO_ADMIN_LOG', true);
		
		if(!empty($_POST['m_done'])){
			
			//�����ܻ���
			!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
			
			if(isset($_POST['mycache']))message('done', $this_router.'-list');//���Ǳ�ģ���ֶ����򲻼�����
			
			$this_url = $core->admin_controller.'/core-cache';
			unset($_POST['m_start']);
			unset($_POST['m_offset']);
			unset($_POST['m_step']);
			unset($_POST['m_done']);
			$_POST['offset'] +=1;
			_poster($P8LANG['cache_acl_success']);
		}
		
		$m_offset = intval($_POST['m_offset']);
	
	switch($_POST['m_step']){
		case 'cache_acl':
			if(!$_POST['m_offset']){
				$_POST['last_cache'] = '@'. $core->CONFIG['last_user_acl_cache'];
				//�����ϴ�Ȩ�޸��»���ʱ��
				if(!defined('P8_CLUSTER')){
					$core->set_config(array(
						'last_user_acl_cache' => P8_TIME
					));
					$_POST['this_cache'] = '@'. P8_TIME;
				}
			$_POST['m_offset'] = 0;
			}
			$status = $this_module->cache_acl_step($m_offset, $_POST['this_cache'], $_POST['last_cache']);
			if(!$status){
				$_POST['m_step'] = 'cache_member';
				unset($_POST['last_cache']);
				unset($_POST['this_cache']);
				unset($_POST['m_offset']);
			}
			$_POST['m_offset'] += 100;
			_poster($P8LANG['cache_acl'].'--'.$m_offset);
		break;
		case 'cache_member':
			$this_module->cache();
			$_POST['m_done'] = 1;
			_poster($P8LANG['cache_member']);
		break;
	}
}