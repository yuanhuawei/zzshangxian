<?php
class P8_Ask_answer extends P8_module{

	var $table; //������
	var $table_data; //�����ݱ�
	var $table_votes; //ͶƱ��
	var $table_poller; //Ͷ�߱�
	var $table_follow; //׷�ʱ�
	
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
	 * �����Ƿ����
	 * param string $condition ����
	 * return bool true||false �����߼���,����:true,������:false
	 */
	function check_exists($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
			return true;
		}else{
			return false;
		}

	}

	/**
	 * ����Ͷ���Ƿ����
	 * @param string $condition ����
	 * @return bool true||false �����߼���,����:true,������:false
	 */
	function check_exists_poller($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_poller . " WHERE $condition")){
			return true;
		}else{
			return false;
		}

	}

	/**
	 * ����Ƿ��ѶԴ�Ͷ��Ʊ,��IPΪ�ж�����
	 * @param string $condition ����
	 * @return bool ����:true,������:false
	 */
	function check_exists_votes($condition){

		if($this->DB_master->fetch_one("SELECT id FROM " . $this->table_votes . " WHERE $condition")){
			return true;
		}else{
			return false;
		}
		
	}

	/**
	 * ��˴�
	 * @param string $condition ����
	 * @param int $verify 1:ͨ�����,0:����
	 * @return int ����Ӱ����Ŀ
	 */
	function verify($condition, $verify){

		return $this->DB_master->update(
			$this->table,
			array('verify' => $verify),
			$condition
		);

	}

	/**
	 * ������Ѵ�
	 * @param string $condition ����
	 * @param int $data ����
	 * @return int ���ظ��³ɹ�����Ŀ
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
	 * ���´������������Ѵ�ժҪ
	 * @param string $condition ����
	 * @return array $ids_arr ���ظ��³ɹ������ID����
	 */
	function set_bestanswer_summary($condition){

		$ids_arr = array();
		
		//�����������ģ��
		$item = &$this->system->load_module('item');

		$row = $this->DB_master->fetch_one("SELECT A.id,A.tid,A.uid,A.username,A.addtime,B.content FROM " . $this->table . " AS A LEFT JOIN " . $this->table_data . " AS B ON B.id=A.id WHERE $condition");
		if($row){
			if($item->check_exists("id='".$row['tid']."'")){
				$ids_arr[] = $row['id'];
				$row['content'] = p8_cutstr(strip_tags(str_replace(' ','',html_decode_entities($row['content']))),60);
				//��ID ��ժҪ���� ���ʱ�� �û�ID �û�����		
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
	 * ���������Ѵ�
	 * @param string $condition ����
	 */
	function remove_bestanswer_summary($condition){

		$ids_arr = array();

		//�����������ģ��
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
	 * ��ȡ���д�ID����
	 * param string $conditon ����
	 * return array $data ������������
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
	 * ���´�
	 * @param array &$data ����
	 * @param array $array ����ʱ�����������
	 */
	function update(&$data){

		$array = array();

		//����ʱ��
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
	 * ɾ����
	 * @param string $condition ����
	 * @return int ����Ӱ����Ŀ
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
		//ɾ��������
		$this->DB_master->delete(
			$this->table_data,
			$condition
		);
		//ɾ����������
		return $this->DB_master->delete(
			$this->table, 
			$condition
		);
	
	}

	/**
	 * ɾ����ͶƱ
	 * @param string $condition ����
	 */
	function delete_votes($condition){

		return $this->DB_master->delete(
			$this->table_votes, 
			$condition
		);

	}

	/**
	 * ɾ����Ͷ��
	 * @param string $condition ����
	 * @return array ����ɾ���ɹ����Ͷ��ID����
	 */
	function delete_poller($condition){

		return $this->DB_master->delete(
			$this->table_poller,
			$condition
		);

	}

	/**
	 * ��մ�ͶƱ���
	 * @param array &$data ����
	 * @param int $data['id'] ��ID
	 * @return int $affected_rows ���ظ���Ӱ�����Ŀ
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
	
	/**�����������**/
function clean(){
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_data");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_votes");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_poller");
	$query=$this->DB_master->query("TRUNCATE TABLE $this->table_follow");
	return $query;
}


	/**
	 * �ύ�����
	 * param array &$data ����
	 * return int $insert_id �����ύ�ɹ���Ĵ�ID
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
	 * ��Ա�ύ��Ͷ����Ϣ
	 * @param array &$data ����
	 * @return int �����ύ�ɹ����ID
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
	 * �ύ��ͶƱ
	 * @param array &$data ����
	 * @param int $id ��ID
	 * @param int $result 1:֧��,0:����
	 * @return array $array ����ͶƱ�������
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
			//���ͶƱ�ɹ����������ͶƱ����
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
	 * �ύ׷��
	 * @param array &$data ����
	 * @return int �����ύ�ɹ����ID
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
	 * �ύ��������
	 * @param array &$data ����
	 * @return int ����׷�ʵ�ID
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
	 * ��ȡ׷������
	 * @param string $condition ����
	 * @return array $data ����ȫ��׷������
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
	 * ���б�
	 * @param int $tid ����ID
	 * @return array $data �������д�
	 */
	function show($tid = '', $cid = ''){
		
		global $UID;		
		$data = array();
		
		$query = $this->DB_master->query("SELECT A.*,D.content,M.expert FROM " . $this->table . " AS A 
		INNER JOIN " . $this->table_data . " AS D ON D.id=A.id 
		LEFT JOIN " . $this->system->member_table ." AS M ON M.id=A.uid 
		WHERE A.verify=1 AND A.tid='$tid' ORDER BY A.addtime ASC");
		while($row = $this->DB_master->fetch_array($query)){
			//�Ƿ��ǻش��߱���
			$row['is_creator'] =  $row['uid']==$UID ? true : false;
			//׷������
			$row['follow'] = $this->get_follow("aid='".$row['id']."'");

			if($row['bestanswer']){
				//����ͶƱ��
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