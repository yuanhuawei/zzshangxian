<?php
defined('PHP168_PATH') or die();

class P8_CMS_Statistic extends P8_Module{
var $data_table; 
var $member_table; 

function P8_CMS_Statistic(&$system, $name){

	$this->configurable = false;
	$this->system = &$system;
	parent::__construct($name);
	$this->data_table = $this->TABLE_.'data';
	$this->member_table = $this->TABLE_.'member';
	$this->cluster_table = $this->TABLE_.'cluster';
	$this->sites_push_table = $this->TABLE_.'sites_push';
	$this->sites_content_table = $this->TABLE_.'sites_content';
}

function getStatic($year,$month=0,$cid=0,$model='',$uid=0, $download=false){
	global $P8LANG;
	$cids = array();
	
	$where = "1=1";
	$orderby = '';
	if($year && $month){
		$group = " day";
	
		$where .= " AND year='$year' AND month='$month'";
		$orderby = " day DESC";
	}elseif($year){
		$group = " month";
		$where .= " AND year='$year'";
		$orderby = " month DESC";
	}elseif($month){
		$group = " year";
		$where .= " AND month='$month'";
		$orderby = " year DESC";
	}else{
		$group = " year";
		$orderby = " year DESC";
	}
	
	if($cid){
		$category = $this->system->load_module('category');
		$category->get_cache(false);
		$cids = $category->get_children_ids($cid);
		array_unshift($cids,$cid);
		$where .= " AND cid IN (".implode(',',$cids).")";
	}
	
	if($model){
		$where .= " AND model='$model'";
	}
	
	if($uid){
		$this->data_table = $this->member_table;
		$where .= " AND uid='$uid'";
	}

	$sql = "SELECT cid,model,year,month,day,FROM_UNIXTIME(timestamp,'%Y-%m-%d %H:%i:%s') AS timestamp,SUM(post) AS post,SUM(comment) AS comment,SUM(visit) AS visit FROM {$this->data_table} WHERE $where GROUP BY $group ORDER BY $orderby";
	//echo $sql;exit;
	$data = $this->DB_slave->fetch_all($sql);
	if($download){
		foreach($data as $key=>$row){
			$dodata[$key]['time'] = $row['year'].($year!='0'? '-'.$row['month']:'').(($year!='0' && $month!='0')? '-'.$row['day']:'');
			$dodata[$key]['post'] = $row['post'];
			$dodata[$key]['comm'] = $row['comment'];
		}
		$headertext=array($P8LANG['date'],$P8LANG['post'],$P8LANG['comment']);
		require PHP168_PATH.'/inc/excel.class.php';
		$export=new excel(1);
		$export->setFileName('statistic','download',date('Y-m-d-h-i-s', P8_TIME));
		$export->fileHeader($headertext);		
		$export->fileData($dodata);
		$export->fileFooter();
		$export->exportFile();
	}else{
		return $data;
	}

}

function statistic($year,$month=0,$cid=0,$model=''){
	$cids = array();
	if($cid){
		$category = $this->system->load_module('category');
		$category->get_cache(false);
		$cids = $category->get_children_ids($cid);
	}
	$this->day_statistic($year,$month,$cids);
	return true;
	

}

function getStaticMember($gid=0, $rid=0, $year=0, $month=0, $cid='', $model='',$page=1){
	$cids = array();
	
	$where = "1=1";
	
	
	if($gid)
		$where .= " AND u.role_gid='$gid'";
	if($rid)
		$where .= " AND u.role_id='$rid'";
	
	$sql = "SELECT COUNT(1) as num FROM {$this->core->TABLE_}member as u WHERE $where ";
	$count = $this->DB_slave->fetch_one($sql);
	$count = $count['num'];
	$page_sige = 15;
	$offset = ($page-1)*$page_sige;
	
	$orderby = '';
	if($year && $month){
		$where .= " AND s.year='$year' AND s.month='$month'";
	}elseif($year){
		$where .= " AND s.year='$year'";
	}elseif($month){
		$where .= " AND s.month='$month'";
	}else{
	
	}
	
	
	if($cid){
		$category = $this->system->load_module('category');
		$category->get_cache(false);
		foreach($cid as $id){
			if(!$id)continue;
			$cidss = $category->get_children_ids($id);
			$cid = array_merge($cid,$cidss);
		}
		$where .= " AND s.cid IN (".implode(',',$cid).")";
	}
	if($model){
		$where .= " AND s.model='$model'";
	}
	
	$sql = "SELECT u.username,u.id,u.name, s.cid,s.model,s.year,s.month,s.day,
			FROM_UNIXTIME(timestamp,'%Y-%m-%d %H:%i:%s') AS timestamp,SUM(post) AS post,SUM(comment) AS comment,SUM(visit) AS visit 
			FROM {$this->core->TABLE_}member AS u
			LEFT JOIN {$this->member_table} AS s ON u.id=s.uid
			WHERE $where GROUP BY u.id ORDER BY post DESC,u.display_order DESC LIMIT $offset,$page_sige";
	//echo $sql;exit;
	$data = $this->DB_slave->fetch_all($sql);
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_sige,
		'url' => 'javascript:request_item(?page?)'
	));
	return array('list'=>$data,'page'=>$pages);

}

function statisticMember($gid=0, $rid=0, $year, $month=0, $cid='', $model='',$step=0){
	$cids = array();
	if($cid){
		$category = $this->system->load_module('category');
		$category->get_cache(false);
		foreach($cid as $id){
			if(!$id)continue;
			$cidss = $category->get_children_ids($id);
			$cid = array_merge($cid,$cidss);
		}
	}
	$cids = $cid;
	$where= "1=1";
	if($gid)
		$where .= " AND role_gid='$gid'";
	if($rid)
		$where .= " AND role_id='$rid'";
	$limit = 100;
	
	$sql = "SELECT id FROM {$this->core->TABLE_}member WHERE $where LIMIT $step,$limit";
	$uids = $this->DB_slave->fetch_all($sql);
	if($uids){
		foreach($uids as $row){
			$this->day_statistic($year,$month,$cids,$row['id']);
		}
		return array('step'=>$step+$limit);
	}else{
		return array('step'=>0);
	}
	
}
function statisticCluster($year, $month=0, $cid='', $model=''){
	$this->statisticClusterDay($year,$month,$cid);
	return true;
}
function statisticClusterDay($year,$month,$cids){
	if($month){
		$begin = strtotime("$year-$month-01 00:00:00");
		$end = strtotime("+1 month",$begin);
	}else{
		$begin = strtotime("$year-01-01 00:00:00");
		$end = strtotime("+1 year",$begin);
	}
	$time = time();
	
	$cluster = $this->core->load_module('cluster');
	$cms_item_server  = $cluster->load_service('server','cms_item');
	//---------
	$where = $cids? " AND client_id IN (".implode(',',$cids).")" : '';
	$sql = "SELECT COUNT(1) FROM {$cms_item_server->table} WHERE timestamp>='$begin' AND timestamp<'$end' $where";
	$C1 = $this->DB_slave->fetch_one($sql);
	if(!$C1)return;
	//---------
	
	$table = $this->cluster_table;
	
	$sql = "DELETE FROM {$table} WHERE year='$year'";
	if($month)
		$sql .= " AND month='$month'";
	if($cids)
		$sql .= " AND client_id IN (".implode(',',$cids).")";

	$this->DB_slave->query($sql);	
	
	for($day=$begin;$day<$end;$day+=86400){
		$where = $cids? " AND client_id IN (".implode(',',$cids).")" : '';

		$sql = "SELECT client_id,cid, model,SUM(IF(status,1,0)) AS verified,SUM(IF(status,0,1)) AS unverified,COUNT(id) AS post,FROM_UNIXTIME(timestamp,'%m') AS month,FROM_UNIXTIME(timestamp,'%d') AS day FROM {$cms_item_server->table} WHERE timestamp>='$day' AND timestamp<'".($day+86400)."' $where GROUP BY client_id";
		$_pdata = $this->DB_slave->fetch_all($sql);
		$pdata = $pk = array();
		if($_pdata)foreach($_pdata as $key=>$row){
			$pdata[$row['client_id']] = $row;
			$pk[] = $row['client_id'];
		}
		
		if($pk)foreach($pk as $k){
			$post = !empty($pdata[$k])? $pdata[$k]['post'] : 0;
			$verified = !empty($pdata[$k])? $pdata[$k]['verified'] : 0;
			$unverified = !empty($pdata[$k])? $pdata[$k]['unverified'] : 0;
			$comment = 0;
			if($post){
				$model = !empty($pdata[$k])? $pdata[$k]['model'] : $cdata[$k]['model'];
				$month = !empty($pdata[$k])? $pdata[$k]['month'] : $cdata[$k]['month'];
				$date = !empty($pdata[$k])? $pdata[$k]['day'] : $cdata[$k]['day'];
				$cid = !empty($pdata[$k])? $pdata[$k]['cid'] : $cdata[$k]['cid'];
				$sql = "INSERT IGNORE {$table} (`client_id`,`cid`,`model`,`year`,`month`,`day`,`post`,`verified`,`unverified`,`timestamp`) 
						VALUES('$k','$cid','$model','$year','$month','$date','$post','$verified','$unverified','$time');";
				$this->DB_slave->query($sql);	
			}			
		}
	}	
}

function getStaticCluster($year,$month=0,$cid=0,$model='',$download=false){
	global $P8LANG;
	
	$where = "1=1";
	$orderby = '';
	if($year && $month){
		$group = " day";
	
		$where .= " AND year='$year' AND month='$month'";
		$orderby = " day DESC";
	}elseif($year){
		$group = " month";
		$where .= " AND year='$year'";
		$orderby = " month DESC";
	}elseif($month){
		$group = " year";
		$where .= " AND month='$month'";
		$orderby = " year DESC";
	}else{
		$group = " year";
		$orderby = " year DESC";
	}
	
	if($cid){
		$where .= " AND client_id ='$cid'";
	}
	
	if($model){
		$where .= " AND model='$model'";
	}


	$sql = "SELECT client_id,cid,model,year,month,day,FROM_UNIXTIME(timestamp,'%Y-%m-%d %H:%i:%s') AS timestamp,SUM(post) AS post,SUM(verified) AS verified FROM {$this->cluster_table} WHERE $where GROUP BY $group ORDER BY $orderby";
	//echo $sql;exit;
	$data = $this->DB_slave->fetch_all($sql);
	if($download){
		foreach($data as $key=>$row){
			$dodata[$key]['time'] = $row['year'].($year!='0'? '-'.$row['month']:'').(($year!='0' && $month!='0')? '-'.$row['day']:'');
			$dodata[$key]['post'] = $row['post'];
		}
		$headertext=array($P8LANG['date'],$P8LANG['post'],$P8LANG['comment']);
		require PHP168_PATH.'/inc/excel.class.php';
		$export=new excel(1);
		$export->setFileName('statistic_cluster','download',date('Y-m-d-h-i-s', P8_TIME));
		$export->fileHeader($headertext);		
		$export->fileData($dodata);
		$export->fileFooter();
		$export->exportFile();
	}else{
		return $data;
	}

}
function downloadMember($gid, $rid, $year, $month, $cid, $model,$uids){
	global $P8LANG;
	
	$cids = array();
	
	$where = "1=1";
	$orderby = '';
	if($year && $month){
		$where .= " AND s.year='$year' AND s.month='$month'";
	}elseif($year){
		$where .= " AND s.year='$year'";
	}elseif($month){
		$where .= " AND s.month='$month'";
	}else{
	
	}
	
	
	if($cid){
		$category = $this->system->load_module('category');
		$category->get_cache(false);
		foreach($cid as $id){
			if(!$id)continue;
			$cidss = $category->get_children_ids($id);
			$cid = array_merge($cid,$cidss);
		}
		$where .= " AND s.cid IN (".implode(',',$cid).")";
	}
	if($model){
		$where .= " AND s.model='$model'";
	}
	
	if($gid)
		$where .= " AND u.role_gid='$gid'";
	if($rid)
		$where .= " AND u.role_id='$rid'";
	if($uids){
		$uids = substr($uids,1);
		$where .= " AND u.id IN ($uids)";
	}	
	
	$sql = "SELECT u.username, IF(SUM(post),SUM(post),0) AS post,IF(SUM(comment),SUM(comment),0) AS comment
			FROM {$this->core->TABLE_}member AS u 
			LEFT JOIN {$this->member_table} AS s ON u.id=s.uid
			WHERE $where GROUP BY u.id ORDER BY post DESC,u.display_order DESC";
	//echo $sql;exit;
	$data = $this->DB_slave->fetch_all($sql);
	if($data){
		$headertext=array($P8LANG['user'],$P8LANG['post'],$P8LANG['comment']);
		require PHP168_PATH.'/inc/excel.class.php';
		$export=new excel(1);
		$export->setFileName('statistic','download',date('Y-m-d-H-i-s', P8_TIME));
		$export->fileHeader($headertext);		
		$export->fileData($data);
		$export->fileFooter();
		$export->exportFile();
	}
}

function day_statistic($year,$month,$cids,$uid=0){
	if($month){
		$begin = strtotime("$year-$month-01 00:00:00");
		$end = strtotime("+1 month",$begin);
	}else{
		$begin = strtotime("$year-01-01 00:00:00");
		$end = strtotime("+1 year",$begin);
	}
	$time = time();
	$hh = fopen('wwww.txt','a');
		fwrite($hh,"$year,$month,".implode('|',$cids).",$uid"."\r\n");
		fclose($hh);
	//---------
	$where = $cids? " AND cid IN (".implode(',',$cids).")" : '';
	if($uid)$where .= " AND uid='$uid'";
	$sql = "SELECT COUNT(1) AS c0 FROM {$this->system->TABLE_}item WHERE timestamp>='$begin' AND timestamp<'$end' $where";
	$sql2 = "SELECT COUNT(1) AS c1 FROM {$this->system->TABLE_}item_unverified WHERE timestamp>='$begin' AND timestamp<'$end' $where";
	$C10 = $this->DB_slave->fetch_one($sql);
	$C11 = $this->DB_slave->fetch_one($sql2);
	$C1 = $C10['c0'] + $C11['c1'];
	
	$where = $cids? " AND i.cid IN (".implode(',',$cids).")" : '';
	if($uid)$where .= " AND c.uid='$uid'";
	$sql = "SELECT COUNT(1) AS c2, FROM_UNIXTIME(c.timestamp,'%d') AS day FROM {$this->system->TABLE_}item_comment AS c
				LEFT JOIN {$this->system->TABLE_}item AS i ON i.id=c.iid
				WHERE c.timestamp>='$begin' AND c.timestamp<'$end' $where GROUP BY day";
	$C2 = $this->DB_slave->fetch_one($sql);
	if(!$C1 && !$C2['c2'])return;
	//---------
	
	$table = $uid? $this->member_table :$this->data_table;
	
	$sql = "DELETE FROM {$table} WHERE year='$year'";
	if($uid)
		$sql .= " AND uid='$uid'";
	if($month)
		$sql .= " AND month='$month'";
	if($cids)
		$sql .= " AND cid IN (".implode(',',$cids).")";

	$this->DB_slave->query($sql);	
	
	$uid && $r_g = $this->get_role_group($uid);
	
	for($day=$begin;$day<$end;$day+=86400){
		$where = $cids? " AND cid IN (".implode(',',$cids).")" : '';
		if($uid)$where .= " AND uid='$uid'";
		$sql = "SELECT cid, model,COUNT(id) AS post,FROM_UNIXTIME(timestamp,'%m') AS month,FROM_UNIXTIME(timestamp,'%d') AS day FROM {$this->system->TABLE_}item WHERE timestamp>='$day' AND timestamp<'".($day+86400)."' $where GROUP BY cid";
		
		$_pdata = $this->DB_slave->fetch_all($sql);
		$pdata = $pk = array();
		if($_pdata)foreach($_pdata as $key=>$row){
			$pdata[$row['cid']] = $row;
			$pk[] = $row['cid'];
		}
		
		$sql = "SELECT cid, model,COUNT(id) AS unverified,FROM_UNIXTIME(timestamp,'%m') AS month,FROM_UNIXTIME(timestamp,'%d') AS day FROM {$this->system->TABLE_}item_unverified WHERE timestamp>='$day' AND timestamp<'".($day+86400)."' $where GROUP BY cid";
		$_pdata = $this->DB_slave->fetch_all($sql);
		$udata = $uk = array();
		if($_pdata)foreach($_pdata as $key=>$row){
			$udata[$row['cid']] = $row;
			$uk[] = $row['cid'];
		}
		
		
		$where = $cids? " AND i.cid IN (".implode(',',$cids).")" : '';
		if($uid)$where .= " AND c.uid='$uid'";
		$sql = "SELECT i.cid, i.model, COUNT(c.id) AS comment,FROM_UNIXTIME(c.timestamp,'%m') AS month,FROM_UNIXTIME(c.timestamp,'%d') AS day FROM {$this->system->TABLE_}item_comment AS c
				LEFT JOIN {$this->system->TABLE_}item AS i ON i.id=c.iid
				WHERE c.timestamp>='$day' AND c.timestamp<'".($day+86400)."' $where GROUP BY i.cid";
		$_cdata = $this->DB_slave->fetch_all($sql);
		$cdata = $ck = array();
		if($_cdata)foreach($_cdata as $key=>$row){
			$cdata[$row['cid']] = $row;
			$ck[] = $row['cid'];
		}
		
		$ak = array_merge($pk,$ck,$uk);
		array_unique($ak);
		
		if($ak)foreach($ak as $k){
			$post = !empty($pdata[$k])? $pdata[$k]['post'] : 0;
			$unverified = !empty($udata[$k])? $udata[$k]['unverified'] : 0;
			$comment = !empty($cdata[$k])? $cdata[$k]['comment'] : 0;
			if($post  || $comment || $unverified){
				$model = !empty($pdata[$k])? $pdata[$k]['model'] : (!empty($udata[$k])? $udata[$k]['model']:$cdata[$k]['model']);
				$month = !empty($pdata[$k])? $pdata[$k]['month'] : (!empty($udata[$k])? $udata[$k]['month']:$cdata[$k]['month']);
				$date = !empty($pdata[$k])? $pdata[$k]['day'] : (!empty($udata[$k])? $udata[$k]['day']:$cdata[$k]['day']);
				$sql = "INSERT IGNORE {$table} (".($uid? "`uid`,`role_id`,`role_gid`,":"")."`cid`,`model`,`year`,`month`,`day`,`post`,`unverified`,`comment`,`visit`,`timestamp`) 
						VALUES(".($uid? "'$uid','$r_g[role_id]','$r_g[role_gid]',":"")."'$k','$model','$year','$month','$date','$post','$unverified','$comment','0','$time');";
				$this->DB_slave->query($sql);	
			}			
		}
	
	}
}

function get_role_group($uid){
	$sql = "SELECT id,role_id,role_gid FROM {$this->core->TABLE_}member WHERE id='$uid'";
	return $this->DB_slave->fetch_one($sql);
	 
}

/**
* 生成缓存
* @param string $model 指定模型,如果不指定则是生成所有模型的分类
* @param bool $cache_all 是否把每个分类都缓存成一个缓存文件
* @param bool $write_cache 是否写缓存,如果否,则不写缓存,保持树形结构,用于实时刷新
* @param array $id 只缓存的分类的ID哈希 array(id1 => 1, id2 => 1 ...)
**/
function cache($cache_all = true, $write_cache = true, $id = array()){
	parent::cache();
}
function get_self_client(){
	$cluster = $this->core->load_module('cluster');
	$selfclient = $this->core->url.'/index.php/core/cluster-client';
	$sql = "SELECT id FROM {$cluster->client_table} WHERE client_url='$selfclient'";
	$query = $this->DB_slave->fetch_one($sql);
	$client_id = $query['id'];
	return $client_id;
}
/**
* 标签调用的数据, 接口
* @param array $LABEL 标签模块
* @param array $label 标签数据
* @param array $var 变量
**/
function label(&$LABEL, &$label, &$var){
	
$option = &$label['option'];

$where = $where2 = '1=1';

switch($option['timelong']){
case 'all':
	
	break;
case '2year':
	$where .= " AND year='".(date('Y')-2)."'";
	$where2 = "timestamp >='".mktime(0,0,0,1,1,date('Y')-2)."'";
	break;
case '1year':
	$where .= " AND year='".(date('Y')-1)."'";
	$where2 = "timestamp >='".mktime(0,0,0,1,1,date('Y')-1)."'";
	break;	
case 'year':
	$where .= " AND year='".date('Y')."'";
	$where2 = "timestamp >='".mktime(0,0,0,1,1,date('Y'))."'";
	break;
case 'three':
	$m = date('m');
	if($m<=3)
		$mm=1;
	elseif($m<=6)
		$mm=4;
	elseif($m<=9)
		$mm=7;
	elseif($m<=12)
		$mm=10;		
		
	$where .= " AND year='".date('Y')."' AND month>='$mm'";
	$where2 = "timestamp >='".mktime(0,0,0,$mm,1,date('Y'))."'";
	break;
case 'month':
	$where .= " AND year='".date('Y')."' AND month='".date('m')."'";
	$where2 = "timestamp >='".strtotime(date('Y-m'))."'";
	break;
case 'week':
	$w = mktime(0, 0, 0, date('n',P8_TIME), ((date('j',P8_TIME)+1)-date('N',P8_TIME)), date('Y',P8_TIME));
	$wd = date('d',$w);
	$where .= " AND year='".date('Y')."' AND month='".date('m')."' AND day='$wd'";
	$where2 = "timestamp >='".$w."'";
	break;
case 'day':
	$where .= " AND year='".date('Y')."' AND month='".date('m')."' AND day='".date('d')."'";
	$where2 = "timestamp >='".strtotime(date('Y-m-d H:i:s'))."'";
	break;

}

if($option['model']!=''){
	$where .= " AND model='{$option['model']}'";
}


//排序
$order = $comma = '';
foreach($option['order_by'] as $field => $desc){
	$order .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}
if(!$order)
	$order = " post DESC";


$page_size = $option['limit'];

if($option['statistic_id']=='member'){
	$role_module = $this->core->load_module('role');
	$role_module->roles || $role_module->get_cache();
	
	$syg = array();
	foreach($role_module->roles as $ro){
		if($ro['type']=='system')$syg[] = $ro['id'];
	}
	$syg = implode(',',$syg);
	$sql = "SELECT role_id,SUM(post) as post, SUM(unverified) as unverified FROM {$this->member_table} WHERE $where AND role_id NOT IN($syg) GROUP BY role_id ORDER BY $order LIMIT $page_size";
}elseif($option['statistic_id']=='memberpost'){
	$role_module = $this->core->load_module('role');
	$role_module->roles || $role_module->get_cache();
	
	$syg = array();
	foreach($role_module->roles as $ro){
		if($ro['type']=='system')$syg[] = $ro['id'];
	}
	$syg = implode(',',$syg);
	$sql = "SELECT u.username,u.id,u.name,SUM(post) as post, SUM(unverified) as unverified 
			FROM {$this->member_table} AS s
			LEFT JOIN {$this->core->TABLE_}member AS u ON u.id=s.uid
			WHERE $where AND s.role_id NOT IN($syg)
			GROUP BY u.id 
			ORDER BY $order LIMIT $page_size";
}elseif($option['statistic_id']=='cluster'){
	$self_id = $this->get_self_client();
	$sql = "SELECT client_id,SUM(post) as post,SUM(verified) as verified,SUM(unverified) as unverified FROM {$this->cluster_table} WHERE $where AND client_id<>'$self_id' GROUP BY client_id ORDER BY $order LIMIT $page_size";
}elseif($option['statistic_id']=='govopen'){
	$sql = "SELECT jigou,COUNT(id) as post FROM {$this->system->TABLE_}item_govopen_ WHERE $where2 GROUP BY jigou ORDER BY $order LIMIT $page_size";
}

//echo $sql,'<br/>';//exit;

$query = $this->DB_slave->fetch_all($sql);

//print_r($query);

	$dot = empty($option['title_dot']) ? '' : '...';
	//幻灯片宽高
	$swidth = isset($option['width']) ? $option['width'] : 300;
	$sheight = isset($option['height']) ? $option['height'] : 300;
	
	//每行的宽度,用于多列
	$width = isset($option['rows']) && $option['rows'] > 1 ? (100/$option['rows']-1).'%' : '99%';
	$wf ='';
	if($width!='99%'){
		$wf = "width:$width;float:left;margin-right:1%";
	}
	$title_length = empty($option['title_length']) ? 0 : $option['title_length'];
	$summary_length = empty($option['summary_length']) ? 0 : $option['summary_length'];
//print_r($option);	
	$list = array();
	foreach($query as $k => $v){
		if($option['statistic_id']=='member'){
			$role_module->roles || $role_module->get_cache();
			$v['title'] =  $role_module->roles[$v['role_id']]['name'];
			$v['all'] = $v['post'] + $v['unverified'];
		}if($option['statistic_id']=='memberpost'){
			$v['title'] =  $v['username'];
			$v['all'] = $v['post'] + $v['unverified'];
		}elseif($option['statistic_id']=='cluster'){
			$cluster = $this->core->load_module('cluster');
			$clients = $cluster->clients;
			$v['title'] =  $clients[$v['client_id']]['name'];
			$v['all'] = $v['post'];
		}elseif($option['statistic_id']=='govopen'){
			$modelata = $this->core->CACHE->read($this->system->name .'/modules', 'model', 'govopen','serialize');
			$filedata = $modelata['fields']['jigou']['data'];
			$v['title'] =  $filedata[$v['jigou']];
			$v['all'] = $v['post'];
		}
		$list[$k+1] = $v;

	}
//print_r($list);exit;
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}

	return isset($pages) ? array($content, $pages) : array($content);
}	



/*************************************sites*******************************************/

function getStaticSitesPush($year,$month=0,$cid=0,$model='',$download=false){
	global $P8LANG;
	$cids = array();
	
	$where = "1=1";
	$orderby = '';
	if($year && $month){
        $group = " site";
		$where .= " AND year='$year' AND month='$month'";
		$orderby = " post DESC";
	}elseif($year){
		$group = " site";
		$where .= " AND year='$year'";
		$orderby = " post DESC";
	}else{
        $group = " site";
		$orderby = " post DESC";
    }

	$sql = "SELECT site,year,month,SUM(post) AS post,SUM(verified) AS verified,FROM_UNIXTIME(timestamp,'%Y-%m-%d %H:%i:%s') AS timestamp FROM {$this->sites_push_table} WHERE $where GROUP BY $group ORDER BY $orderby";
	//echo $sql;exit;
	$data = $this->DB_slave->fetch_all($sql);
	if($download){
		foreach($data as $key=>$row){
			$dodata[$key]['site'] = $row['site'];
			$dodata[$key]['post'] = $row['post'];
			$dodata[$key]['verified'] = $row['verified'];
		}
        //print_r($dodata);exit;
		$headertext=array($P8LANG['name'],$P8LANG['post'],$P8LANG['verify']);
		require PHP168_PATH.'/inc/excel.class.php';
		$export=new excel(1);
		$export->setFileName('site-statistic','download',date('Y-m-d-h-i-s', P8_TIME));
		$export->fileHeader($headertext);		
		$export->fileData($dodata);
		$export->fileFooter();
		$export->exportFile();
	}else{
		return $data;
	}

}

function statisticSitesPush($year,$month=0){
    $this->checkVefified($year,$month);
    $sites = $this->core->load_system('sites');
    $stop = $sites->load_module('stop');
    
	if($month){
		$begin = strtotime("$year-$month-01 00:00:00");
		$end = strtotime("+1 month",$begin);
	}else{
		$begin = strtotime("$year-01-01 00:00:00");
		$end = strtotime("+1 year",$begin);
	}
	$time = time();
	
    $sql = "DELETE FROM {$this->sites_push_table} WHERE year='$year'";
	if($month)
		$sql .= " AND month='$month'";

	$this->DB_slave->query($sql);

    $months = $month?array($month):range(1,12);
    foreach($months as $key=>$mon){
        
        $_begin = $month?$begin: strtotime("+$key month",$begin);
        $_end = $month?$end: strtotime("+1 month",$_begin);
        $sql = "SELECT site, COUNT(1) AS c,SUM(status) AS v  FROM {$stop->table} WHERE sc='c' and timestamp>='$_begin' AND timestamp<'$_end' group by site";

        $query = $this->DB_slave->fetch_all($sql);
        foreach($query as $row){
            $site = $row['site'];
            $post = $row['c'];
            $verified = $row['v'];

            $sql = "INSERT IGNORE {$this->sites_push_table} (`site`,`year`,`month`,`post`,`verified`,`timestamp`) 
						VALUES('$site','$year','$mon','$post','$verified','$time');";
			$this->DB_slave->query($sql);	
        }
    }
    return true;
}

function checkVefified($year,$month=0){
    if($month){
		$begin = strtotime("$year-$month-01 00:00:00");
		$end = strtotime("+1 month",$begin);
	}else{
		$begin = strtotime("$year-01-01 00:00:00");
		$end = strtotime("+1 year",$begin);
	}
    $sites = $this->core->load_system('sites');
    $stop = $sites->load_module('stop');
    
    $sql = "SELECT new_id FROM {$stop->table} WHERE sc='c' and status=0 and timestamp>='$begin' AND timestamp<'$end'";
    $query = $this->DB_slave->fetch_all($sql);
    $ids = array();
    
    foreach($query as $row){
        $ids[] = $row['new_id'];
    }
    $ids = array_filter($ids);
    if(empty($ids))return;
    
    $ids = implode(',',$ids);
    $sql = "SELECT id FROM {$this->system->TABLE_}item WHERE id IN ($ids)";
    
    $query = $this->DB_slave->fetch_all($sql);
    $ids = array();
    foreach($query as $row){
        $ids[] = $row['id'];
    }
    if(empty($ids))return;
    
    $ids = implode(',',$ids);
    $sql = "UPDATE {$stop->table} SET status=1 WHERE new_id IN ($ids)";
    $this->DB_slave->query($sql);
}




function getStaticSitesContent($year,$month=0,$cid=0,$model='',$download=false){
	global $P8LANG;
	$cids = array();
	
	$where = "1=1";
	$orderby = '';
	if($year && $month){
        $group = " site";
		$where .= " AND year='$year' AND month='$month'";
		$orderby = " post DESC";
	}elseif($year){
		$group = " site";
		$where .= " AND year='$year'";
		$orderby = " post DESC";
	}else{
        $group = " site";
		$orderby = " post DESC";
    }

	$sql = "SELECT site,year,month,SUM(post) AS post,SUM(verified) AS verified,FROM_UNIXTIME(timestamp,'%Y-%m-%d %H:%i:%s') AS timestamp FROM {$this->sites_content_table} WHERE $where GROUP BY $group ORDER BY $orderby";
	//echo $sql;exit;
	$data = $this->DB_slave->fetch_all($sql);
	if($download){
		foreach($data as $key=>$row){
			$dodata[$key]['site'] = $row['site'];
			$dodata[$key]['post'] = $row['post'];
			$dodata[$key]['verified'] = $row['verified'];
		}
        //print_r($dodata);exit;
		$headertext=array($P8LANG['name'],$P8LANG['post'],$P8LANG['verify']);
		require PHP168_PATH.'/inc/excel.class.php';
		$export=new excel(1);
		$export->setFileName('site-statistic','download',date('Y-m-d-h-i-s', P8_TIME));
		$export->fileHeader($headertext);		
		$export->fileData($dodata);
		$export->fileFooter();
		$export->exportFile();
	}else{
		return $data;
	}

}

function statisticSitesContent($year,$month=0){
    $this->checkVefified($year,$month);
    $sites = $this->core->load_system('sites');
    $item = $sites->load_module('item');
    
	if($month){
		$begin = strtotime("$year-$month-01 00:00:00");
		$end = strtotime("+1 month",$begin);
	}else{
		$begin = strtotime("$year-01-01 00:00:00");
		$end = strtotime("+1 year",$begin);
	}
	$time = time();
	
    $sql = "DELETE FROM {$this->sites_content_table} WHERE year='$year'";
	if($month)
		$sql .= " AND month='$month'";

	$this->DB_slave->query($sql);

    $months = $month?array($month):range(1,12);
    foreach($months as $key=>$mon){
        
        $_begin = $month?$begin: strtotime("+$key month",$begin);
        $_end = $month?$end: strtotime("+1 month",$_begin);
        
        $undata = array();
        $sql = "SELECT site, COUNT(1) AS c  FROM {$item->unverified_table} WHERE timestamp>='$_begin' AND timestamp<'$_end' group by site";
        $query = $this->DB_slave->fetch_all($sql);
        foreach($query as $row){
            $undata[$row['site']] = $row['c'];	
        }
        
        
        $sql = "SELECT site, COUNT(1) AS c  FROM {$item->main_table} WHERE timestamp>='$_begin' AND timestamp<'$_end' group by site";
//echo $sql,";\r\n";
        $query = $this->DB_slave->fetch_all($sql);
        foreach($query as $row){
            $site = $row['site'];
            $unverified = isset($undata[$row['site']])?$undata[$row['site']]:0;
            $verified = $row['c'];
            $post = $row['c']+$unverified;
            
            $sql = "INSERT IGNORE {$this->sites_content_table} (`site`,`year`,`month`,`post`,`verified`,`unverified`,`timestamp`) 
						VALUES('$site','$year','$mon','$post','$verified','$unverified','$time');";
			$this->DB_slave->query($sql);	
        }
        
        
    }
    return true;
}

}