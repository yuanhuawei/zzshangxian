<?php
defined('PHP168_PATH') or die();

/**
* 首页生成静态
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	echo <<<EOT
<html>
<body>
<form id="form" action="$this_url" method="post">
<input type="hidden" name="_referer" value="$HTTP_REFERER" />
</form>
<script type="text/javascript">
if(confirm('$P8LANG[confirm_to_do]')){
	document.getElementById('form').submit();
}else{
	window.location.href = '$HTTP_REFERER';
}
</script>
</body>
</html>
EOT;
	
}else if(REQUEST_METHOD == 'POST'){
	//只接受POST
	
	//定义生成静态的常量
	define('P8_GENERATE_HTML', true);
	
	$type = $_POST['type'];
	
	$uri = '/index.php/'. $SYSTEM;
	
	if($type=='index_to_m_html'){
		$core->ismobile=1;
	}
	
	$_SERVER['_REQUEST_URI'] = $uri;
	
	ob_start();
	require PHP168_PATH .'index.php';
	echo $content = ob_get_clean();
	
	$index_file = $this_system->index_files[$this_system->CONFIG['index_file']];
	
	if($core->CONFIG['index_system'] == $this_system->name){
		if($type=='index_to_m_html' || $core->ismobile==1){
			write_file(PHP168_PATH .'m/'. $index_file, $content);
			@chmod(PHP168_PATH .'m/'. $index_file, 0644);
			set_cookie('ismobile',0,0);
			exit;
		}
		write_file(PHP168_PATH . $index_file, $content);
		@chmod(PHP168_PATH . $index_file, 0644);
	}
	write_file($this_system->path . $index_file, $content);
	@chmod($this_system->path . $index_file, 0644);
}
