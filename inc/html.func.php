<?php
defined('PHP168_PATH') or die();

/**
* 取HTML文件物理路径
* @param object $module 模块对象
* @param array $data 一条数据
* @param string $action 动作
* @param bool $first_page 第一页?
**/
function p8_html_url(&$M, &$data, $action = 'view', $first_page = true){
	
	$category_url = '';
	$have_category = false;
	if(isset($data['#category'])){
		//有URL直接退出
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
			//模块是生成静态的
			if(empty($data['html_'. $action .'_url_rule'])){
				$url = $M->CONFIG['html_'. $action .'_url_rule'];
			}else{
				//如果数据本身有规则,则用数据本身的规则
				$url = $data['html_'. $action .'_url_rule'];
			}
		}
	}
	
	if($first_page){
		$url = preg_replace('/#([^#]+)#/', '', $url);
	}
	$url = valid_path($url);
	
	$ext = trim(file_ext($url));
	//只能生成htm,html,shtml#xx这样的后缀名
	if(!preg_match('/^(htm|html|shtml)#?$/i', $ext)){
		return '';
	}
	
	//如果有时间戳,处理时间戳,入库时间戳字段名最好统一用timestamp
	if(isset($data['timestamp'])){
		list($Y, $y, $m, $d, $H) = explode('|', date('Y|y|m|d|H', $data['timestamp']));
	}
		
	$page = '?page?';
	$core_url = rtrim(PHP168_PATH,'/');
	$core_m_url = PHP168_PATH.'/m';
	$module_url = $M->path;
	$system_url = $M->system->path;
	
	@extract($data, EXTR_SKIP);
	
	//不能断开", 如$url = "aaa"; file_put_content('e.php', 'php code'); //";
	eval('$url = "'. $url .'";');
		
	//不能生成系统文件夹以外的范围
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