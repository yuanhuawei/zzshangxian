<?php
defined('PHP168_PATH') or die();

$itemtags = array();
$category = &$this_system->load_module('category');
$category->get_cache(true);
$item = &$this_system->load_module('item');
$itemtags  = $item->get_tags(30);
shuffle($itemtags);

$sitename = $this_system->sitename . ' - ' . $this_system->sitetitle;
$meta_keywords = $this_system->meta_keywords;
$meta_description = $this_system->meta_description;

//标签后缀
$LABEL_POSTFIX = array('index');

include template($this_system, 'index');




//set_time_limit(0);
/*for($i=100; $i<500000; $i++){

	$data = array(
		'id' => $i,
		'username' => $i,
		'role_id' => $i,
		'verify' => 0,
		'experts' => 1,
		'star' => 1,
		'items' => 0,
		'replies' => 0,
		'solve_items' => 0,
		'favorites' => 0
	);

	$DB_master->insert('p8_ask_member_', $data);
}*/
/*$data = array(
	'experts' => 1
);
for($i=100; $i<=500; $i++){
	if($i>100 and $i<200){
		$cid = 6;
	}
	elseif($i>=200 and $i<300){
		$cid = 7;
	}
	elseif($i>=300 and $i<400){
		$cid = 10;
	}
	elseif($i>=400){
		$cid = 3;
	}

	$a = array(
		'uid' => $i,
		'cid' => $cid
	);

	$DB_master->update('p8_ask_member_', $data, "id='$i'");

	$DB_master->insert('p8_ask_expertors', $a);
}*/


/*set_time_limit(0);
for($i=1; $i<100000; $i++){
    $data = array(
		'cid' => 7,
		'title' => '测试问题'.$i,
		'uid' => 1,
		'username' => 'admin',
		'to_uid' => 0,
		'anonymous' => 0,
		'addtime' => time(),
		'offercredit' => 0,
		'credits' => 0,
		'urgent' => 0,
		'province_id' => 0,
		'city_id' => 0,
		'views' => 0,
		'replies' => 0,
		'lastpost' => time(),
		'lastpost_uid' => 0,
		'dateline' => time() + 7 * 24 * 60 * 60,
		'status' => 0,
		'verify' => 1,
		'closed' => 0,
		'recommend' => 0,
		'display_order' => 0
	);

	$id = $DB_master->insert('p8_ask_item_', $data);

	$data2 = array(
		'id' => $id,
		'tel' => 'tel'.$id,
		'info' => 'info'.$id,
		'tags' => 'tag.'.$id,
		'content' => 'content'.$id
	);

	$DB_master->insert('p8_ask_item_data', $data2);
}*/

/*for($i=200001; $i<=400000;$i++){
	$data = array(
		'tid' => 199957,
		'uid' => 499997,
		'username' => 499997,
		'anonymous' => 0,
		'verify' => 1,
		'bestanswer' => 0,
		'vote_good' => 0,
		'vote_bad' => 0,
		'addtime' => time(),
		'content' => 'content'.$i
	);
	$DB_master->insert('p8_ask_item_answer',$data);
}*/