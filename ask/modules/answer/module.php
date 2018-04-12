<?php
class P8_Ask_answer extends P8_module{

	var $table; //答案主表
	var $table_data; //答案数据表
	var $table_votes; //投票表
	var $table_poller; //投诉表
	var $table_follow; //追问表
	
	function P8_Ask_answer(&$system, $name){
		$this->system = &$system;
		parent::__construct($name);
		
		$this->table = $this->TABLE_;
		$this->table_data = $this->table . 'data';
		$this->table_votes = $this->table . 'votes';
		$this->table_poller = $this->table . 'poller';
		$this->table_follow = $this->table . 'follow';
		$this->table_item = $this->core->TABLE_.$this->system->name . '_item_';
	}
	
	/**
	 * 检查答案是否存在
	 * param string $condition 条件
	 * return bool true||false 返回逻辑型,存在:true,不存在:false
	 */
	function check_exists($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
			return true;
		}else{
			return false;
		}

	}

	/**
	 * 检查答案投诉是否存在
	 * @param string $condition 条件
	 * @return bool true||false 返回逻辑型,存在:true,不存在:false
	 */
	function check_exists_poller($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_poller . " WHERE $condition")){
			return true;
		}else{
			return false;
		}

	}

	/**
	 * 检查是否已对答案投过票,以IP为判断条件
	 * @param string $condition 条件
	 * @return bool 存在:true,不存在:false
	 */
	function check_exists_votes($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_votes . " WHERE $condition")){
			return true;
		}else{
			return false;
		}
		
	}

	/**
	 * 审核答案
	 * @param string $condition 条件
	 * @param int $verify 1:通过审核,0:锁定
	 * @return int 返回影响数目
	 */
	function verify($condition, $verify){

		return $this->DB_master->update(
			$this->table,
			array('verify' => $verify),
			$condition
		);

	}

	/**
	 * 设置最佳答案
	 * @param string $condition 条件
	 * @param int $data 数据
	 * @return int 返回更新成功的数目
	 */
	function set_best_answer($condition, $data){
	
		return $this->DB_master->update(
			$this->table,
			array(
				'executor' => $data['executor'],
				'bestanswer' => $data['bestanswer']
			),
			$condition
		);

	}

	/**
	 * 更新答案所属问题的最佳答案摘要
	 * @param string $condition 条件
	 * @return array $ids_arr 返回更新成功问题的ID数组
	 */
	function set_bestanswer_summary($condition){

		$ids_arr = array();
		
		//载入问题分类模块
		$item = &$this->system->load_module('item');

		$row = $this->DB_master->fetch_one("SELECT A.id,A.tid,A.uid,A.username,A.addtime,B.content FROM " . $this->table . " AS A LEFT JOIN " . $this->table_data . " AS B ON B.id=A.id WHERE $condition");
		if($row){
			if($item->check_exists("id='".$row['tid']."'")){
				$ids_arr[] = $row['id'];
				$row['content'] = p8_cutstr(strip_tags(str_replace(' ','',html_decode_entities($row['content']))),60);
				//答案ID 答案摘要内容 添加时间 用户ID 用户名称		
				$this->DB_master->update(
					$item->table_data,
					array(
						'bestanswer'=>$row['content'],
						'bestanswer_uid'=>$row['uid'],
						'bestanswer_username'=>$row['username'],
						'bestanswer_time'=>$row['addtime'],
						'bestanswer_id'=>$row['id']
						),
					"id='".$row['tid']."'"
				);
			}
		}

		return $ids_arr;

	}

	/**
	 * 清除问题最佳答案
	 * @param string $condition 条件
	 */
	function remove_bestanswer_summary($condition){

		$ids_arr = array();

		//载入问题分类模块
		$item = &$this->system->load_module('item');

		$query = $this->DB_master->query("SELECT * FROM " . $this->table . " WHERE $condition");
		while($row = $this->DB_master->fetch_array($query)){
			if($item->check_exists("id='".$row['tid']."'")){
				$ids_arr[] = $row['id'];
				$this->DB_master->update(
						$item->table_data,
						array(
							'bestanswer'=>'',
							'bestanswer_uid'=>'',
							'bestanswer_username'=>'',
							'bestanswer_time'=>'',
							'bestanswer_id'=>''
						),
						"id='".$row['tid']."'"
					);
			}
		}
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
	 * 获取所有答案ID数组
	 * param string $conditon 条件
	 * return array $data 返回条件数组
	 */
	function get_allids($condition){

		$data = array();		
		$condition = !empty($condition) ? " WHERE $condition " : '';

		$query = $this->DB_master->query("SELECT id FROM " . $this->table . " $condition ORDER BY id DESC");
		while($row = $this->DB_master->fetch_array($query)){
			$data[] = $row['id'];
		}

		return $data;

	}

	/**
	 * 更新答案
	 * @param array &$data 数据
	 * @param array $array 返回时间和内容数组
	 */
	function update(&$data){

		$array = array();

		//更新时间
		if($data['is_update_time']){
			$this->DB_master->update(
				$this->table,
				array('addtime'=>$data['addtime']),
				"id='".$data['id']."'"
			);
			$array['addtime'] = date('Y-m-d H:i', $data['addtime']);
		}

		$this->DB_master->update(
				$this->table_data,
				array('content'=>$data['content']),
				"id='".$data['id']."'"
			);

		$row = $this->DB_master->fetch_one("SELECT * FROM " . $this->table_data . " WHERE id='".$data['id']."'");
		$array['summary'] = P8_cutstr(strip_tags(html_decode_entities($row['content'])),30);

		return $array;

	}

	/**
	 * 删除答案
	 * @param string $condition 条件
	 * @return int 返回影响数目
	 */
	function delete($data){
		$T=$this->table;
	$ids = $comma  =$id='';
	$query=$this->DB_master->query("SELECT $T.id FROM $T WHERE $data[where]");
	while($rs = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $rs['id'];
		$id[] = $rs['id'];
		$comma = ',';
	
	}
	if(!$id)return;
	$condition = " id IN ($ids) ";
		//删除答案数据
		$this->DB_master->delete(
			$this->table_data,
			$condition
		);
		//删除主表数据
		return $this->DB_master->delete(
			$this->table, 
			$condition
		);
	
	}

	/**
	 * 删除答案投票
	 * @param string $condition 条件
	 */
	function delete_votes($condition){

		return $this->DB_master->delete(
			$this->table_votes, 
			$condition
		);

	}

	/**
	 * 删除答案投诉
	 * @param string $condition 条件
	 * @return array 返回删除成功后的投诉ID数组
	 */
	function delete_poller($condition){

		return $this->DB_master->delete(
			$this->table_poller,
			$condition
		);

	}

	/**
	 * 清空答案投票结果
	 * @param array &$data 数据
	 * @param int $data['id'] 答案ID
	 * @return int $affected_rows 返回更新影响的数目
	 */
	function remove_votes(&$data){

		$affected_rows = $this->DB_master->update(
			$this->table,
			array(
				'vote_good' => 0,
				'vote_bad' => 0
			), 
			"id='".$data['id']."'"
		);
		if($affected_rows){
			$this->DB_master->delete($this->table_votes, "aid='".$data['id']."'");
		}

		return $affected_rows;

	}
	
	/**清空所有内容**/
function clean(){
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_data");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_votes");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_poller");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_follow");
	return $query;
}


	/**
	 * 提交问题答案
	 * param array &$data 数据
	 * return int $insert_id 返回提交成功后的答案ID
	 */
	function post(&$data){
	
		$insert_id = $this->DB_master->insert(
			$this->table,
			array(
				'tid' => $data['id'],
				'uid' => $data['uid'],
				'username' => $data['username'],
				'anonymous' => $data['anonymous'],
				'verify' => $data['verify'],
				'addtime' => $data['addtime'],
				'ip' => $data['ip']
			),
			array('return_id' => true)
		);
		
		if($insert_id){
			$this->DB_master->insert(
				$this->table_data, 
				array(
					'id'=>$insert_id,
					'content'=>$data['content']
				)
			);
		}

		return $insert_id;
		
	}

	/**
	 * 会员提交答案投诉信息
	 * @param array &$data 数据
	 * @return int 返回提交成功后的ID
	 */
	function post_poller(&$data){

		return $this->DB_master->insert(
			$this->table_poller,
			array(
				'aid' => $data['id'],
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
	 * 提交答案投票
	 * @param array &$data 数据
	 * @param int $id 答案ID
	 * @param int $result 1:支持,0:反对
	 * @return array $array 返回投票结果数组
	 */
	function post_votes(&$data){
		
		global $UID;
		$array = array();		
		
		$insert_id = $this->DB_master->insert(
			$this->table_votes, 
			array(
				'aid' => $data['aid'],
				'uid' => !empty($UID) ? $UID : 0,
				'ip' => P8_IP,
				'result' => $data['result']
			),
			array('return_id' => true)
		);
		
		if($insert_id){
			//如果投票成功则更新主表投票次数
			$row = $this->DB_master->fetch_one("SELECT vote_good,vote_bad FROM " . $this->table . " WHERE id='".$data['aid']."'");
			$array['vote_good'] = $row['vote_good'];
			$array['vote_bad'] = $row['vote_bad'];
			$array['vote_count'] = $array['vote_good'] + $array['vote_bad'];
			
			$data['result'] ? $_data=array('vote_good'=>$array['vote_good']+1) : $_data=array('vote_bad'=>$array['vote_bad']+1);

			$affect_rows = $this->DB_master->update($this->table, $_data, "id='".$data['aid']."'");
			if($affect_rows) $array['vote_count']++;
			if($data['result']){
				$array['vote_good']++;
			}else{
				$array['vote_bad']++;
			}
			
			$array['good_percentage'] = round($array['vote_good']/$array['vote_count']*100, 2);
			$array['bad_percentage'] = round($array['vote_bad']/$array['vote_count']*100, 2);
			
		}
		
		return $array;
		
	}

	/**
	 * 提交追问
	 * @param array &$data 数据
	 * @return int 返回提交成功后的ID
	 */
	function post_follow(&$data)
	{

		return $this->DB_master->insert(
			$this->table_follow,
			array(
				'tid' => $data['tid'],
				'aid' => $data['aid'],
				'uid' => $data['uid'],
				'addtime' => $data['addtime'],
				'content' => $data['content']
			),
			array('return_id' => true)
		);

	}

	/**
	 * 提交补充提问
	 * @param array &$data 数据
	 * @return int 返回追问的ID
	 */
	function post_reply_follow(&$data)
	{

		$this->DB_master->update(
			$this->table_follow,
			array(
				'reply_uid' => $data['reply_uid'],
				'reply_time' => $data['reply_time'],
				'reply_content' => $data['reply_content']
			),
			"id='".$data['id']."'"
		);

		return $data['id'];

	}

	/**
	 * 获取追问内容
	 * @param string $condition 条件
	 * @return array $data 返回全部追问内容
	 */
	function get_follow($condition)
	{

		$data = array();

		$query = $this->DB_master->query("SELECT * FROM " . $this->table_follow . " WHERE $condition");
		while($row = $this->DB_master->fetch_array($query)){
			$row['addtime'] = date('Y-m-d H:i', $row['addtime']);
			if(!empty($row['reply_content'])){
				$row['reply_time'] = date('Y-m-d H:i', $row['reply_time']);
			}
			$data[] = $row;
		}
		return $data;

	}

	/**
	 * 答案列表
	 * @param int $tid 问题ID
	 * @return array $data 返回所有答案
	 */
	function show($tid = '', $cid = ''){
		
		global $UID;		
		$data = array();
		
		$query = $this->DB_master->query("SELECT A.*,D.content,M.expert FROM " . $this->table . " AS A 
		INNER JOIN " . $this->table_data . " AS D ON D.id=A.id 
		LEFT JOIN " . $this->system->member_table ." AS M ON M.id=A.uid 
		WHERE A.verify=1 AND A.tid='$tid' ORDER BY A.addtime ASC");
		while($row = $this->DB_master->fetch_array($query)){
			//是否是回答者本身
			$row['is_creator'] =  $row['uid']==$UID ? true : false;
			//追问内容
			$row['follow'] = $this->get_follow("aid='".$row['id']."'");

			if($row['bestanswer']){
				//计算投票数
				$row['goodvalue'] = $row['vote_good'];
				$row['badvalue'] = $row['vote_bad'];
				$row['count'] = $row['goodvalue'] + $row['badvalue'];
				$row['good_percentage'] = $row['count']>0 ? round($row['goodvalue']/$row['count']*100, 2) : 0;
				$row['bad_percentage'] = $row['count']>0 ? round($row['badvalue']/$row['count']*100, 2) : 0;
				$data['best'][] = $row;
			}
			elseif(!$row['anonymous'] && 
					$this->core->controller($this)->check_category_action('verify', $cid)
				){
				$data['super'][] = $row;
			}else if(!$row['anonymous'] && $row['expert']){
				$member = &$this->system->load_module('member');
				$cids = $member->get_exper_cid($row['uid']);
				if(in_array($cid,$cids))$data['super'][] = $row;
				else $data['normal'][] = $row;
			}
			else{
				$data['normal'][] = $row;
			}

		}
		
		return $data;
		
	}
	
	

}