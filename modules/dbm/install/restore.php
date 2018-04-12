<?php

$path = dirname(__FILE__) .'/';
if(is_file($path .'lock.lock')){
	//Ëø¶¨
	exit('');
}

function _poster(){
	$inputs = '';
	foreach($_POST as $k => $v){
		$inputs .= '<input type="hidden" name="'. $k .'" value="'. $v .'" />';
	}
	
	return <<<EOT
<html>
<head></head>
<body>
<form id="form" method="POST">
$inputs
</form>
<script type=""></script>
</body>
</html>
EOT;
}

if(empty($_GET['start'])){
	$files = glob($path .'data_*.php');
	
	header('Location: ');
}


