<?php

/**
* ģ������ĺ���
**/

return array(
	'$core->get_cache' => 1,
	'$CACHE->read' => 1,
	'$CACHE->memcache_read' => 1,
	
	'$core->load_system' => 1,
	'$core->load_module' => 1,
	'$this_system->load_module' => 1,
	'$this_system->check_acl' => 1,
	
	'$this_controller->check_admin_action' => 1,
	'$this_controller->check_action' => 1,
	'$this_controller->get_acl' => 1,
	'$this_controller->verify_acl' => 1,
	'$this_controller->callfinction' => 1,
	
	'$category->get_children_ids' => 1,
	'$category->get_parents' => 1,
	'$category->get_cache' => 1,
	 
	'$LABEL->display' => 1,
	
	'$role->get_group_cache' => 1,
	'$this_controller->check_service' => 1,
	'$member->get_member_info' => 1,
	'$core->get_credit' => 1,
	'$answer_controller->check_action' => 1,
	
	//ip��
	'$IP->get' => 1,
	
	//����
	'$AREA->get_cache' => 1,
	'$AREA->get_parents' => 1,
	
	//�Լ�д�ı����������������  '$PLUGIN[\'�������\']->display' => 1,
	'$PLUGIN[\'anv\']->display' => 1,
);