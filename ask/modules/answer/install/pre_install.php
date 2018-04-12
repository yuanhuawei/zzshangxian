<?php
defined('PHP168_PATH') or die();

//挂勾到分类模块去
$this_module->hook($this_system->name, 'category', 'cid');
//挂勾到会员模块去
$this_module->hook('core', 'member', 'uid');

$uploader = &$core->load_module('uploader');
//开启上传功能
require $uploader->path .'inc/enables.php';
//上传模块挂勾到本模块
$uploader->hook($this_system->name, $this_module->name, 'answer_id');


//$credit = &$core->load_module('credit');
//$controller = &$core->controller($credit);
//1个积分
/*$controller->add_rule(
	array(
		'credit_id' => $core->CONFIG['common_credit'],
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'insert',
		'credit' => 1
	)
);*/

//一天发布只能得1个金币
/*$controller->add_rule(
	array(
		'credit_id' => $core->CONFIG['gold_credit'],
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'post_ask',
		'credit' => 1
	)
);*/

//被删除-1积分
/*$controller->add_rule(
	array(
		'credit_id' => $core->CONFIG['common_credit'],
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'delete',
		'credit' => -1,
	)
);*/