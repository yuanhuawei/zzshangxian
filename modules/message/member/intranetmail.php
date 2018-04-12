<?php
defined('PHP168_PATH') or die();

/**
* ·¢¼þÏä
**/

if(REQUEST_METHOD == 'GET'){

$navgation = array(
array(
	'url'=>$this_url,'title'=>$P8LANG['intranetemail']
	)
);
$baner = 'qiyeyoujian';
$TITLE = '';
include template($this_module, 'intranetmail');
}elseif(REQUEST_METHOD == 'POST'){


}