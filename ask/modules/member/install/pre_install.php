<?php
defined('PHP168_PATH') or die();

//�����ϴ�����
include PHP168_PATH .'modules/uploader/inc/init_system.php';


//�ϴ�ģ��ҹ�����ģ��
//$uploader->hook($this_system->name, $this_module->name, 'item_id');

//$credit = &$core->load_module('credit');


//$controller = &$core->controller($credit);
//1������
/*$controller->add_rule(
	array(
		'credit_id' => $core->CONFIG['common_credit'],
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'insert',
		'credit' => 1
	)
);*/

//һ�췢��ֻ�ܵ�1�����
/*$controller->add_rule(
	array(
		'credit_id' => $core->CONFIG['gold_credit'],
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'post_ask',
		'credit' => 1
	)
);*/

//��ɾ��-1����
/*$controller->add_rule(
	array(
		'credit_id' => $core->CONFIG['common_credit'],
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'delete',
		'credit' => -1,
	)
);*/