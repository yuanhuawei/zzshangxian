<?php

defined('PHP168_PATH') or die();



$this_controller->check_admin_action('client') or message('no_privilege');



if(REQUEST_METHOD == 'GET'){

	

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$page = max(1, $page);

	

	$page_url = $this_url .'?page=?page?';

	

	

	//11111111.11111111.11111111.00000000

	//

	//select * from $this_module->table where role_view = 1 or other_view = 1

	//role_priv 1 view 2 edit 3 log		other_priv	1 view 2

	$select = select();

	//$select->from($this_module->table .' AS i', 'i.id, i.uid, i.username, i.name, i.type, i.property, i.timestamp');

	$select->from($this_module->table .' AS i', 'i.id, i.content,i.timestamp');

	

	//$select->in('uid', $UID);

	

	$select->order('id DESC');

	

	

	$page_size = 20;

	$count = 0;

	

	//echo $select->build_sql();

	

	$list = $core->list_item(

		$select,

		array(

			'count' => &$count,

			'page' => &$page,

			'page_size' => $page_size

		)

	);

	

	$pages = list_page(array(

		'count' => $count,

		'page' => $page,

		'page_size' => $page_size,

		'url' => $page_url

	));

	

	include template($this_module, 'list', 'admin');

	

}