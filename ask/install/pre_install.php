<?php
defined('PHP168_PATH') or die();

$role = &$core->load_module('role');

//ϵͳ��ɫ{
//$guest_role      = $role->add(to_installed_charset('�ο�'),         $this_system->name, 'system');
//$member_role     = $role->add(to_installed_charset('��ͨ��Ա'),     $this_system->name, 'system');
//$vip_role		= $role->add(to_installed_charset('VIP��Ա'),		$this_system->name, 'system');
//ר��
//$expertor_role   = $role->add(to_installed_charset('�ʴ�ר��'),     $this_system->name, 'normal');
//����Ա
//$category_role   = $role->add(to_installed_charset('��Ŀ����Ա'),   $this_system->name, 'normal');


/*$this_system->set_config(
	array(
		'guest_role' => $guest_role,
		'member_role' => $member_role,
		'vip_role' => $vip_role,
		'expertor_role' => $expertor_role,
		'category_role' => $category_role		
	)
);*/
//ϵͳ��ɫ}

//����������
include PHP168_PATH .'modules/uploader/inc/init_system.php';

//ϵͳ����
include $this_system->path . 'install/config.php';