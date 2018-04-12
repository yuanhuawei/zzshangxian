<?php
defined('PHP168_PATH') or die();

/**
* 查看分类
**/
$pid=$cid;; //父ID；
$parent_cats = $category->get_parents($cid);
if($parent_cats){
	$pid = $parent_cats[0]['id'];
}	

$category->get_cache();
$level1= $category->categories[$pid]['categories'];
$level1 = array_reverse($level1,true);
$level1ids = array_keys($level1);



if(!in_array($cid,$level1ids)){
	$pcid = $level1ids[0];
	header("location:{$level1[$pcid]['url']}");
}else{
	$pcid = $cid;

}
$navs = array();
foreach($level1ids as $k=>$ccid){
	//echo $k.'-'.$ccid.'<br/>';
	if($ccid==$pcid){
	//echo "[$k]<br/>";
	$navs['mid'] = empty($level1ids[$k+3])? array_slice($level1,-4):((empty($level1ids[$k-1]))? array_slice($level1,$k,4):array_slice($level1,$k-1,4));
	 $navs['pre'] = empty($level1ids[$k+3])? array_slice($level1,-5,1):((empty($level1ids[$k-1]))? array():array_slice($level1,$k-2,1)); 
	$navs['aft'] = empty($level1ids[$k+3])? array():((empty($level1ids[$k-1]))? array_slice($level1,5,1):array_slice($level1,$k+3,1)); 

	}
}

//print_r($navs['pre']);exit;
//;
$count = count($subcategories);
if($count>4){
$CAT['is_category'] = true;
$page_url = p8_url($this_module, $CAT, 'list', false);
$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 4,
		'url' => $page_url,
		'template' => $P8LANG['paper_page'],
	));
}

$subcategories = array_slice($subcategories, ($page-1)*4,4);


//栏目
if($CAT['type'] == 2){
	
	//页面缓存
	page_cache($PAGE_CACHE_PARAM);
	
}
