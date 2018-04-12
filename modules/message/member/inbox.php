<?php
defined('PHP168_PATH') or die();

/**
 * 收件箱
 **/


if(REQUEST_METHOD == 'GET'){

	$type = isset($_GET['type']) ? $_GET['type'] : 'in';

	$page_url = $this_url .'?page=?page?';
	/**
	 群发的消息
	 $select = select();
	 $select->from($this_module->table .' AS m', 'm.id, m.username, m.title, m.new, m.timestamp');
	 $select->in('m.sendee_uid', 0);
	 $select->in('m.sender_uid', 0);
	 $select->in('m.role_id', array(0, $core->ROLE));
	 $select->order('m.role_id ASC, m.timestamp DESC');
	 $system_message_list = $core->list_item(
		$select,
		array(
		'page_size' => 0
		)
		);
		**/
	
	/*if($inte = $core->integrate()){
		//$inte->pm_list();
	}*/

	$select = select();
	$select->from($this_module->table .' AS m', 'm.id, m.username, m.title, m.new, m.timestamp');
	$select->in('m.sendee_uid', $UID);
	
	$select->order('m.timestamp DESC');
	
	switch($type){
		case 'new':
			$select->in('m.type', 'in');
			$select->in('m.new', 1);
			$page_url .= '&message_type=new';
		break;
		
		case 'nonew':
			$select->in('m.type', 'in');
			$select->in('m.new', 1, true);
			$page_url .= '&message_type=new';
		break;
		
		case 'public':
			$select->in('m.type', 'in');
			$select->in('m.sender_uid', 0);
			$page_url .= '&message_type=public';
		break;
		
		case 'private':
			$select->in('m.type', 'in');
			$select->in('m.sender_uid', 0, true);
			$page_url .= '&message_type=private';
		break;
		
		case 'rubbish':
			$select->in('m.type', 'rubbish');
			$page_url .= '&message_type=rubbish';
		break;
		default:
			$select->in('m.type', 'in');
	}
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	$count = 0;
	$page_size = 10;

	$holder = '';
	$holder .= '&type=in&type='. $type;
	$holder .= '&page='. $page;
	//$holder = urlencode($holder);
	
	//echo $select->build_sql();

	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size
		)
	);

	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));
	if(P8_AJAX_REQUEST){
		$page_url = $this_url .'?';
		$page_url = 'javascript:IntraMail.request_item(?page?)';
		$json = p8_json(
			array('list'=>$list, 
			'pages'=>list_page(array(
				'count' => $count,
				'page' => $page,
				'page_size' => $page_size,
				'url' => $page_url
			))
			
			));
		exit($json);
	}

	include template($this_module, 'inbox');
}
//include template($this_module, 'member/inbox');