<?php
require dirname(__FILE__) .'/../inc/init.php';

$inte = &$core->integrate();

getGP(array('action','forward','verify','userdb'));

if(empty($inte->CONFIG['code']) || md5($action.$userdb.$forward.$inte->CONFIG['code']) != $verify){
	exit('PW!');
}

parse_str($inte->StrCode($userdb, 'DECODE'), $data);

if($action == 'login'){
	
	$member = &$core->load_module('member');
	
	$m = get_member($data['username']);
	if(empty($m)){
		$member->register(
			$data['username'], $data['password'], $data['email'],
			array('id' => $data['uid'], 'salt' => '', 'password' => $data['password'])
		);
	}
	
	$member->login($data['username'], '', $data['uid']);
	
	header('Location: '. $forward);
	
}else if($action == 'quit'){
	
	$member = &$core->load_module('member');
	$member->logout();
	
	header('Location: '. $forward);
	
}