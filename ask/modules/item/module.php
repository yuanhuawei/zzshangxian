<?php
class P8_Ask_item extends P8_module{

var $table;
var $table_member;
var $table_data;
var $table_addition;
var $table_favorites;
var $table_push;
var $table_poller;
var $table_tags;
var $table_itemtags;
var $table_unverified;

function P8_Ask_item(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->table_member = $this->core->TABLE_ . 'member';
	$this->table_data = $this->TABLE_ . 'data';
	$this->table_addition = $this->TABLE_ . 'addition';
	$this->table_favorites = $this->TABLE_ . 'favorites';
	$this->table_push = $this->TABLE_ . 'push';
	$this->table_poller = $this->TABLE_ . 'poller';
	$this->table_tags = $this->table . 'tags';
	$this->table_itemtags = $this->table. 'itemtags';
	$this->table_unverified = $this->table.'unverified';
	if(!$this->system->item_count)$this->cache_statistics();
}

function data($id){
	$sql = 'SELECT id, uid, cid, to_uid, credits, status, verify, closed, endtime FROM '. $this->table .' WHERE id = \''. $id .'\'';
		$ret = $this->DB_slave->fetch_one($sql);
		return $ret;

}

/**
 * 检查问题是否存在
 * param string $condition 条件
 * return bool true||false 存在:true,不存在:false
 */
function check_exists($condition){
	
	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
		return true;
	}else{
		return false;
	}

}

/**
 * 检查收藏是否存在
 * param string $condition 条件
 * return bool true || false 返回逻辑型
 */
function check_exists_favorites($condition){
			
	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_favorites . " WHERE $condition")){
		return true;
	}else{
		return false;
	}
	
}

/**
 * 问题投诉是否存在
 * param string $condition 条件
 * return bool true||false 返回逻辑型,存在:true,不存在:false
 */
function check_exists_poller($condition){
	
	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_poller . " WHERE $condition")){
		return true;
	}else{
		return false;
	}

}

/**
 * 问题是否充许回答
 * param int $id 问题ID
 * return bool 返回逻辑型,true或false
 */
function allow_post_answer($id){
	
	$row = $this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE id='$id' AND verify=1 AND closed=0 AND status!=3 and endtime>" . P8_TIME);
	if($row){
		return true;
	}else{
		return false;
	}
	
}

/**
 * 问题到期时间
 * param int $endtime 问题到期时间
 * return array $data 返回时间数组 天,小时,分,秒
 */
function endtime($endtime){
	
	$data = array();
	$data['days']    = 0;
	$data['hours']   = 0;
	$data['minutes'] = 0;
	$data['seconds'] = 0;

	if(empty($endtime) || !is_numeric($endtime) || $endtime<1 || $endtime<P8_TIME){
		return $data;
	}

	$difftime = $endtime - P8_TIME;
	$data['days'] = floor($difftime/86400);
	$data['hours'] = floor(($difftime-$data['days']*86400)/3600);
	$data['minutes'] = floor(($difftime-$data['days']*86400-$data['hours']*3600)/60);
	$data['seconds'] = $difftime-$data['days']*86400-$data['hours']*3600-$data['minutes']*60;

	return $data;

}

/**
 * 审核问题
 * param string $condition 条件
 * param int $verify 1:通过审核,0:锁定
 * return int 返回影响数目
 */ 
function verify($condition, $verify){

	return $this->DB_master->update(
		$this->table,
		array('verify'=>$verify),
		$condition
	);

}

/**
 * 推荐问题
 * param string $condition 条件
 * param int $recommend 1:推荐,0取消推荐
 * return int 返回影响数目
 */
function recommend($condition, $recommend){

	 return $this->DB_master->update(
		 $this->table,
		 array('recommend'=>$recommend),
		 $condition
	 );

}

/**
 * 关闭问题
 * 问题被关闭后不可再回答和投票等
 * param string $condition 条件
 * param int $closed 1:关闭,0:打开
 * return int 返回更新成功的数目
 */
function closed($condition, $closed){

	return $this->DB_master->update(
		 $this->table,
		 array('closed'=>$closed),
		 $condition
	 );

}

	/**
 * 己解决问题
 *  己解决问题不可再回答
 * param string $condition 条件
 * param string $solve 条件 1:未解决,2:续问,3:已解决
 * return int 返回更新成功的数目
 */
function solved($condition, $status=3){

	$statu =  $this->DB_master->update(
		 $this->table,
		 array('status'=>$status),
		 $condition
	 );
	 //更新统计数据	
	 $mark = $status==3? '+' : '-';
	$this->set_statistics(
	array(
		'field'=>'solve_item_count',
		'mark' => $mark,
		'number' =>1
		)
	);
	return $statu;
}

/**
 * 更新问题
 * param array &$data 数据
 * param int $data['id'] 问题ID
 * param string $data['title'] 标题
 * param string $data['content'] 内容
 * param string $data['info'] 邮箱/QQ/MSN
 * param string $data['tel'] 电话
 * param int $data['cid'] 分类ID，不为空则更新分类
 * param bool $data['update_time'] 更新时间，true:更新，false:不更新
 * param array $data['tags'] 标签数组
 * return int $data['id'] 返回问题ID
 */
function update(&$data){

	$tags_arr = $tagsnew = array();

	$_data = array(
		'title' => $data['title'],
		'sub_title' => $data['sub_title']
		);
	//更新时间
	if($data['update_time']){
		$_data = array_merge(
				$_data, 
				array(
					'addtime' => $data['addtime'],
					'endtime' => $data['endtime']
				)
			);
	}
	//更新分类ID
	if(!empty($data['cid'])){
		$_data = array_merge($_data, array('cid'=>$data['cid']));
	}
	
	$update_rows = $this->DB_master->update($this->table, $_data, "id='$data[id]'");

	//更新数据
	$this->DB_master->update(
		$this->table_data,
		array(
			'tel' => $data['tel'],
			'info' => $data['info'],
			'content' => $data['content']
		),
		"id='$data[id]'"
	);			

	if(!empty($data['tags'])){
		$query = $this->DB_master->query("SELECT tagname FROM " . $this->table_itemtags . " WHERE id='$data[id]'");
		while($row = $this->DB_master->fetch_array($query)){
			$tags_arr[] = $row['tagname']; 
		}

		foreach($data['tags'] as $tagname){
			$tagname = trim($tagname);
			if(preg_match('/^([\x7f-\xff_-]|\w|\s){2,30}$/', $tagname)) {
				$tagsnew[] = $tagname;
				if(!in_array($tagname,$tags_arr)){
					if($row = $this->DB_master->fetch_one("SELECT total FROM " . $this->table_tags . " WHERE tagname='$tagname'")){
						$this->DB_master->update($this->table_tags, array('total'=>$row['total']+1), " tagname='$tagname'");
					}else{ 
						$this->DB_master->insert($this->table_tags, array('tagname'=>$tagname, 'total'=>1));							
					}
					$this->DB_master->insert($this->table_itemtags, array('id'=>$data['id'], 'tagname'=>$tagname));
				}
			}
		}

		foreach($tags_arr as $tagname){
			if(!in_array($tagname, $tagsnew)) {
				$row = $this->DB_master->fetch_one("SELECT count(*) AS total FROM " . $this->table_itemtags . " WHERE tagname='$tagname' AND id!='$data[id]'");
				if($row['total']) {
					$this->DB_master->update($this->table_tags, array('total'=> "total-1"), " tagname='$tagname'", false);
				} else {
					$this->DB_master->delete($this->table_tags, " tagname='$tagname'");
				}
				$this->DB_master->delete($this->table_itemtags, " tagname='$tagname' AND id='$data[id]'");
			}
		}
	}

	return $data['id'];
	
}

/**
 * 设置置顶问题
 * param string $condition 条件
 * param int display_order 置顶位置,0:取消,1:当前栏目置顶,2:栏目置顶,3:总置顶
 * return int 返回更新数目
 */
function set_display_order($condition, $display_order){

	return $this->DB_master->update(
		$this->table,
		array('display_order'=>$display_order),
		$condition
	);
	
}

/**
 * 标记投诉内容已处理
 * @param string $condition 条件
 * @return int 返回更新成功的数目
 */
function set_poller_handler($condition){

	return $this->DB_master->update(
		$this->table_poller, 
		array('handler'=>1),
		$condition
	);

}

/**
 * 删除问题
 * param string $condition 条件
 * return int 返回删除影响数目
 */
function delete($data){
		$T=$this->table;
		$ids = $comma =$id ='';
		$query=$this->DB_master->query("SELECT $T.id FROM $T WHERE $data[where]");
		while($rs = $this->DB_master->fetch_array($query)){
			$ids .= $comma . $rs['id'];
			$id[] = $rs['id'];
			$comma = ',';
		
		}
	if(!$id)return;
	//删除主表
	if($this->DB_master->delete($this->table," id IN ($ids) ")){
		//删除问题数据表
		$this->delete_data(" id IN ($ids) ");
		//删除问题标签
		$this->delete_tags(" id IN ($ids) ");
		//删除补充问题数据
		$this->delete_addition("tid IN($ids)");
		//删除问题收藏夹
		$this->delete_favorites("tid IN($ids)");
		//删除推荐问题表
		$this->delete_push("tid IN($ids)");
		//删除投诉
		$this->delete_poller("tid IN($ids)");
		
		
		$this->set_statistics(
			array(
				'field'=>'item_count',
				'mark' => '-',
				'number' =>count($id)
				)
			);
		return $id;	
	}

}
/**清空所有问题**/
function clean(){
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_data");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_tags");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_addition");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_favorites");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_push");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_poller");
	
	$answer = $this->system->load_module('answer');
	return $answer->clean();

}

/**
 * 删除问题数据表
 * param string $condition 条件
 * return array 返回删除成功后的问题ID数组
 */
function delete_data($condition){

	return $this->DB_master->delete(
		$this->table_data, 
		$condition
	);

}

/**
 * 删除问题投诉
 * param string $condition 条件
 * return array 返回删除成功后的投诉ID数组
 */
function delete_poller($condition){

	return $this->DB_master->delete(
		$this->table_poller,
		$condition
	);

}


/**
 * 删除补充问题
 * param string $condition 条件
 * return array 返回删除成功后的补充问题ID数组
 */
function delete_addition($condition){

	return $this->DB_master->delete(
		$this->table_addition,
		$condition
	);

}

/**
 * 删除问题收藏夹
 * param string $condition 条件
 * return array 返回删除成功后的收藏ID数组
 */
function delete_favorites($condition){

	return $this->DB_master->delete(
		$this->table_favorites,
		$condition
	);

}

/**
 * 删除推荐问题
 * param string $condition 条件
 * return array 返回删除推荐问题ID数组
 */
function delete_push($condition){

	return $this->DB_master->delete(
		$this->table_push,
		$condition
	);

}

/**
 * 删除问题标签
 * param string $condition 条件
 * return int $delrows 返回删除成功后的数目
 */
function delete_tags($condition){
	
	$ids_arr = array();
	$allids = $comma = '';
	
	$query = $this->DB_master->query("SELECT * FROM " . $this->table_itemtags . " WHERE $condition");
	while($row = $this->DB_master->fetch_array($query)){
		if($this->DB_master->fetch_one("SELECT * FROM " . $this->table_tags . " WHERE tagname='" . $row['tagname'] . "'")){
			$this->DB_master->update(
				$this->table_tags,
				array('total'=>'total-1'),
				" tagname='".$row['tagname']."'",
				false
			);
		}

		$ids_arr[] = $row['id'];			
		$allids .= $comma . $row['id'];
		$comma = ',';
		
	}
	if(!empty($allids)){
		$this->DB_master->delete(
			$this->table_itemtags,
			" id IN($allids)"
		);
	}
	return $ids_arr;

}

/**
 * 会员删除提问
 * param array $ids 问题ID数组
 * param string $condition 执行条件
 * return array $delids 返回删除问题ID数组
 */
function delete_myask($ids, $condition = ''){

	$allids = $comma = '';
	$delids = array();

	foreach($ids as $id){
		$allids .= $comma . $id;
		$comma = ',';
	}

	$query = $this->DB_master->query("SELECT id FROM " . $this->table . " WHERE id IN($allids) $condition");
	while($row = $this->DB_master->fetch_array($query)){
		$delids[] = $row['id'];
	}

	if(empty($delids)) return array();

	$allids = $comma = '';
	foreach($delids as $id){
		$allids .= $comma . $id;
		$comma = ',';
	}

	//删除问题
	$rows = $this->DB_master->delete($this->table, " id IN($allids) $condition");
	if($rows){
	$allids= "id IN ($allids)";
		//删除问题数据表
		$this->delete_data($allids);
		//删除补充问题数据
		$this->delete_addition($allids);
		//删除问题收藏夹
		$this->delete_favorites($allids);
		//删除推荐问题表
		$this->delete_push($allids);
		//删除问题标签
		$this->delete_tags($allids);
		//更新会员统计信息

	}

	return $delids;

}

/**
 * 会员删除收藏夹
 * param array $ids 收藏ID数组
 * param string $condition 条件
 * return array $delids 返回删除收藏ID数组
*/
function delete_myfavorite($ids, $condition = ''){

	$allids = $comma = '';
	$delids = array();

	foreach($ids as $id){
		$allids .= $comma . $id;
		$comma = ',';
	}

	$query = $this->DB_master->query("SELECT id FROM " . $this->table_favorites . " WHERE id IN($allids) $condition");
	while($row = $this->DB_master->fetch_array($query)){
		$delids[]  = $row['id'];
	}

	if(empty($delids)) return array();
	$allids = $comma = '';
	foreach($delids as $id){
		$allids .= $comma . $id;
		$comma = ',';
	}

	$rows = $this->DB_master->delete($this->table_favorites, " id IN($allids) $condition");
	
	return $delids;

}

/**
 * 会员提交问题
 * param array &$data 数据
 * return int $insert_id 返回提交成功后的ID
 */
function post(&$data){
	
	$insert_id = $this->DB_master->insert(
		$this->table, 
		array(
			'cid' => $data['cid'],
			'title' => $data['title'],
			'uid' => $data['uid'],
			'username' => $data['username'],
			'to_uid' => $data['to_uid'],
			'anonymous' => $data['anonymous'],
			'addtime' => $data['addtime'],
			'ip' => $data['ip'],
			'keywords' => $data['keywords'],
			'offercredit' => $data['offercredit'],
			'credits' => $data['credits'],
			'urgent' => $data['urgent'],
			'lastpost' => $data['lastpost'],
			'endtime' => $data['endtime'],
			'status' => 1,
			'verify' => $data['verify']
		),
		array('return_id' => true)
	);
		//未审核
	/* if(!$data['verify']){
		$data['data'] = serialize($data);
		$this->DB_master->insert(
			$this->table_unverified, 
			array(
				'id' => $insert_id,
				'cid' => $data['cid'],
				'title' => $data['title'],
				'uid' => $data['uid'],
				'username' => $data['username'],
				'addtime' => $data['addtime'],
				'verify' => 0,
				'data' => $this->DB_master->escape_string($data['data'])
			)
		);
		//删除
		$this->DB_master->delete(
			$this->table,
			"id = '$insert_id'"
		);
		
		//返回,审核通过的时候再执行此方法插入数据
		return $insert_id;
	
	} */
	if($insert_id){
		$this->DB_master->insert(
			$this->table_data, 
			 array(
				'id' => $insert_id,
				'tel' => $data['tel'],
				'info' => $data['info'],
				'content' => $data['content']
			)
		);
		
		if(!empty($data['tags'])){
			foreach($data['tags'] as $tagname){
				$tagname = trim($tagname);
				if(preg_match('/^([\x7f-\xff_-]|\w|\s){2,30}$/', $tagname)) {
					if($row = $this->DB_master->fetch_one("SELECT total FROM " . $this->table_tags . " WHERE tagname='$tagname'")){
						$this->DB_master->update($this->table_tags, array('total'=>$row['total']+1), " tagname='$tagname'");
					}else{ 
						$this->DB_master->insert($this->table_tags, array('tagname'=>$tagname, 'total'=>1));							
					}						
					$this->DB_master->insert($this->table_itemtags, array('id'=>$insert_id, 'tagname'=>$tagname));
				}
			}
		}
		
		return $insert_id;
		
	}
	
}

/**
 * 会员更新问题
 * @param array &$data 数据
 * @return int $data['id'] 返回问题ID
 */
function post_edit(&$data){

	$tags_arr = $tagsnew = array();

	$this->DB_master->update(
		$this->table,
		array(
			'cid' => $data['cid'],
			'title' => $data['title'],
			'offercredit' => $data['offercredit'],
			'credits' => $data['credits'],
			'urgent' => $data['urgent'],
			'anonymous' => $data['anonymous']
		),
		"id='".$data['id']."'"
	);

	$this->DB_master->update(
		$this->table_data,
		array(
			'tel' => $data['tel'],
			'info' => $data['info'],
			'content' => $data['content']
		),
		"id='".$data['id']."'"
	);

	if(!empty($data['tags'])){
		$query = $this->DB_master->query("SELECT tagname FROM " . $this->table_itemtags . " WHERE id='".$data['id']."'");
		while($row = $this->DB_master->fetch_array($query)){
			$tags_arr[] = $row['tagname']; 
		}

		foreach($data['tags'] as $tagname){
			$tagname = trim($tagname);
			if(preg_match('/^([\x7f-\xff_-]|\w|\s){2,30}$/', $tagname)) {
				$tagsnew[] = $tagname;
				if(!in_array($tagname,$tags_arr)){
					if($row = $this->DB_master->fetch_one("SELECT total FROM " . $this->table_tags . " WHERE tagname='$tagname'")){
						$this->DB_master->update($this->table_tags, array('total'=>$row['total']+1), " tagname='$tagname'");
					}else{ 
						$this->DB_master->insert($this->table_tags, array('tagname'=>$tagname, 'total'=>1));							
					}
					$this->DB_master->insert($this->table_itemtags, array('id'=>$data['id'], 'tagname'=>$tagname));
				}
			}
		}

		foreach($tags_arr as $tagname){
			if(!in_array($tagname, $tagsnew)) {
				$row = $this->DB_master->fetch_one("SELECT count(*) AS total FROM " . $this->table_itemtags . " WHERE tagname='$tagname' AND id!='$data[id]'");
				if($row['total']) {
					$this->DB_master->update($this->table_tags, array('total'=> "total-1"), " tagname='$tagname'", false);
				} else {
					$this->DB_master->delete($this->table_tags, " tagname='$tagname'");
				}
				$this->DB_master->delete($this->table_itemtags, " tagname='$tagname' AND id='$data[id]'");
			}
		}
	}

	return $data['id'];

}

/**
 * 提交补充提问
 * param array &$data 数据
 * return array('addtime':添加时间,'content':添加内容)
 */
function post_addition(&$data){
	
	$this->DB_master->insert(
			$this->table_addition,
			array(
				'tid' => $data['tid'],
				'uid' => $data['uid'],
				'addtime' => $data['addtime'],
				'content' => $data['content']
			)
		);
	return array(
		'addtime' => date('Y-m-d H:i', $data['addtime']),
		'content' => $data['content']
	);
	
}

/**
 * 提交问题投诉
 * param array &$data 数据
 */
function post_poller(&$data){
	
	return $this->DB_master->insert(
		$this->table_poller,
		array(
			'tid' => $data['tid'],
			'uid' => $data['uid'],
			'username' => $data['username'],
			'anonymous' => $data['anonymous'],
			'ip' => $data['ip'],
			'addtime' => $data['addtime'],
			'content' => $data['content']
		),
		array('return_id' => true)
	);
	
}

/**
 * 收藏问题
 * param array &$data 数据
 * return int 返回添加成功后的ID
 */
function collection(&$data){

	return $this->DB_master->insert(
		$this->table_favorites,
		array(
			'uid' => $data['uid'],
			'tid' => $data['id'],
			'addtime' => $data['addtime']
		),
		array('return_id' => true)
	);
	
}

/**
  * 补充问题列表
  * param string $condition 条件
  * return array $data 返回数据数组
 */
function get_addition($condition){
	
	$data = array();
	
	$query = $this->DB_master->query("SELECT * FROM " . $this->table_addition . " WHERE $condition ORDER BY id ASC");
	while($row = $this->DB_master->fetch_array($query)){
		$data[] = $row;
	}
	
	return $data;
	
}

/**
 * 获取置顶问题
 * param array $params 数据
 * params int $params['cid'] 当前分类ID
 * param array $params['categories'] 分类ID数组
 * param return $data 返回数据
 */
function get_displayorder_items(&$params){

	$data = array();

	$query = $this->DB_master->query("SELECT * FROM " . $this->table . " WHERE verify=1 AND cid>0 AND display_order>0 ORDER BY display_order DESC, id DESC");
	while($row = $this->DB_master->fetch_array($query)){
		if(
			$row['display_order']==3 || 
			($row['display_order']==2 && in_array($row['cid'],$params['categories'])) || 
			($row['display_order']==1 && $row['cid']==$params['cid'])
		){
			$row['url'] = p8_url($this, $row, 'view');
			$data[] = $row;
		}
	}

	return $data;

}

/**
 * 取得问题标签(TAG)
 * @param string $condition 条件
 * @return string $tags 返回标签集
 */
function get_itemtags($condition){

	$data = array();
	$tags = $comma = '';

	$query = $this->DB_master->query("SELECT * FROM " . $this->table_itemtags . " WHERE $condition");
	while($row = $this->DB_master->fetch_array($query)){
		$data[] = $row['tagname'];
	}

	if(!empty($data)){
		foreach($data as $tagname){
			$tags .= $comma . $tagname;
			$comma = ',';
		}
	}

	return $tags;

}


/**
 * 取问题标签信息
 * param int $num 标签数目
 * return array $data 返回结果集
 */
function get_tags($num){

	$data = array();
	$query = $this->DB_master->query("SELECT * FROM " . $this->table_tags . " ORDER BY total DESC LIMIT $num");
	while($row = $this->DB_master->fetch_array($query)){
		$row['tagnameenc'] = rawurlencode(to_utf8($row['tagname']));
		$data[] = $row;
	}
	return $data;

}

/**
 * 标签调用的数据, 接口
 * @param array $label 标签数据
 * @param array $var 变量
**/
function label(&$LABEL, &$label, &$var){
	$category = &$this->system->load_module('category');
	$option = &$label['option'];

	$select = select();
	$select->from($this->table . ' AS i', 'i.*');
	$select->left_join($this->table_data . ' AS d', 'd.*', 'd.id=i.id');

if(empty($option['ids'])){
	//审核状态
	$select->in('i.verify', 1);
	//关闭的或到期的
	//$select->range('i.endtime',null, P8_TIME);
	$select->in('i.closed', 1, true);
	//涮选条件
	if(!empty($option['attribute'])){
		switch($option['attribute']){
			case 'recommend'://是否推荐
				$select->in('i.recommend', 1);
				break;
			case 'solve'://己解决
				$select->in('i.status', 3);
				break;
			case 'unsolve':
				$select->in('i.status', 3, true);
				break;
			case 'urgent'://是否紧急
				$select->in('i.urgent', 1);
				break;
			case 'topic'://是否悬赏
				$select->in('i.offercredit', 1);
				break;
			default:	
		}
	}
	if(!empty($option['category'])){
			$select->in('i.cid', $option['category']);
		}
	//排序
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}else{
		$select->order("i.id DESC");
	}
	
	//当前页码
	$page = 1;
	//总记录数
	$count = 0;
	//搜索关键字
	if(!empty($option['keyword'])){
			$select->search('i.title', str_replace(',',' ',$option['keywords']));
	}elseif(is_array($var)){
		foreach($option['var_fields'] as $field => $v){
			//处理变量字段
			switch($v['operator']){
				case 'in':
					$select->in($field, $var[$field]);
					break;						
				case 'search':
					$select->search($field, $var[$field]);
					break;
			}
		}
	
		if($option['pageable']){
			//可分页,有页码
			if(isset($var['#page#'])) $page = $var['#page#'];
			//有记录数
			if(isset($var['#count#'])) $count = $var['#count#'];
		}
	}
}else{
	$select->in('i.id', $option['ids']);
	$select->order("i.id DESC");
}	
	//echo $select->build_sql();
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $option['limit'],
			'count' => &$count,
			'sphinx' => $option['sphinx']
		)
	);
	$dot = empty($option['title_dot']) ? '' : '...';
	foreach($list as $k => $v){			
		$list[$k]['full_title'] = $list[$k]['title'];
		if(!empty($list[$k]['sub_title'])){
			$list[$k]['title'] = p8_cutstr($list[$k]['sub_title'], $option['title_length'], $dot);
		}else{
			$list[$k]['title'] = p8_cutstr($list[$k]['title'], $option['title_length'], $dot);
		}
		$list[$k]['timestamp'] = $v['addtime'];
		$list[$k]['url'] = p8_url($this, $v, 'view');

		$v['#category'] = $category->get_one(array('id'=>$v['cid']), true);
		$list[$k]['category_url'] = $v['#category']['url'];
		$list[$k]['category_name'] = $v['#category']['name'];
	}
	//随机数
	$rand = rand_str(4);
	//每行的宽度,用于多列
	$width = (!empty($option['rows']) && $option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	$wf ='';
	if($width!='99%'){
		$wf = "width:$width;float:left;margin-right:1%";
	}
	//如果可分页
	if($option['pageable']){
		//获取页面上的分类数组
		global $CAT;
		if(!empty($CAT)){
			//如果处于本模块的分页脚本上
			$CAT['is_category'] = true;
		}
		
		//当前分类的分页
		$pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => $option['limit'],
			'url' => p8_url($this, $CAT, 'list', false)
		));
		
	}	
	
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
function view_record($type,$id){
	$data=array("$type"=>"$type+1");

	$this->DB_master->update($this->table, $data, "id='$id'",false);	

}

/*每增删一个问题缓存一次*/
function set_statistics($data){
	$field = $data['field'];
	$mark = $data['mark'];
	$number  = $data['number'];
	if(!$field || !$mark)return;
	if($mark == '-'){
		$update_data = array("$field" => $field.'-'.$number);
	}else{
		$update_data = array("$field" => $field.'+'.$number);
	}
	$status= $this->DB_master->update(
			$this->system->table_statistics,
			$update_data,
			'',
			false
		);
	$this->system->cache_statistics();	
		
}

/*统一重新统计*/
function cache_statistics(){
	$item_count = $this->DB_master->fetch_one("SELECT COUNT(id) AS count FROM $this->table");
	$salve_count = $this->DB_master->fetch_one("SELECT COUNT(id) AS count FROM $this->table WHERE status=3");
	$status= $this->DB_master->update(
			$this->system->table_statistics,
			array('item_count'=>$item_count['count'],'solve_item_count'=>$salve_count['count']),
			'',
			false
		);
	$this->system->cache_statistics();	
}

function homepage_list(&$block){
	global $core, $SKIN, $RESOURCE, $USER;
	
	ob_start();
	include template($this, 'block/list');
	return ob_get_clean();
}

}