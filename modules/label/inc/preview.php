<?php
defined('PHP168_PATH') or die();

/**
* 预览兼检验
**/

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	//error_reporting(0);
	
	//$_POST = from_utf8($_POST);
	//valid_data
	//$label = $LABEL->valid_data($_POST);
	
	if($label['type'] == 'sql'){
		$sql = preg_replace('!--[^\r\n]*|#[^\r\n]*|/\*[\s\S]*\*/!', '', $label['content']);
		//危险的,你懂的
		if(!preg_match('/^select/i', $sql) || preg_match('/into\s+outfile/i', $sql)) exit('false');
	}
	
	if(empty($_GET['_verify'])){
		//预览,读出数据
		if($label['type'] == 'module_data'){
			
			//自己定义的标签函数,默认是label
			$method = empty($label['option']['method']) ? 'label' : $label['option']['method'];
			$ret = method_exists($this_module, $method) ? $this_module->$method($LABEL, $label, $var) : array();
			
			echo isset($ret[0]) ? $ret[0] : '';
			exit;
			
		}else if($label['type'] == 'sql'){
			
			$list = $DB_slave->fetch_all($sql);
		}
	}
	
	if(!empty($_GET['_verify'])) ob_start();
	
	//如果验证的话,只检查内容模板是否有错即可
	if(empty($label['option']['tplcode'])){
		
		include template($TEMP_OBJ, $label['option']['template'], 'label');
		
		$ret = true;
	}else{
		
		require_once PHP168_PATH .'inc/template.func.php';
		$tplcode = template_compile($label['option']['tplcode']);
		$tplcode = str_replace(array('<?php', '?>'), array('', ''), $tplcode);
		//$tplcode = stripslashes($tplcode);
		$ret = @eval($tplcode) !== false;
		
	}
	
	if(!empty($_GET['_verify'])){
		ob_end_clean();
		exit($ret ? 'true' : 'false');
	}
	
}