<?php
defined('PHP168_PATH') or die();

//P8_Core::list_language($refresh = false)
	$handle = opendir(LANGUAGE_PATH);
	$language = array();
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;

		if(is_dir(LANGUAGE_PATH . $item) && ($config = @include LANGUAGE_PATH. $item .'/#.php')){
			$language[$item] = $config['name'];
		}
	}
	
	$this->set_config(array('language' => $language));
	
	return $language;