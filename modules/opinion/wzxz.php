<?php
defined('PHP168_PATH') or die();

$Letter = $core->load_module('letter');
$controller = $core->controller($Letter);
load_language($Letter, 'global');

$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
$TITLE = $core->CONFIG['site_name'];

$department = isset($_GET['department']) ?  intval($_GET['department']) : '';

$cates = $Letter->get_category();

if(!$department){
	if($cates)
		foreach($cates['department'] as $deb){
			$department = $deb['id'];break;
		}
}
if(!$department)message('no_such_item');

$page = isset($_GET['page'])? intval($_GET['page']): 1;
	
	//搜索开始
	$page_url = $this_url.'?page=?page?&';
	$count = 0;

	$select = select();
	$select -> from("$Letter->table",'id,number,username,department,type,title,create_time,solve_time,status,status_change_time');
	
	$my_manage = $this_controller->get_acl('my_letter_manage');
//print_r($my_manage);

	$id_type = $Letter->id_type();

	$acl_where = $split = '';
	if(!$IS_FOUNDER){
		foreach($my_manage as $dep=>$tys){
			$tys=implode(',',$tys);
			if($dep)
				$acl_where .= " $split (department='$dep' AND type IN($tys))";
			else
				$acl_where .= " $split type IN($tys)";
			$split = ' OR ';	
		}
		if($acl_where){
			$acl_where = " (($acl_where) OR (visual=1 AND undisplay=0))";
			$select ->where_and();
			$select ->where($acl_where);
		}else{
			$select -> in('visual',1);
			$select -> in('undisplay',0);
		}
	}
	
	$page_param = array();
	
	$keytype = isset($_POST['keytype'])?p8_html_filter($_POST['keytype']):'';

	//搜索条件
	if($department){
		$page_param['department']=$department;
		$select -> in('department',$department);
	}
	
	$number = isset($_GET['number']) ? p8_html_filter($_GET['number']) : '';
	if($number){
		$page_param['number']=$number;
		$select -> in('number',$number);
	}
	$keyword = isset($_POST['keyword']) ? p8_html_filter($_POST['keyword']) : '';
	
	if($keyword){
		$keytypes = array('number','title');
		$page_param['keyword']=$keyword;
		if(in_array($keytype,$keytypes))
			$select -> like($keytype,$keyword);
		elseif($keytype=='create_time'){
			$select -> like('FROM_UNIXTIME(create_time)',$keyword);
		}elseif($keytype=='type'){
			foreach($cates['type'] as $tt){
				if(strpos($tt['name'],$keyword)!==false)
					$_GET['type']=$tt['id'];
			}
		}

	}		
	$type = isset($_GET['type']) ? intval($_GET['type']) : '';
	if($type){
		$page_param['type']=$type;
		$select -> like('type',$type);
	}
	$username = isset($_GET['username']) ? p8_html_filter($_GET['username']) : '';
	if($username){
		$page_param['username']=$username;
		$select -> like('username',$username);
	}
	$status = isset($_GET['status']) ? intval($_GET['status']) : '';
	if($status){
		
		$page_param['status']=$status;
		if($status==1)
			$select -> range('status','1','2');
		if($status==3)
			$select -> in('status','3');	
	}
	
	
	
	$select -> order(' id DESC');
//echo $select->build_sql();	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 40
		)
	);

	if($page_param){
		$page_param = http_build_query($page_param);
		$page_url .=(strpos($page_url,'&')===false? '?':'&').$page_param;
	}
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 40,
		'url' => $page_url
	));
	
	foreach($list as $key=>$row){
		$list[$key]['status_name'] = $P8LANG['status_'.$row['status']];
		$list[$key]['department_name'] = $cates['department'][$row['department']]['name'];
		$list[$key]['type_name'] = $cates['type'][$row['type']]['name'];
		$list[$key]['url'] = $Letter->controller.'-view-id-'.$row['id'];
		$list[$key]['title_s'] = p8_cutstr($row['title'],44);
		$list[$key]['dp'] = $Letter->getdp($row);
	}

	
	
	$tatistics = $Letter->getstatistics2();

	$today  = $Letter->get_total(array('department'=>$department,'begin_time'=>'last monday'));
	$alldata = $Letter->get_total(array('department'=>$department));
	

//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'wzxz_'.intval($department));	

include template($this_module, 'wzxz');
