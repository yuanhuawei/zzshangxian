<?php
defined('PHP168_PATH') or die();
class P8_Letter extends P8_Module{

var $table;
var $table_data;
var $table_cat;

function P8_Letter(&$system, $name){
	$this->system = &$system;

	parent::__construct($name);
	
	$this->table = $this->TABLE_.'item';
	$this->table_data = $this->TABLE_ . "data";
	$this->table_cat = $this->TABLE_ . "cat";
	$this->table_dep = $this->TABLE_ . "department";
	
	$this->hong = $this->CONFIG['hong'];
	$this->huan = $this->CONFIG['huan'];
	
}
function cache(){
	$this->cacheManager();
}
function get_category($reflash=false){
	global $SYSTEM ,$MODULE,$CACHE;
	if($reflash || !$return = $CACHE->read($SYSTEM .'/modules/', $MODULE, 'cate','serialize')){
		$query = $this->DB_master->fetch_all("SELECT * FROM $this->table_cat ORDER BY num ASC");
		
		foreach($query as $key => $rs){
			if($rs['type']==1){
				$department[$rs['id']] = $rs;
			}else{
				$type[$rs['id']] = $rs;
			}
		}
		$return = array('department'=>$department,'type'=>$type);
		$CACHE->write($SYSTEM .'/modules/'. $MODULE, 'cate', '', $return, 'serialize');
		
	}
	return $return;
}
function deleteCat($data){
	return $this->DB_master->delete($this->table_cat,"id IN(".implode(',',$data).")");
}

function updateCat($data,$type){
	if(!empty($data['new'])){
		foreach($data['new'] as $key=>$name){
			$num = $this->DB_master->fetch_one("SELECT num FROM {$this->table_cat} WHERE type='$type' ORDER BY num DESC LIMIT 1");
			$this->DB_master->insert($this->table_cat, array('type'=>$type,'name'=>$name,'num'=>$num['num']+1));
		}
	}
	if(!empty($data['old'])){
		$order = array_flip($data['order']);
		foreach($data['old'] as $id=>$name){
			$this->DB_master->update($this->table_cat, array('type'=>$type,'name'=>$name,'num'=>$order[$id]),"id='$id'");
		}
	}
}
function createNumber(){
	return date('YmdHis').rand(1000,9999);
}
function add(&$data){
	//插入主表取得ID
	$id = $this->DB_master->insert(
		$this->table,
		$this->DB_master->escape_string($data['main']),
		array('return_id' => true)
	);
	
	if(empty($id)) return false;
	
	//收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	
	$data['data']['item_id'] = $id;
	$st = $this->DB_master->insert(
		$this->table_data,
		$this->DB_master->escape_string($data['data'])
	);
	if(!$st){
		$this->delete(array('ids'=>array($id)));
		return false;
	}
	return $id;
}

function update($id,&$data){
	$status = true;
	//收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	$status |= $this->DB_master->update(
		$this->table,
		$this->DB_master->escape_string($data['main']),
		"id = '$id'"
	);
	$status |=	$this->DB_master->update(
		$this->table_data,
		$this->DB_master->escape_string($data['data']),
		"item_id = '$id' AND level='0'"
	);
	
	return $status;
}
function getData($id,$type='simple'){
	
	$data = $this->DB_master->fetch_one("SELECT i.* FROM {$this->table} as i WHERE i.id='$id'");
	
	if($type=='all' && $data){
		$data['data'] = $this->DB_master->fetch_all("SELECT d.* FROM {$this->table_data} as d WHERE d.item_id='$id'"); 
	
	}
	
	return $data;
}

function getList($param,$limit=10){
	
	$where = ' visual=1';
	//if(!empty($this->CONFIG['redepartment'])){
	//	$department = intval($this->CONFIG['redepartment']);	
	//	$where .= " AND department!='{$department}'";
	//}
	if($param['uid'])
		$where .= " AND uid='{$param['uid']}'";
	if($param['department'])
		$where .= " AND department='{$param['department']}'";
	if($param['type'])
		$where .= " AND type='{$param['type']}'";
	if($param['username'])
		$where .= " AND username='".p8_html_filter($param['username'])."'";
	$sql ="SELECT * FROM {$this->table} WHERE $where LIMIT $limit";
	return $this->DB_master->fetch_all($sql);
}

function searchData($number,$username){
	
	$data = $this->DB_master->fetch_one("SELECT i.* FROM {$this->table} as i WHERE i.number='$number' AND username='$username'");

	return $data;
}


function reply($id,$main,$data=array()){
	$this->DB_master->update(
			$this->table,
			$this->DB_master->escape_string($main),
			"id = '$id'"
	);
	
	if($data){
		foreach($data as $rid=>$rep){
			$this->DB_master->update(
			$this->table_data,
			$this->DB_master->escape_string($rep),
			"id = '$rid'"
			);
		}
	}
	
}


function delete($data){
//print_r($data);exit;
	$this->DB_master->delete(
			$this->table,
			"id in(".implode(",",$data['ids']).")"
	);
	$this->DB_master->delete(
			$this->table_data,
			"item_id in(".implode(",",$data['ids']).")"
	);
	return $data['ids'];
}
function verify($data){

	$this->DB_master->update(
			$this->table,
			array('status'=>1),
			"id in(".implode(",",$data['ids']).")"
	);

	return $data['ids'];
}

function comment($id,$common){
	return $this->DB_master->update(
		$this->table,
		array('comment'=>$common,'comment_time'=>time()),
		"id = '$id'"
	);
}

function getstatistics($begintime,$endtime){
	$cates = $this->get_category();
	$return = array();
	$where = '';
	if($begintime){
		$where .= "AND create_time > '$begintime'";
	}
	if($endtime){
		$where .= "AND create_time < '$endtime'";
	}
	$total = array();
	foreach($cates['department'] as $row){
		$sql = "SELECT type,COUNT(id) AS total,COUNT(DISTINCT solve_time) AS solve FROM {$this->table} WHERE department={$row['id']} $where GROUP BY type";
		$query = $this->DB_master->fetch_all($sql);
		$data = array();
		foreach($query as $item){
			$data[$item['type']]=$item;
			$total[$item['type']]['total'] +=$item['total'];
			$total[$item['type']]['solve'] +=$item['solve'];
			$total[$row['id']]['total'] +=$item['total'];
			$total[$row['id']]['solve'] +=$item['solve'];
		}
		$return[$row['id']] = $data;
		
	}
	$return['total']=$total;
	return $return;
}

function getstatistics2(){

	$sql = "SELECT type,COUNT(id) AS total,COUNT(DISTINCT solve_time) AS solve FROM {$this->table} GROUP BY type";
	$query = $this->DB_master->fetch_all($sql);
	foreach($query as $item){
		$data[$item['type']]=$item;
	}
	return $data;
}

function getProgress($username,$number){
    $username = $this->DB_master->escape_string($username);
    $number = $this->DB_master->escape_string($number);
	$sql = "SELECT id,log FROM {$this->table} WHERE code='".$number."'";
	return $this->DB_master->fetch_one($sql);

}

function getdp($row){
	$dp = 1;
	
	if($row['finish_time'])$row['create_time']=$row['finish_time'];
	if(!$row['solve_time'] && P8_TIME-$row['create_time']>86400*$this->hong)
		$dp = 3;
	elseif(!$row['solve_time'] && P8_TIME-$row['create_time']>86400*$this->huan)
		$dp = 2;
	return $dp;	
}


function id_type(){
	global $P8LANG;
	return array(
		1=>$P8LANG['id_type_1'],
		2=>$P8LANG['id_type_2'],
		3=>$P8LANG['id_type_3'],
		4=>$P8LANG['id_type_4'],
		5=>$P8LANG['id_type_5'],
	);
}

function get_comments(){
	global $P8LANG;
	return array(
		1=>$P8LANG['comments_1'],
		2=>$P8LANG['comments_2'],
		3=>$P8LANG['comments_3'],
	);
}


/**
*标签 接口
**/
function label(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	//print_r($option);
	global $SKIN, $TEMPLATE, $RESOURCE,$P8LANG;
	load_language($this, 'global');
	if(empty($option['statistic_id'])){
		$select = select();
		$select->from($this->table .' AS i', 'i.*');
		$lenght = intval($option['summary_length']);
		$select->left_join($this->table_data .' AS d', 'd.reply_time,substring(d.content,1,'.$lenght.') as summary,substring(d.reply,1,'.$lenght.') as reply', 'd.item_id=i.id');
		
		
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('i.id DESC');
		}
		
		if(empty($option['ids'])){
			
			if($option['department']){
					$select->in('i.department',$option['department']);
			}
			if($option['type']){
				$select->in('i.type',$option['type']);
			}
			$select -> in('undisplay',0);
			$select -> in('visual',1);
			if(!empty($option['status']))
				$select->in('i.status', $option['status']-1);
				
			if(!empty($this->CONFIG['redepartment'])){
				$redepartment = intval($this->CONFIG['redepartment']);	
				$select->in("i.department",$redepartment,true);
			}	
				
			//当前页码
			$page = 0;
			//总记录数
			$count = 0;
			$page_size = $option['limit'];
			
			//echo $select->build_sql();
			//取出数据
			$list = $this->core->list_item(
				$select,
				array(
					'page' => &$page,
					'page_size' => $page_size,
					'count' => &$count,
					'sphinx' => $option['sphinx']
				)
			);
			
		}else{
			//指定ID,不需分页,不使用sphinx
			$select->in('i.id', $option['ids']);
			$c = range(0, count($option['ids']) -1);
			
			$list = $this->core->list_item(
				$select,
				array(
					'page_size' => 0
				)
			);
			
			$tmp = array_combine($option['ids'], $c);
			foreach($list as $v){
				$tmp[$v['id']] = $v;
			}
			
			$list = array_values($tmp);
		}
	
		
		$cates = $this->get_category();
		//处理URL
		foreach($list as $k => $v){
			$list[$k]['url'] = $this->controller.'-view-id-'.$v['id'];
			$list[$k]['full_title'] = $v['title'];
			$dot=!empty($option['title_dot'])?'...' : '';
			$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
			//分类名称
			$list[$k]['department_name'] = $cates['department'][$v['department']]['name'];
			$list[$k]['type_name'] = $cates['type'][$v['type']]['name'];
			$list[$k]['status_name'] = $P8LANG['status_'.$v['status']];
			$list[$k]['dp'] = $this->getdp($v);
		}
	}else{
		$func = 'tonji_0'.$option['statistic_id'];
		$_list = $this->$func(array('pagesize'=>$option['limit']));
		$list = $_list['list'];
		$page = $_list['page'];
	}
	//随机数
	$rand = rand_str(4);
	//每行的宽度,用于多列
	$width = (isset($option['rows']) && $option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	
	
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

function get_total($filter=array()){
	
	$where = "1=1";
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$where .= " AND department!='{$redepartment}'";
	}
	if(!empty($filter['department']))
		$where .= " AND department='{$filter['department']}'";
	
	if(!empty($filter['begin_time']))
		$where .= " AND create_time>='".strtotime($filter['begin_time'])."'";
		
	if(!empty($filter['end_time']))
		$where .= " AND create_time<='".strtotime($filter['end_time'])."'";	
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE $where";
	$c1 = $this->DB_master->fetch_one($sql);
	$c1= intval($c1['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE $where AND status>0";
	$c2 = $this->DB_master->fetch_one($sql);
	$c2= intval($c2['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE $where AND status=3";
	$c3 = $this->DB_master->fetch_one($sql);
	$c3= intval($c3['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE $where AND status=0";
	$c4 = $this->DB_master->fetch_one($sql);
	$c4= intval($c3['count']);
	
	$sql = "SELECT type,COUNT(1) as count FROM $this->table WHERE $where GROUP BY type";
	$c5 = $this->DB_master->fetch_all($sql);
	
	return array('0'=>$c1,'1'=>$c2, '2'=>$c3,'3'=>$c4,'4'=>$c5);
}

function get_date_total(){
	$today = strtotime('today');
	$yesterday = strtotime('yesterday');
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE create_time>=$today";
	$a1 = $this->DB_master->fetch_one($sql);
	$a1= intval($c1['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE status>0 AND create_time>=$today";
	$a2 = $this->DB_master->fetch_one($sql);
	$a2= intval($c2['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE status=3  AND create_time>=$today";
	$a3 = $this->DB_master->fetch_one($sql);
	$a3= intval($c3['count']);
	
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE create_time>=$yesterday";
	$b1 = $this->DB_master->fetch_one($sql);
	$b1= intval($c1['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE status>0 AND create_time>=$yesterday";
	$b2 = $this->DB_master->fetch_one($sql);
	$b2= intval($c2['count']);
	
	$sql = "SELECT COUNT(1) as count FROM $this->table WHERE status=3  AND create_time>=$yesterday";
	$b3 = $this->DB_master->fetch_one($sql);
	$b3= intval($c3['count']);
	return array(array($a1,$a2,$a3),array($b1,$b2,$b3));
}


//来信总数abs
function tonji_01($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'department, COUNT(1) as count');
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	$select->group('i.department');
	$select->order('count DESC');
	
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	$temp = array();
	foreach($list as $key=>$row){
		$row['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
		$row['count'] = intval($row['count']);
		$temp[$row['department']] = $row;
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$temp,'pages'=>$pages);
}
//受理总数abs
function tonji_02($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'i.department, COUNT(1) as count');
	$select->group('i.department');
	$select->order('count DESC');
	$select->in('status','0',true);
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	//当前页码
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	$page = !empty($filter['page'])?$filter['page']:0;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	$temp = array();
	foreach($list as $key=>$row){
		$row['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
		$row['count'] = intval($row['count']);
		$temp[$row['department']] = $row;
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));		
	return array('list'=>$temp,'pages'=>$pages);

}
//办理总数abs
function tonji_03($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'department, COUNT(1) as count');
	$select->group('i.department');
	$select->order('count DESC');
	$select->in('status',3);
	//$select->in('solve_time','',true);
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	$temp = array();
	foreach($list as $key=>$row){
		$row['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
		$row['count'] = intval($row['count']);
		$temp[$row['department']] = $row;
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$temp,'pages'=>$pages);

}
//办结率
function tonji_04($filter=array()){
	$select = select();
	$select->from("{$this->table} AS i", "i.department, ((SELECT COUNT(1) FROM {$this->table} a WHERE a.department = i.department AND a.status=3)/(SELECT COUNT(1) FROM {$this->table} b WHERE b.department = i.department)) as count");
	$select->group('i.department');
	$select->order('count DESC');
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	$temp = array();
	foreach($list as $key=>$row){
		$row['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
		$row['count'] = intval($row['count']*100);
		$temp[$row['department']] = $row;
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$temp,'pages'=>$pages);

}

//全部红灯
function tonji_05($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'department, COUNT(1) as count');
	$select->group('i.department');
	$select->order('count DESC');
	$select->in('solve_time','0');
	$select->where_and();
	$hd = P8_TIME-86400*$this->hong;
	$select->where(" IF(finish_time,finish_time< $hd,create_time<$hd)");
	//$select->range('create_time',null,P8_TIME-86400*$this->hong);
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	foreach($list as $key=>$row){
		$list[$key]['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$list,'pages'=>$pages);

}
//全部黄灯
function tonji_06($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'department, COUNT(1) as count');
	$select->group('i.department');
	$select->order('count DESC');
	$hod = P8_TIME-86400*$this->hong;
	$hud = P8_TIME-86400*$this->huan;
	$select->where("(i.solve_time ='0' AND  IF(finish_time,finish_time< $hud,create_time<$hud) AND IF(finish_time,finish_time> $hod,create_time>$hod))");
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	foreach($list as $key=>$row){
		$list[$key]['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$list,'pages'=>$pages);

}
//本周红灯
function tonji_07($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'department, COUNT(1) as count');
	$select->group('i.department');
	$select->order('count DESC');
	$select->in('solve_time','0');
	$select->where_and();
	$min = P8_TIME-86400*14;
	$max = P8_TIME-86400*7;
	$select->where(" IF(finish_time,finish_time<$max and finish_time>$min,create_time<$max and create_time>$min)");
	//$select->range('create_time',P8_TIME-86400*14,P8_TIME-86400*7);
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	foreach($list as $key=>$row){
		$list[$key]['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
	}
		
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$list,'pages'=>$pages);

}
//本周黄灯
function tonji_08($filter=array()){
	$select = select();
	$select->from($this->table .' AS i', 'department, COUNT(1) as count');
	$select->group('i.department');
	$select->order('count DESC');				
	$select->range('create_time',P8_TIME-86400*14);	
	$select->where_and();
	
	$hod = P8_TIME-86400*$this->hong;
	$hud = P8_TIME-86400*$this->huan;
	
	$select->where("(i.solve_time ='0' AND  IF(finish_time,finish_time< $hud,create_time<$hud) AND IF(finish_time,finish_time> $hod,create_time>$hod)))");
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}			
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	foreach($list as $key=>$row){
		$list[$key]['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
	}
	$page_url = !empty($filter['page_url'])?$filter['page_url']:$this_url;
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';	
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => $page_url
	));	
	return array('list'=>$list,'pages'=>$pages);

}

function tonji_09(){
	$select = select();
	
	$hod = P8_TIME-86400*$this->hong;
	$hud = P8_TIME-86400*$this->huan;
	$select->from($this->table .' AS i', "department, 
	SUM(IF((i.solve_time ='0' AND  IF(finish_time,finish_time< $hud,create_time<$hud) AND IF(finish_time,finish_time> $hod,create_time>$hod)),1,0)) as huan,
	SUM(IF((i.solve_time ='0' AND  IF(finish_time,finish_time< $hod,create_time<$hod)),1,0)) as hong
	");
	$select->group('i.department');
	$select->order('hong DESC,huan DESC');
	if(!empty($this->CONFIG['redepartment'])){
		$redepartment = intval($this->CONFIG['redepartment']);	
		$select->in("i.department",$redepartment,true);
	}
	
	//当前页码
	$page = !empty($filter['page'])?$filter['page']:0;
	//总记录数
	$count = 0;
	$page_size = !empty($filter['pagesize'])?$filter['pagesize']:10;
	
	//echo $select->build_sql();
	//取出数据
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	$cate = $this->get_category();
	foreach($list as $key=>$row){
		$list[$key]['department_name'] = !empty($cate['department'][$row['department']])? $cate['department'][$row['department']]['name'] : '';
	}
		
	//当前分类的分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $page_size,
		'url' => ''
	));	
	return array('list'=>$list,'pages'=>$pages);

}

function cacheManager(){
	
	$data=array();
	$query=$this->DB_master->query("SELECT * FROM {$this->core->TABLE_}member_acl WHERE system='core' AND module='letter'");
	while($row = $this->DB_master->fetch_array($query)){
		$uid=$row['user_id'];
		$vd = mb_unserialize($row['v']);
		$manager = $vd['my_letter_manage']['manager'];
		foreach($manager as $k=>$v){
			if(!isset($data[$v]))$data[$v]=array();
			$data[$v][$uid] = $uid;	
		}
	}
	global $CACHE,$SYSTEM,$MODULE;
	$CACHE->write($SYSTEM .'/modules/', $MODULE, 'dep2uid',$data, 'serialize');
	
}

function sendMsg($id){
	global $UID,$USERNAME,$P8LANG,$core,$CACHE,$SYSTEM,$MODULE;
	
	$ldata = $this->getData($id);
	
	$dep = $ldata['department'];
	$type = array('msg','sms','email');
	$title = $P8LANG['msg_1'];
	$cates = $this->get_category();
		
	$content = p8lang($P8LANG['msg_2'], 
	$ldata['number'],
	$cates['type'][$ldata['type']]['name'],
	date('Y-m-d H:i:s',$ldata['finish_time']));
	//$content = from_utf8($content);
	
	$dep2uid = $CACHE->read($SYSTEM .'/modules/', $MODULE, 'dep2uid', 'serialize');
	
	$uid0 = !empty($dep2uid[0])? $dep2uid[0]: array();
	$uid1 = !empty($dep2uid[$dep])? $dep2uid[$dep]: array();
	$uids = array_merge($uid0, $uid1);
	if(!$uids)return;
	$_uids = implode(',',$uids);
	
	$query = $core->DB_master->query("SELECT id, cell_phone,email FROM {$core->TABLE_}member WHERE id in ($_uids)");
	
	while($user_data = $this->DB_master->fetch_array($query)){

		if(!$user_data)continue;
		$uid = $user_data['id'];
		$mobile = isset($user_data['cell_phone'])? filter_word($user_data['cell_phone']) : '';
		$semail = isset($user_data['email'])? filter_word($user_data['email']) : '';
		
		$mobile = str_replace(array(',','|','，'),',',$mobile);
		$semail = str_replace(array(',','|','，'),',',$semail);

		

		$status1 = $status3 = $status2 = false;
		if(in_array('msg',$type)){
			$message = &$core->load_module('message');
			$data = array(
				'uid' => $uid,
				'title' => $title,
				'content' => $content
			);
			$status1 = $message->send($data);
		}
		if(in_array('sms',$type) && $mobile){
			$sendto = $mobile;			
			$sms = &$core->load_module('sms');
			$sms_content = str_replace(array("\t"), '', strip_tags($content));
			if($sendto){
				$status2 = $sms->send(
					$sendto,
					$sms_content
				);
			}
		} 
		if(in_array('email',$type) && $semail){
			
			$sendto = $semail;
			
			$email = &$core->load_module('mail');
			$sendto = explode(',', $sendto);
			foreach($sendto as $send){
					$email->set(array(
						'subject' => $title,
						'message' => $content,
						'send_to' => $send
					));
				$status3 = $email->send();
			}
		}
	}	
}
}