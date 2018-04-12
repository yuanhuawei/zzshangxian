<?php
defined('PHP168_PATH') or die();

load_language($this_module, 'global');

$this_module->set_config(array(
	'verify_acl' => array(
		1 => array(
			'name' => $P8LANG['cms_item']['verify'][1],
			'role' => array(
				$core->CONFIG['administrator_role'] => 1,
				$this_system->CONFIG['verifier_role'] => 1
			)
		),
		
		0 => array(
			'name' => $P8LANG['cms_item']['verify'][0],
			'role' => array(
				$core->CONFIG['administrator_role'] => 1,
				$this_system->CONFIG['verifier_role'] => 1
			)
		),
		
		-99 => array(
			'name' => $P8LANG['cms_item']['verify'][-99],
			'role' => array(
				$core->CONFIG['administrator_role'] => 1,
				$this_system->CONFIG['verifier_role'] => 1
			)
		)
	)
));