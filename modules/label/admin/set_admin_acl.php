<?php
defined('PHP168_PATH') or die();

/*
* ÏÔÊ¾ÓòÈ¨ÏÞ
*/

if(REQUEST_METHOD == 'GET'){
	$role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : 0;
	
	$role = &$core->load_module('role');

	$acl = $role->get_acl($core, $role_id);
	$info = include $core->path .'#.php';
	
	$acls = $role->get_acl($this_module, $role_id);
	$scope = $acls['scope'];
	
	include template($this_module, 'set_acl', 'admin');
	
}else if(REQUEST_METHOD == 'POST'){
	
	$acl = isset($_POST['acl']) && is_array($_POST['acl']) ? $_POST['acl'] : array();
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	$postfix = isset($acl['postfix']) ? (array)$acl['postfix'] : array();
	
	$scope = array();
	foreach($postfix as $k => $v){
		if(empty($acl['system'][$k])) continue;
		
		$module = isset($acl['module'][$k]) ? $acl['module'][$k] : '';
		$scope[ $acl['system'][$k] ][ $module ][ $v ] = true;
	}
	
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	
	$controller->set_acl($this_module, $role_id, array('scope' => $scope));
	
	message('done', HTTP_REFERER);
}