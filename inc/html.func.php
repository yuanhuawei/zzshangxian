<?php
defined('PHP168_PATH') or die();

/**
* ȡHTML�ļ�����·��
* @param object $module ģ�����
* @param array $data һ������
* @param string $action ����
* @param bool $first_page ��һҳ?
**/
function p8_html_url(&$M, &$data, $action = 'view', $first_page = true){
	
	$category_url = '';
	$have_category = false;
	if(isset($data['#category'])){
		//��URLֱ���˳�
		if(!empty($data['url'])){
			return '';
		}
		
		$cat = &$data['#category'];
		$have_category = true;
	}else if(isset($data['is_category'])){
		$have_category = true;
		$cat = &$data;
	}
		
	if($have_category){
		if(/*empty($data['htmlize']) || */empty($cat['htmlize'])/* || empty($cat[$action .'_htmlize'])*/){
			return '';
		}else{
			$url = empty($data['html_'. $action .'_url_rule']) ? 
				$cat['html_'. $action .'_url_rule'] : 
				$data['html_'. $action .'_url_rule'];
		}
		
		$category_url = $M->system->path . $cat['path'];
	}else{
		
		if(/*empty($data['htmlize']) || */empty($M->CONFIG['htmlize'])){
			return '';
		}else{
			//ģ�������ɾ�̬��
			if(empty($data['html_'. $action .'_url_rule'])){
				$url = $M->CONFIG['html_'. $action .'_url_rule'];
			}else{
				//������ݱ����й���,�������ݱ���Ĺ���
				$url = $data['html_'. $action .'_url_rule'];
			}
		}
	}
	
	if($first_page){
		$url = preg_replace('/#([^#]+)#/', '', $url);
	}
	$url = valid_path($url);
	
	$ext = trim(file_ext($url));
	//ֻ������htm,html,shtml#xx�����ĺ�׺��
	if(!preg_match('/^(htm|html|shtml)#?$/i', $ext)){
		return '';
	}
	
	//�����ʱ���,����ʱ���,���ʱ����ֶ������ͳһ��timestamp
	if(isset($data['timestamp'])){
		list($Y, $y, $m, $d, $H) = explode('|', date('Y|y|m|d|H', $data['timestamp']));
	}
		
	$page = '?page?';
	$core_url = rtrim(PHP168_PATH,'/');
	$core_m_url = PHP168_PATH.'/m';
	$module_url = $M->path;
	$system_url = $M->system->path;
	
	@extract($data, EXTR_SKIP);
	
	//���ܶϿ�", ��$url = "aaa"; file_put_content('e.php', 'php code'); //";
	eval('$url = "'. $url .'";');
		
	//��������ϵͳ�ļ�������ķ�Χ
	//if(strpos($url, $system_url) === 0){
		return $url;
	//}
	
	return '';
}

function poster($task, $thread_id = 1){
	return '
<html>
<body>
<form action="'. REQUEST_URI .'" method="POST" id="form">
<input type="hidden" name="task" value="'. $task .'" />
<input type="hidden" name="thread_id" value="'. $thread_id .'" />
</form>
<script>
setTimeout(function(){document.getElementById(\'form\').submit()}, 1);
</script>
</body>
</html>
';
}

function array_to_php($array){
	return "<?php\r\nreturn ".var_export($array, true) .";";
}