<?php
defined('PHP168_PATH') or die();

//header('Content-type: text/json; charset=utf-8');

if(REQUEST_METHOD == 'GET'){
	isset($_GET['data']) && isset($_GET['name']) or exit('');
	
	switch($_GET['name']){
	
	case 'username':
		switch($this_controller->check_username(p8_addslashes(from_utf8($_GET['data'])))){
			case 0: exit('true');
			case -1: case -2: exit('false');
		}
	break;
	
	case 'email':
		switch($this_controller->check_email(p8_addslashes($_GET['data']))){
			case 0: exit('true');
			case -1: case -2: exit('false');
		}
	break;
	
	case 'register_question':
		$this_module->verify_question(from_utf8($_GET['data']), true) or exit('false');
		exit('true');
	break;
	
	}
}
exit('false');