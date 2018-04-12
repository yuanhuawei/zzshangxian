<?php

class P8_Ask_Member_Controller extends P8_Controller{
	
	var $category_acl;
	
	function P8_Ask_Member_Controller(&$obj){
		parent::__construct($obj);
		
	}

	/**
	 * ��֤�Ƿ�Ϊ����
	 * param array &$POST ����
	 */
	function valid_array(&$POST){
		
		if(empty($POST) || !is_array($POST)){
			return false;
		}else{
			return true;
		}

	}

	/** 
	 * ��֤�Ƿ�Ϊ������
	 * param int $params ��ֵ
	 */
	function valid_numeric($params){

		if(empty($params) || !preg_match("/^[0-9]*$/", $params)){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * ����û��Ƿ����
	 * param array $params ��������
	 */
	function check_exists($params = array()){

		$condition = '';
		
		if(empty($params) || !$this->valid_array($params)){
			return false;
		}

		if(isset($params['id'])) $condition = "id='".$params['id']."'";

		if(empty($condition)) return false;

		return $this->model->check_exists($condition);

	}

	/**
	 * ���ר���û��Ƿ����
	 * param array $params ��������
	 * param int $params['id'] ר�ұ�ID
	 * param int $params['uid'] �û�ID
	 * param int $params['cid'] ����ID
	 */
	function check_exists_expertor($params = array()){

		$condition = '';

		//�������ģ��
		$category = &$this->model->system->load_module('category');
		$category_controller = &$this->model->core->controller($category);

		if(empty($params) || !$this->valid_array($params)){
			return false;
		}

		if(!empty($params['id'])) $condition = "id='" . $params['id'] . "'";

		if(!empty($params['uid']) && $this->check_exists(array('id'=>$params['uid']))){
			$condition = empty($condition) ? "uid='" . $params['uid'] . "'" : $condition." AND uid='" . $params['uid'] . "'";
		}

		if(!empty($params['cid']) && $category_controller->check_exists(array('id'=>$params['cid']))){
			$condition = empty($condition) ? "cid='" . $params['cid'] . "'" : $condition . " AND cid='" . $params['cid'] . "'";
		}

		if(empty($condition)) return false;

		return $this->model->check_exists_expertor($condition);

	}

	/**
	 * ����û�
	 * param array &$POST ����
	 * return array $data �����û������Ϣ
	 */
	function verify(&$POST){

		$data = array();
		$allids = $comma = '';

		if(!$this->valid_array($POST) || !in_array($POST['verify'],array(0,1)) || !$this->valid_array($POST['ids'])){
			return array();
		}

		foreach($POST['ids'] as $id){
			if($this->check_exists(array('id'=>$id))){
				$data[$id] = $POST['verify'];
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)) return array();

		$this->model->verify(" id IN($allids)",array('verify'=>$POST['verify']));
		return $data;

	}

	/**
	 * �����ʴ�֮��
	 * param array &$POST ����
	 * return array $data �����û���Ϣ
	 */
	function set_star(&$POST){

		$data = array();
		$allids = $comma = '';
		
		if(!$this->valid_array($POST) || !in_array($POST['star'],array(0,1)) || !$this->valid_array($POST['ids'])){
			return array();
		}

		foreach($POST['ids'] as $id){
			if($this->check_exists(array('id'=>$id))){
				$data[$id] = $POST['star'];
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)) return array();

		$this->model->set_star(" id IN($allids)",array('star'=>$POST['star']));
		return $data;

	}

	/** 
	 * ����ר���û�
	 * param array &$POST ����
	 * param array $POST['ids'] �û�ID��
	 * param array $POST['cids'] ����ID��
	 */
	function set_expertor(&$POST){

		$data = $uids_arr = array();

		//�������ģ��
		$category = $this->model->system->load_module('category');
		$category_controller = $this->core->controller($category);		
		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || empty($POST['cids'])){
		return array();
		}

		//ѡȡ�˶���û�
		if(strpos($POST['ids'], ',')){
			$uids_arr = @explode(',', $POST['ids']);
			foreach($uids_arr as $uid){
				if($this->check_exists(array('id'=>$uid))){
					$data['uids'][] = $uid;
				}
			}

		}
		//ѡȡ�����û�
		elseif($this->check_exists(array('id'=>$POST['ids']))){
			$data['uids'][] = $POST['ids'];
		}
		$POST['cids']=explode(",",$POST['cids']);
		foreach($POST['cids'] as $cid){
			if($category_controller->check_exists(array('id'=>$cid))){
				$data['cids'][] = $cid; 
			}
		}
		if(empty($data['uids']) || empty($data['cids'])) return array();

		return $this->model->set_expertor($data);

	}

	/**
	 * ɾ��ר��
	 * param array &$POST post�ύ������
	 * param array $params ��ز���
	 * param array $POST['uids'] �û�ID
	 * param array $params['cids'] ����ID
	 */
	function delete_expertor($params = array()){

		$conditon = $allids = $alluids = $comma = '';

		if(empty($params) || !$this->valid_array($params)){
			return array();
		}

		//�û�ID
		if(!empty($params['uids'])){
			foreach($params['uids'] as $uid){
				if($this->check_exists(array('id'=>$uid))){
					$alluids .= $comma . $uid;
					$comma = ',';
				}
			}

			if(!empty($alluids)) $condition = "uid IN($alluids)";
		}

		//ר�ұ�ID
		if(!empty($params['ids'])){
			$comma = '';
			foreach($params['ids'] as $id){
				if($this->check_exists_expertor(array('id'=>$id))){
					$allids .= $comma . $id;
					$comma = ',';
				}
			}
			if(!empty($allids)) $condition = empty($condition) ? "id IN($allids)" : $condition." AND id IN($allids)";
		}

		//����ID
		if(!empty($params['cids'])){
			$allcids = $comma = '';
			foreach($params['cids'] as $cid){
					$allcids .= $comma . $cid;
					$comma = ',';
			}

			if(!empty($allcids)) $condition = empty($condition) ? "cid IN($allcids)" : $condition." AND cid IN($allcids)"; 
		}

		if(empty($condition)) return array();	
		
		return $this->model->delete_expertor($condition);

	}

	/**
	 * ���»�Ա�����ղ���
	 * param int $uid �û�ID
	 * param string $method �����(add,cut) 
	 * param int $number ������Ŀ
	 */
	function update_count_favorites($uid = 0, $method = 'add', $number = 1){

		if(empty($uid) || !is_numeric($uid) || !in_array($method, array('add','cut')) || !is_numeric($number)){
			return array();
		}

		return $this->model->update_count_favorites($uid, $method, $number);

	}
	/**
	 * ���»�Ա������
	 * param int $uid �û�ID
	 * param string $method �����(add,cut) 
	 * param int $number ������Ŀ
	 */
	function update_count_item($uid = 0, $method = 'add',$filter='', $number = 1){
	$filters = array('item','solve_item','reply','fav');
		if(empty($uid) || !is_numeric($uid) || !in_array($method, array('add','cut')) || !is_numeric($number) || !in_array($filter,$filters)){
			return array();
		}
		return $this->model->update_count_item($uid, $method,$filter.'_count', $number);

	}
	/**
	 * ��ȡר���û�����
	 * param array $params ����
	 * param int $params['id'] �û�ID
	 * param bool $read_cache �Ƿ��ȡ���໺��
	 */
	function get_expertor_category($params = array(), $read_cache = true){

		$condition = '';

		if(empty($params) || !$this->valid_array($params)){
			return '';
		}

		if(array_key_exists('id',$params) && isset($params['id']) && $this->check_exists(array('id'=>$params['id']))){
			$condition = "uid='".$params['id']."'";
		}

		if(empty($condition)) return '';

		return $this->model->get_expertor_category($condition, $read_cache);

	}

}