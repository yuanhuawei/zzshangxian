<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action('html') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	include template($this_system, 'html_all', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	GetGP(array('type'));
	
	switch($type){
	
	case 'index_to_html':
		$system = isset($_POST['index_to_html']) ? $_POST['index_to_html'] : '';
		
		define('P8_GENERATE_HTML', true);
		
		if(empty($system)){
			
			$form = '';
			foreach($core->systems as $k => $v){
				//�ύ��,�ύ��������ϵͳ
				$form .= '<form action="'. $this_url .'" method="post" id="form'. $k .'" target="'. $k .'">'.
					'<input type="hidden" name="type" value="index_to_html" />'.
					'<input type="hidden" name="index_to_html" value="'. $k .'" />'.
					'</form>'.
					'<iframe style="display: none;" name="'. $k .'"></iframe>'.
					'<script type="text/javascript">document.getElementById("form'. $k .'").submit();</script>';
			}
			
			message($P8LANG['done'] . $form);
			exit;
			
		}else{
				
			//���ɵ���ϵͳ����ҳ
			$this_system = &$core->load_system($system);
				
			$_SERVER['_REQUEST_URI'] = '/index.php/'. $system;
			
			ob_start();
			require PHP168_PATH .'index.php';
			$content = ob_get_clean();
			//$content = strlen($content);
			//�ļ�����300�ֽ�����
			if(strlen($content)>300){
				/*�������ļ��滻ǰ���ȸ��Ʊ���*/
				cp($this_system->path .'index.html', $this_system->path .'index_bak.html');				
				write_file($this_system->path .'index.html', $content);
				/*�ж��ļ��Ƿ����ɣ�������Ӧ����300�ֽ�*/
				if(filesize($this_system->path .'index.html') < 300)
					cp($this_system->path .'index_bak.html', $this_system->path .'index.html');
				
				if($core->CONFIG['index_system'] == $system){
					cp(PHP168_PATH .'index.html', PHP168_PATH .'index_bak.html');					
					write_file(PHP168_PATH .'index.html', $content);
					if(filesize(PHP168_PATH .'index.html') < 300)
						cp(PHP168_PATH .'index_bak.html', PHP168_PATH .'index.html');
				}
			}
		}
	break;
	
	}
	
	message('done');
}