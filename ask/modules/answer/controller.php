<?php

class P8_Ask_answer_Controller extends P8_Controller{
		var $category_acl;
	function P8_Ask_answer_Controller(&$obj){
		parent::__construct($obj);
		
	}

	function _init(){
	//��ȡ���ڷ����Ȩ�޿��Ʊ�
		$this->category_acl = $this->get_acl('category_acl');
	}
	/**
	 * ��֤�Ƿ�Ϊ����
	 * param array &$POST ����
	 */
	function valid_array(&$params){
		
		if(empty($params) || !is_array($params)){
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
	 * �����Ƿ����
	 * param array $params ����
	 * param int $params['id'] ��ID,��Ϊ��
	 * param int $params['tid'] ����ID,��Ϊ��
	 * param int $params['uid'] �û�ID,��Ϊ��
	 */
	function check_exists($params = array()){
		
		$condition = '';

		if(empty($params) || !$this->valid_array($params)){
			return false;
		}

		if(!empty($params['id']))  $condition = "id='".$params['id']."'";

		if(!empty($params['tid'])) $condition = !empty($condition) ? $condition." AND tid='".$params['tid']."'" : "tid='".$params['tid']."'";

		if(!empty($params['uid'])) $condition = !empty($condition) ? $condition." AND uid='".$params['uid']."'" : " uid='".$params['uid']."'";
		
		if(empty($condition)){
			return false;
		}

		return $this->model->check_exists($condition);

	}

	/**
	 * ���Ͷ���Ƿ����
	 * @param array $params ����
	 * @param int $params['id'] Ͷ��ID
	 * @param int $params['aid'] ��ID
	 */
	function check_exists_poller($params = array()){

		$condition = '';

		if(empty($params) || !$this->valid_array($params)){
			return false;
		}

		if(!empty($params['id'])) $condition = "id='".$params['id']."'";

		if(!empty($params['aid'])) $condition = !empty($condition) ? $condition." AND aid='".$params['aid']."'" : "aid='".$params['aid']."'";

		if(empty($condition)) return false;

		return $this->model->check_exists_poller($condition);

	}

	/**
	 * ����ͶƱ�Ƿ����
	 * @param array $params ����
	 * @param int $params['aid'] ��ID
	 * @param int $params['result'] ���,1:֧��,0:����
	 * @param int $params['uid'] �û�ID
	 * @param string $params['ip'] IP
	 */
	function check_exists_votes($params = array()){

		$condition = '';

		if(empty($params)) return false;

		if(!empty($params['aid'])) $condition = "aid='".$params['aid']."'";

		if(isset($params['result'])) $condition = !empty($condition) ? $condition." AND result='".$params['result']."'" : "result='".$params['result']."'";

		if(!empty($params['uid'])) $condition = !empty($condition) ? $condition." AND uid='".$params['uid']."'" : "uid='".$params['uid']."'";

		if(!empty($params['ip'])) $condition = !empty($condition) ? $condition." AND ip='".$params['ip']."'" : "ip='".$params['ip']."'";

		if(empty($condition)) return false;

		return $this->model->check_exists_votes($condition);
		
	}

	/**
	 * ��˴�
	 * @param array &$POST ����
	 * @param array $POST['ids'] ��ID����
	 * @param int $POST['verify'] 1:ͨ�����,0:����
	 */
	function verify(&$POST){

		$ids_arr = array();
		$allids = $comma = '';

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || !$this->valid_array($POST['ids']) || !isset($POST['verify']) || !in_array($POST['verify'],array(0,1))){
			return array();
		}

		foreach($POST['ids'] as $id){
			if($this->check_exists(array('id'=>$id))){
				$ids_arr[] = $id;
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)){
			return array();
		}

		$this->model->verify("id IN($allids)", $POST['verify']);
		return $ids_arr;

	}

	/**
	 * ������Ѵ�
	 * @param array &$POST ����
	 * @param int $executor ָ����Ѵ𰸵��û����,1:�û�����,2:��Ŀ����Ա,3:����Ա
	 */
	function set_best_answer(&$POST){

		global $UID;
		$data = array();

		if(empty($UID) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id'])) || !isset($POST['bestanswer']) || !in_array($POST['bestanswer'],array(0,1))){
			return array();
		}

		$data['bestanswer'] = $POST['bestanswer'];	
	//��������ģ��		
		$item = &$this->model->system->load_module('item');
		if($POST['bestanswer']){
		
		
			$role = $this->core->ROLE;
			if(!empty($POST['tid']) && $item->check_exists("id='".$POST['tid']."' AND uid='".$UID."'")){
				$executor = 1;
			}
			elseif($IS_FOUNDER){
				$executor = 3;
			}
			elseif($this->check_action('set_best_answer')){
				$executor = 2;
			}
			else{
				return array();
			}
			$data['executor'] = $executor;			
			$this->model->set_bestanswer_summary("A.id='".$POST['id']."'");
			//�����
			$item->solved("id='".$POST['tid']."'", 3);
		}else{
			$data['executor'] = 0;
			$this->model->remove_bestanswer_summary("id='".$POST['id']."'");
			//δ���
			$item->solved("id='".$POST['tid']."'", 1);
		}

		$this->model->set_best_answer("id='".$POST['id']."'", $data);
		return $POST['id'];

	}

	/**
	 * ���Ͷ�������Ѵ���
	 * @param array &$POST ����
	 * @param array $POST['ids'] Ͷ��ID����
	 */
	function set_poller_handler(&$POST){

		$ids_arr = $data = array();
		$data['ids'] = isset($POST['ids']) ? $POST['ids'] : array();

		if(empty($data['ids'])) return array();

		$allids = $comma = '';
		foreach($data['ids'] as $id){
			if($this->check_exists_poller(array('id'=>$id))){
				$ids_arr[] = $id;
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)) return array();

		$this->model->set_poller_handler("id IN($allids)");
		return $ids_arr;

	}

	/**
	 * ��ȡ����Ĵ�ID����
	 * param array $params ����
	 * param array $params['ids'] ����ID����,��Ϊ��
	 */
	function get_allids($params = array()){

		$allids = $comma = $condition = '';
		//��������ģ��
		$item = &$this->model->system->load_module('item');
		$item_controller = &$this->core->controller($item);

		if(!empty($params['ids'])){
			foreach($params['ids'] as $id){
				if($item_controller->check_exists(array('id'=>$id))){
					$allids .= $comma . $id;
					$comma = ',';
				}
			}

			if(!empty($allids)){
				$condition = " id IN($allids)";
			}
		}

		return $this->model->get_allids($condition);

	}

	/**
	 * ���´�
	 * @param array &$POST ����
	 * @param int $POST['id'] ��ID
	 * @param int $POST['is_update_time'] �Ƿ����ʱ��
	 * @param string $POST['content'] ������
	 */
	function update(&$POST){
		global $UID;
		$data = array();
		$data['id'] = isset($POST['id']) ? intval($POST['id']) : 0;
		$data['is_update_time'] = !empty($POST['is_update_time']) ? true : false;
		$data['content'] = isset($POST['content']) ? from_utf8($POST['content']) : '';
		$data['addtime'] = P8_TIME;

		if(empty($data) 
		|| !$this->check_exists(array('id'=>$data['id'])) 
		|| !$this->check_category_action('edit', $POST['cid']) && !$this->check_exists(array('id'=>$data['id'],'uid'=>$UID))){
			return 'no_category_privilege';
		}

		return $this->model->update($data);

	}
	
	/**
	 * ɾ����
	 * @param array &$POST ����
	 * @param array $POST['ids'] ��ID����
	 */
	function delete(&$POST){

		$ids_arr = $delids_arr = array();
		$allids = $comma = '';

		if(isset($POST['id']) && $POST['id']=='clean'){
			global $IS_FOUNDER;
			if($IS_FOUNDER)return $this->model->clean();
		}
		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || !$this->valid_array($POST['ids'])){
			return array();
		}

		foreach($POST['ids'] as $id){
			if($this->check_exists(array('id'=>$id))){
				$ids_arr[] = $id;
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)){
			return array();
		}
		$T=$this->model->table;
		if(
			$this->model->delete(array(
				'where' => "$T.id IN($allids)"
			))
		){
			//ɾ����ͶƱ
			$this->model->delete_votes("aid IN($allids)");
			//ɾ����Ͷ��
			$this->model->delete_poller("aid IN($allids)");
		}

		return $ids_arr;

	}

	/**
	 * ɾ����ͶƱ
	 * @param array $params ����
	 * @param array $aid ��ID����
	 */
	function delete_votes($params = array()){

		$allids = $comma = '';

		if(empty($params) || !$this->valid_array($params) || empty($params['ids'])){
			return array();
		}

		foreach($ids as $aid){
			if($this->check_exists(array('id'=>$id))){
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)){
			return array();
		}

		return $this->model->delete_votes("aid IN($allids)");

	}

	/**
	 * ɾ����Ͷ��
	 * @param array &$POST ����
	 * @param array $POST['ids'] Ͷ��ID
	 * @return array $ids_arr ����Ͷ�ߵ�ID����
	 */
	function delete_poller(&$POST){
		
		$ids_arr = $data = array();
		$data['ids'] = isset($POST['ids']) ? $POST['ids'] : array();
		
		if(empty($data['ids'])){
			return array();
		}

		$allids = $comma = '';
		foreach($data['ids'] as $id){
			if($this->check_exists_poller(array('id'=>$id))){
				$ids_arr[] = $id;
				$allids .= $comma . $id;
				$comma = ',';
			}
		}

		if(empty($allids)) return array();

		$this->model->delete_poller("id IN($allids)");
		return $ids_arr;

	}

	/**
	 * �����Ѵ�ͶƱ���
	 * @param array &$POST ����
	 * @param int $POST['id'] ��ID
	 * @return int ���ش�ID
	 */
	function remove_votes(&$POST){

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id']))){
			return array();
		}

		$this->model->remove_votes($POST);
		return $POST['id'];

	}

	/**
	 * �ύ�����
	 * param array &$POST ����
	 */
	function post(&$POST){

		$data = array();
		//�Ƿ����������ش�
		$allow_anonymous_answer = !empty($this->model->system->CONFIG['allow_anonymous_answer']) ? true : false;
		//�ش��������ݳ���
		$answer_content_length = !empty($this->model->system->CONFIG['answer_content_length']) ? intval($this->model->system->CONFIG['answer_content_length']) : 1;

		//�����������
		$item = &$this->model->system->load_module('item');
		$item_controller = &$this->core->controller($item);

		if(empty($POST) || !$this->valid_array($POST)){
			return;
		}
		
		$data = $this->valid_post($POST);

		if(empty($data['id']) || !$item_controller->check_exists(array('id'=>$data['id']))){
			return;
		}

		if(empty($data['content']) || strlen($data['content'])>$answer_content_length){
			return;
		}else{
			$data['content'] = html_entities($data['content']);
		}

		//�Ƿ����������ش�
		if($allow_anonymous_answer){
			if(empty($data['uid'])) $data['anonymous'] = 1;
		}else{
			//�û�δ��¼���������ڵ�ǰ�û����Ѿ��ش��������ش�
			if(empty($data['uid']) || $item_controller->check_exists(array('id'=>$data['id'],'uid'=>$data['uid'])) || $this->check_exists(array('tid'=>$data['id'],'uid'=>$data['uid'])))
				return;
		}
		
		//�����Ƿ����ش�δ�����δ����
		if(!$item_controller->check_exists(
				array(
					'id' => $data['id'],
					'verify' => 1,
					'closed' => 0,
					'status' => 3,
					'status_exclude' => false,
					'endtime_exclude' => 'than'
				)
			)
		){
			return;
		}

		$this->model->post($data);
		$item->view_record('replies',$data['id']);
		$member = $this->model->system->load_module('member');
		$member_controller=$this->core->controller($member);
		$member_controller->update_count_item($data['uid'], 'add','reply', 1);
		return p8_url($item, $data, 'view');
		
	}
	
	/**
	 * ��֤�ύ����
	 * param array &$POST ����
	 * param int $data['id'] ����ID
	 * param int $data['cid'] ��������ID
	 * param int $data['anonymous'] �Ƿ������ύ
	 * param string $data['content'] �ύ����
	 * param int $data['uid'] �û�ID
	 * param string $data['username'] �û�����
	 * param int $data['verify'] �Ƿ���֤
	 * param int $data['addtime'] ʱ��
	 * param string $data['ip'] IP
	 */
	function valid_post(&$POST){

		global $UID, $USERNAME;
		
		$data = array();
		$data['id'] = !empty($POST['id']) ? intval($POST['id']) : 0;
		$data['cid'] = !empty($POST['cid']) ? intval($POST['cid']) : 0;
		$data['anonymous'] = isset($POST['anonymous']) ? 1 : 0;
		$data['content'] = !empty($POST['content']) ? $POST['content'] : '';
		$data['uid'] = $UID;
		$data['username'] = $USERNAME;
		$data['verify'] = !empty($this->model->system->CONFIG['verify_answer']) ? 0 : 1;
		$data['addtime'] = P8_TIME;
		$data['ip'] = P8_IP;

		return $data;

	}


	/**
	 * ��Ա�ύ��Ͷ����Ϣ
	 * @param array &$POST ����
	 */
	function post_poller(&$POST){
		
		$data = array();
		global $UID,$USERNAME;

		//�Ƿ���������Ͷ��
		$allow_anonymous_poller = !empty($this->model->system->CONFIG['allow_anonymous_poller']) ? true : false;
		//Ͷ�������ַ�����
		$poller_length = !empty($this->model->system->CONFIG['poller_length']) ? intval($this->model->system->CONFIG['poller_length']) : 150;		

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id'])) || empty($POST['content']) || strlen($POST['content'])>$poller_length){
			return '';
		}

		if(!$allow_anonymous_poller && empty($UID)){
			return;
		}
		
		$data['id'] = $POST['id'];
		$data['uid'] = $UID;
		$data['username'] = $USERNAME;
		$data['ip'] = P8_IP;
		$data['addtime'] = P8_TIME;
		$data['content'] = html_entities(from_utf8($POST['content']));
		if(empty($UID)){
			$data['anonymous'] = 1;
		}else{
			$data['anonymous'] = 0;
		}
			
		return $this->model->post_poller($data);
		
	}

	/**
	 * �ύ��ͶƱ
	 * @param array &$POST ����
	 * @param int $POST['id'] ��ID
	 * @param int $POST['result'] 1:֧��,0:����
	 */
	function post_votes(&$POST){

		$data = array();

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id'])) || !isset($POST['result']) || $this->check_exists_votes(array('aid'=>$POST['id'],'ip'=>P8_IP,'result'=>$POST['result']))){
			return array();
		}

		$data['aid'] = $POST['id'];
		if($POST['result']){
			$data['result'] = 1;
		}else{
			$data['result'] = 0;
		}
		
		return $this->model->post_votes($data);
		
	}

	/**
	 * �ύ׷��
	 * @param array &$POST ����
	 */
	function post_follow(&$POST)
	{
		global $UID;
		$data = $POST;

		//��������ģ��
		$item = &$this->model->system->load_module('item');

		if( 
			empty($data) || empty($UID) || 
			empty($data['tid']) || !$item->check_exists("id='".$data['tid']."' AND uid='".$UID."'") || 
			empty($data['id']) || !$this->check_exists(array('id'=>$data['id'],'tid'=>$data['tid'])) || 
			empty($data['content'])
		){
			return;
		}
		
		$data['uid'] = $UID;
		$data['aid'] = $data['id'];
		
		$acl = $this->core->load_acl('core', '', $this->core->ROLE);
		$data['content'] = p8_html_filter(p8_stripslashes(from_utf8($data['content'])), $acl['allow_tags'], $acl['disallow_tags']);
		$data['addtime'] = P8_TIME;

		return $this->model->post_follow($data);

	}

	/**
	 * �ύ��������
	 * @param array &$POST ����
	 */
	function post_reply_follow(&$POST)
	{
		global $UID;
		$data = $POST;

		if( 
			empty($data) || empty($UID) || empty($data['id']) || empty($data['content']) ||
			empty($data['aid']) || !$this->check_exists(array('id'=>$data['aid'],'uid='=>$UID))
		){
			return;
		}
		
		$data['reply_uid'] = $UID;
		$data['reply_content'] = p8_html_filter(p8_stripslashes2(from_utf8($data['content'])));
		$data['reply_time'] = P8_TIME;

		return $this->model->post_reply_follow($data);
	}	
	
	/**
	* ������Ȩ��
	**/
	function check_category_action($action, $cid = 0){
		global $IS_FOUNDER;
		if($IS_FOUNDER) return true;
		
		//���û����һ��Ȩ��
		if(!parent::check_action($action)) return false;
		
		//���ӵ�����з����Ȩ��
		if(!empty($this->category_acl[0]['actions'][$action])) return true;
		
		return !empty($this->category_acl[$cid]['actions'][$action]);
	}

}