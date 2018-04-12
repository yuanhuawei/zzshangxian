<?php
defined('PHP168_PATH') or die();

/**
* ���»���
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

	load_language($core, 'config');
	include template($core, 'cache', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	@set_time_limit(0);
	@ignore_user_abort(true);
	
	load_language($core, 'config');
	require_once PHP168_PATH .'inc/cache.func.php';
	
	$type = isset($_POST['type']) ? $_POST['type'] : 'all';
	
	switch($type){
	
	case 'unlock':
		$CACHE->delete('', 'core', 'cache_lock');
		
		message('done');
	break;
	
	case 'sm_unlock':
		$CACHE->delete('', 'core', 'sm_cache_lock');
		
		message('done');
	break;
	
	case 'menu':
		cache_menu();
	break;
	
	case 'label':
		cache_label();
	break;
	
	case 'system_module':
		cache_system_module();
	break;
	
	case 'language':
		cache_language();
	break;
	
	case 'template':
		cache_template();
	break;
	
	case 'page_cache':
		clear_page_cache();
	break;
	
	/* ����ȫ������ */
	case 'all':
		
		function ___poster($message = ''){
			$input = '';
			
			global $this_url, $core, $_ALLCACHE;
			$form = <<<FORM
$message
<form action="$this_url" method="post" id="form">
<input type="hidden" name="start" value="1" />
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
FORM;
			$core->CACHE->write('', 'core', 'cache_lock', $_ALLCACHE, 'serialize');
			
			message($form);
		}
		
		function _post_module($sys, $mod){
			global $core, $_ALLCACHE;
			
			$form = <<<FORM
<form action="{$core->admin_controller}/$sys/$mod-cache" method="post" id="form">
<input type="hidden" name="_all_cache_" value="1" />
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
FORM;
			$core->CACHE->write('', 'core', 'cache_lock', $_ALLCACHE, 'serialize');
			
			message($form);
		}
		
		$_ALLCACHE = $CACHE->read('', 'core', 'cache_lock', 'serialize');
		
		if(empty($_POST['start'])){
			//����
			if($_ALLCACHE){
				message('caching_lock');
			}
			
			//��ʼ��
			$_ALLCACHE = array(
				'offset' => 0,
				'step' => 'language'
			);
			
			___poster($P8LANG['cache_init']);
		}
		
		define('NO_ADMIN_LOG', true);
		
		if(!empty($_ALLCACHE['done'])){
			//����
			$CACHE->delete('', 'core', 'cache_lock');
			if(is_file(PHP168_PATH.'data/installcache.lock'))unlink(PHP168_PATH.'data/installcache.lock');
			message('done', $this_url);
		}
		
		$offset = intval($_ALLCACHE['offset']);
		
		switch($_ALLCACHE['step']){
		
		case 'language':
			cache_language();
			cache_word_filter();
			
			$_ALLCACHE['step'] = 'system_module';
			$_ALLCACHE['system_module'] = 1;
			___poster($P8LANG['cache_language']);
		break;
		
		case 'system_module':
			cache_system_module();
			
			$_ALLCACHE['step'] = 'template';
			___poster($P8LANG['cache_system_module']);
		break;
		
		case 'template':
			
			cache_template();
			clear_page_cache();
			
			$_ALLCACHE['step'] = 'menu';
			___poster($P8LANG['cache_template']);
		break;
		
		case 'menu':
			cache_menu();
			
			$_ALLCACHE['step'] = 'cache';
			$_ALLCACHE['core_module'] = 1;
			___poster($P8LANG['cache_menu']);
		break;
		
		case 'cache':
			//����ģ��Ļ���
			//print_r($_ALLCACHE);print_r($_POST);exit;
			if(!empty($_ALLCACHE['core_module'])){
				
				if($offset >= count($core->modules)){
					//���
					$_ALLCACHE['offset'] = 0;
					$_ALLCACHE['_offset'] = 0;
					$_ALLCACHE['system_module'] = 1;
					unset($_ALLCACHE['core_module']);
					
					___poster();
				}
				
				if($offset == 0){
					md(CACHE_PATH .'core/modules', true);
				}
				
				$i = 0;
				$_ALLCACHE['offset'] = $offset +1;
				foreach($core->modules as $v){
					if($i == $offset){
						if(!empty($v['installed'])){
							$m = $core->load_module($v['name']);
							$m->set_config(array());
							
							//��ȥģ�黺��ű�,��������
							if(is_file($this_system->path .'modules/'. $v['name'] .'/admin/cache.php')){
								_post_module($this_system->name, $m->name);
							}else{
								$m->cache();
							}
						}
						break;
					}
					
					$i++;
				}
				
				___poster(p8lang($P8LANG['cache_system_module_process'], '', $v['alias']));
			}
			
			
			//��ϵͳģ��Ļ���
			if(!empty($_ALLCACHE['system_module'])){
				//�������ϵͳ
				if($offset >= count($core->systems)){
					$_ALLCACHE['offset'] = 0;
					$_ALLCACHE['done'] = 1;
					
					___poster();
				}
				
				$i = 0;
				foreach($core->systems as $v){
					if($i == $offset){
						
						$system = &$core->load_system($v['name']);
						
						$_offset = intval($_ALLCACHE['_offset']);
						if($_offset == 0){
							if(!empty($v['installed'])){
								$system->set_config(array());
							}
						}
						
						if($_offset >= count($system->modules)){
							//��ɵ�ǰϵͳ������ģ��
							$_ALLCACHE['_offset'] = 0;
							
							$_ALLCACHE['offset'] = $offset +1;
							___poster();
						}
						
						$j = 0;
						$_ALLCACHE['_offset'] = $_offset +1;
						foreach($system->modules as $vv){
							if($j == $_offset){
								if(!empty($vv['installed'])){
									$m = $system->load_module($vv['name']);
									$m->set_config(array());
									
									//��ȥģ�黺��ű�,��������
									if(is_file($system->path .'modules/'. $vv['name'] .'/admin/cache.php')){
										_post_module($system->name, $m->name);
									}else{
										$m->cache();
									}
								}
								break;
							}
							
							$j++;
						}
						
						___poster(p8lang($P8LANG['cache_system_module_process'], $v['alias'], $vv['alias']));
						
						break;
					}
					
					$i++;
				}
				
			}
			
		break;
		
		}
		
		
		//cache_all();
	break;
	
	}
	
	//����ƻ�������
	//$CACHE->delete('core/modules', 'crontab', 'lock');

	message('done');

}