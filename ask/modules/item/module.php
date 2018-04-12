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
 * ��������Ƿ����
 * param string $condition ����
 * return bool true||false ����:true,������:false
 */
function check_exists($condition){
	
	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
		return true;
	}else{
		return false;
	}

}

/**
 * ����ղ��Ƿ����
 * param string $condition ����
 * return bool true || false �����߼���
 */
function check_exists_favorites($condition){
			
	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_favorites . " WHERE $condition")){
		return true;
	}else{
		return false;
	}
	
}

/**
 * ����Ͷ���Ƿ����
 * param string $condition ����
 * return bool true||false �����߼���,����:true,������:false
 */
function check_exists_poller($condition){
	
	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_poller . " WHERE $condition")){
		return true;
	}else{
		return false;
	}

}

/**
 * �����Ƿ����ش�
 * param int $id ����ID
 * return bool �����߼���,true��false
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
 * ���⵽��ʱ��
 * param int $endtime ���⵽��ʱ��
 * return array $data ����ʱ������ ��,Сʱ,��,��
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
 * �������
 * param string $condition ����
 * param int $verify 1:ͨ�����,0:����
 * return int ����Ӱ����Ŀ
 */ 
function verify($condition, $verify){

	return $this->DB_master->update(
		$this->table,
		array('verify'=>$verify),
		$condition
	);

}

/**
 * �Ƽ�����
 * param string $condition ����
 * param int $recommend 1:�Ƽ�,0ȡ���Ƽ�
 * return int ����Ӱ����Ŀ
 */
function recommend($condition, $recommend){

	 return $this->DB_master->update(
		 $this->table,
		 array('recommend'=>$recommend),
		 $condition
	 );

}

/**
 * �ر�����
 * ���ⱻ�رպ󲻿��ٻش��ͶƱ��
 * param string $condition ����
 * param int $closed 1:�ر�,0:��
 * return int ���ظ��³ɹ�����Ŀ
 */
function closed($condition, $closed){

	return $this->DB_master->update(
		 $this->table,
		 array('closed'=>$closed),
		 $condition
	 );

}

	/**
 * ���������
 *  ��������ⲻ���ٻش�
 * param string $condition ����
 * param string $solve ���� 1:δ���,2:����,3:�ѽ��
 * return int ���ظ��³ɹ�����Ŀ
 */
function solved($condition, $status=3){

	$statu =  $this->DB_master->update(
		 $this->table,
		 array('status'=>$status),
		 $condition
	 );
	 //����ͳ������	
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
 * ��������
 * param array &$data ����
 * param int $data['id'] ����ID
 * param string $data['title'] ����
 * param string $data['content'] ����
 * param string $data['info'] ����/QQ/MSN
 * param string $data['tel'] �绰
 * param int $data['cid'] ����ID����Ϊ������·���
 * param bool $data['update_time'] ����ʱ�䣬true:���£�false:������
 * param array $data['tags'] ��ǩ����
 * return int $data['id'] ��������ID
 */
function update(&$data){

	$tags_arr = $tagsnew = array();

	$_data = array(
		'title' => $data['title'],
		'sub_title' => $data['sub_title']
		);
	//����ʱ��
	if($data['update_time']){
		$_data = array_merge(
				$_data, 
				array(
					'addtime' => $data['addtime'],
					'endtime' => $data['endtime']
				)
			);
	}
	//���·���ID
	if(!empty($data['cid'])){
		$_data = array_merge($_data, array('cid'=>$data['cid']));
	}
	
	$update_rows = $this->DB_master->update($this->table, $_data, "id='$data[id]'");

	//��������
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
 * �����ö�����
 * param string $condition ����
 * param int display_order �ö�λ��,0:ȡ��,1:��ǰ��Ŀ�ö�,2:��Ŀ�ö�,3:���ö�
 * return int ���ظ�����Ŀ
 */
function set_display_order($condition, $display_order){

	return $this->DB_master->update(
		$this->table,
		array('display_order'=>$display_order),
		$condition
	);
	
}

/**
 * ���Ͷ�������Ѵ���
 * @param string $condition ����
 * @return int ���ظ��³ɹ�����Ŀ
 */
function set_poller_handler($condition){

	return $this->DB_master->update(
		$this->table_poller, 
		array('handler'=>1),
		$condition
	);

}

/**
 * ɾ������
 * param string $condition ����
 * return int ����ɾ��Ӱ����Ŀ
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
	//ɾ������
	if($this->DB_master->delete($this->table," id IN ($ids) ")){
		//ɾ���������ݱ�
		$this->delete_data(" id IN ($ids) ");
		//ɾ�������ǩ
		$this->delete_tags(" id IN ($ids) ");
		//ɾ��������������
		$this->delete_addition("tid IN($ids)");
		//ɾ�������ղؼ�
		$this->delete_favorites("tid IN($ids)");
		//ɾ���Ƽ������
		$this->delete_push("tid IN($ids)");
		//ɾ��Ͷ��
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
/**�����������**/
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
 * ɾ���������ݱ�
 * param string $condition ����
 * return array ����ɾ���ɹ��������ID����
 */
function delete_data($condition){

	return $this->DB_master->delete(
		$this->table_data, 
		$condition
	);

}

/**
 * ɾ������Ͷ��
 * param string $condition ����
 * return array ����ɾ���ɹ����Ͷ��ID����
 */
function delete_poller($condition){

	return $this->DB_master->delete(
		$this->table_poller,
		$condition
	);

}


/**
 * ɾ����������
 * param string $condition ����
 * return array ����ɾ���ɹ���Ĳ�������ID����
 */
function delete_addition($condition){

	return $this->DB_master->delete(
		$this->table_addition,
		$condition
	);

}

/**
 * ɾ�������ղؼ�
 * param string $condition ����
 * return array ����ɾ���ɹ�����ղ�ID����
 */
function delete_favorites($condition){

	return $this->DB_master->delete(
		$this->table_favorites,
		$condition
	);

}

/**
 * ɾ���Ƽ�����
 * param string $condition ����
 * return array ����ɾ���Ƽ�����ID����
 */
function delete_push($condition){

	return $this->DB_master->delete(
		$this->table_push,
		$condition
	);

}

/**
 * ɾ�������ǩ
 * param string $condition ����
 * return int $delrows ����ɾ���ɹ������Ŀ
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
 * ��Աɾ������
 * param array $ids ����ID����
 * param string $condition ִ������
 * return array $delids ����ɾ������ID����
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

	//ɾ������
	$rows = $this->DB_master->delete($this->table, " id IN($allids) $condition");
	if($rows){
	$allids= "id IN ($allids)";
		//ɾ���������ݱ�
		$this->delete_data($allids);
		//ɾ��������������
		$this->delete_addition($allids);
		//ɾ�������ղؼ�
		$this->delete_favorites($allids);
		//ɾ���Ƽ������
		$this->delete_push($allids);
		//ɾ�������ǩ
		$this->delete_tags($allids);
		//���»�Աͳ����Ϣ

	}

	return $delids;

}

/**
 * ��Աɾ���ղؼ�
 * param array $ids �ղ�ID����
 * param string $condition ����
 * return array $delids ����ɾ���ղ�ID����
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
 * ��Ա�ύ����
 * param array &$data ����
 * return int $insert_id �����ύ�ɹ����ID
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
		//δ���
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
		//ɾ��
		$this->DB_master->delete(
			$this->table,
			"id = '$insert_id'"
		);
		
		//����,���ͨ����ʱ����ִ�д˷�����������
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
 * ��Ա��������
 * @param array &$data ����
 * @return int $data['id'] ��������ID
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
 * �ύ��������
 * param array &$data ����
 * return array('addtime':���ʱ��,'content':�������)
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
 * �ύ����Ͷ��
 * param array &$data ����
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
 * �ղ�����
 * param array &$data ����
 * return int ������ӳɹ����ID
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
  * ���������б�
  * param string $condition ����
  * return array $data ������������
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
 * ��ȡ�ö�����
 * param array $params ����
 * params int $params['cid'] ��ǰ����ID
 * param array $params['categories'] ����ID����
 * param return $data ��������
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
 * ȡ�������ǩ(TAG)
 * @param string $condition ����
 * @return string $tags ���ر�ǩ��
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
 * ȡ�����ǩ��Ϣ
 * param int $num ��ǩ��Ŀ
 * return array $data ���ؽ����
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
 * ��ǩ���õ�����, �ӿ�
 * @param array $label ��ǩ����
 * @param array $var ����
**/
function label(&$LABEL, &$label, &$var){
	$category = &$this->system->load_module('category');
	$option = &$label['option'];

	$select = select();
	$select->from($this->table . ' AS i', 'i.*');
	$select->left_join($this->table_data . ' AS d', 'd.*', 'd.id=i.id');

if(empty($option['ids'])){
	//���״̬
	$select->in('i.verify', 1);
	//�رյĻ��ڵ�
	//$select->range('i.endtime',null, P8_TIME);
	$select->in('i.closed', 1, true);
	//��ѡ����
	if(!empty($option['attribute'])){
		switch($option['attribute']){
			case 'recommend'://�Ƿ��Ƽ�
				$select->in('i.recommend', 1);
				break;
			case 'solve'://�����
				$select->in('i.status', 3);
				break;
			case 'unsolve':
				$select->in('i.status', 3, true);
				break;
			case 'urgent'://�Ƿ����
				$select->in('i.urgent', 1);
				break;
			case 'topic'://�Ƿ�����
				$select->in('i.offercredit', 1);
				break;
			default:	
		}
	}
	if(!empty($option['category'])){
			$select->in('i.cid', $option['category']);
		}
	//����
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}else{
		$select->order("i.id DESC");
	}
	
	//��ǰҳ��
	$page = 1;
	//�ܼ�¼��
	$count = 0;
	//�����ؼ���
	if(!empty($option['keyword'])){
			$select->search('i.title', str_replace(',',' ',$option['keywords']));
	}elseif(is_array($var)){
		foreach($option['var_fields'] as $field => $v){
			//��������ֶ�
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
			//�ɷ�ҳ,��ҳ��
			if(isset($var['#page#'])) $page = $var['#page#'];
			//�м�¼��
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
	//�����
	$rand = rand_str(4);
	//ÿ�еĿ��,���ڶ���
	$width = (!empty($option['rows']) && $option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	$wf ='';
	if($width!='99%'){
		$wf = "width:$width;float:left;margin-right:1%";
	}
	//����ɷ�ҳ
	if($option['pageable']){
		//��ȡҳ���ϵķ�������
		global $CAT;
		if(!empty($CAT)){
			//������ڱ�ģ��ķ�ҳ�ű���
			$CAT['is_category'] = true;
		}
		
		//��ǰ����ķ�ҳ
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
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
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

/*ÿ��ɾһ�����⻺��һ��*/
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

/*ͳһ����ͳ��*/
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