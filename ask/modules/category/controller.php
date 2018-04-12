<?php

class P8_Ask_Category_Controller extends P8_Controller{

	function P8_Ask_Category_Controller(&$obj){
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
	 * ���������Ƿ����
	 * param array $params ����
	 * param int $params['id']:����ID
	 * param string $params['name']:��������
	 */
	function check_exists($params = array()){

		$condition = '';		

		if(empty($params) || !$this->valid_array($params)){
			return false;
		}		

		if(!empty($params['id'])) $condition = " id='".$params['id']."'";

		if(!empty($params['name'])){
			$name = html_entities($params['name']);
			$condition = !empty($condition) ? $condition." AND name='$name'" : " name='$name'";
		}

		if(empty($condition)) return false;

		return $this->model->check_exists($condition);

	}

	/**
	 * ��ӷ���
	 * param array &$POST ����
	 */
	function batch_add(&$POST){

		$this->model->get_cache();

		$data = array();

		if(!$this->valid_array($POST)){
			return '';
		}

		$POST['name'] = !empty($POST['name']) ? $POST['name'] : '';
		$data['parent'] = isset($POST['parent']) ? intval($POST['parent']) : 0;
		
		if(empty($POST['name']) || ($data['parent'] != 0 && !isset($this->model->categories[$data['parent']]))){
			return '';
		}
		
		$POST['name'] = @explode("\r\n", $POST['name']);
		$POST['name'] = array_flip(array_flip($POST['name']));

		foreach($POST['name'] as $name){
			if(!empty($name) && !$this->check_exists(array('name'=>$name))){
				$data['names'][] = html_entities($name);
			}
		}

		if(empty($data['names'])){
			return '';
		}

		return $this->model->batch_add($data);

	}

	/**
	 * ɾ������
	 * @param array $params ��������
	 * @param array $params['ids']:����ID
	 * @return array $ids ����ɾ����ID����
	 */
	function delete(&$POST){

		$ids_arr = array();
		$allids = $children_ids = '';
		
		if(empty($POST) || !$this->valid_array($POST) || !$this->valid_array($POST['ids'])){
			return array();
		}

		$this->model->get_cache(false);

		foreach($POST['ids'] as $id){
			if($this->check_exists(array('id'=>$id))){
				$_children_ids = $this->model->get_children_ids($id);
				if(!empty($_children_ids)){
					foreach($_children_ids as $childid){
						$ids_arr[] = $childid;
					}
				}
				array_unshift($ids_arr, $id);
			}
		}

		if(empty($ids_arr)){
			return array();
		}

		$comma = '';
		foreach(array_unique($ids_arr) as $id){
			$ids[] = $id;
			$allids .= $comma . $id;
			$comma = ',';
		}
		
		$this->model->delete(array(
			'where' => " id IN($allids)"
		));
		return $ids;

	}

	/**
	 * ���·�����Ŀ
	 * param array $params ����
	 * param int $params['id'] ����ID
	 * param int $params['number'] ���µ���Ŀ
	 * parms string $params['mark'] ��(-),��(+)
	 */
	function update_item_count($params = array()){

		if(empty($params) || !$this->valid_array($params) || empty($params['id']) || !$this->check_exists(array('id'=>$params['id'])) || empty($params['number']) || !in_array($params['mark'],array('-','+'))){
			return false;
		}		
		
		$data['id'] = intval($params['id']);
		$data['number'] = intval($params['number']);
		$data['mark'] = $params['mark'];

		return $this->model->update_item_count($data);
		
	}
	
	/**
	 * ���·���
	 * param int $id ����ID
	 * param array &$POST ����
	 */
	function batch_update($id, &$POST){

		if(!$this->valid_array($POST)){
			return false;
		}
		
		$data = $this->valid_data($POST);

		//��֤����ID�Ƿ���ںͲ������������Ϊ��
		if(empty($data) || empty($id) || !$this->check_exists(array('id'=>$id)) || empty($data['name'])){
			return false;
		}

		//��֤����
		$cids = $this->model->get_children_ids($id);
		if(($data['parent'] != 0 && $data['parent'] == $id) || in_array($data['parent'], $cids)){
			return false;
		}

		//���ģ�岻��Ϊ��
		if(empty($data['list_template']) || empty($data['view_template']) || empty($data['block_template'])){
			return false;
		}
		return $this->model->batch_update($id, $data);

	}

	/**
	 * ��֤�ύ����
	 * param array &$POST ����
	 */
	function valid_data(&$POST){

		$data = array();
		$data['name'] = !empty($POST['name']) ? html_entities($POST['name']) : '';
		$data['parent'] = !empty($POST['parent']) ? intval($POST['parent']) : 0;
		$data['display'] = !empty($POST['display']) ? 1 : 0;
		$data['perpage'] = !empty($POST['perpage']) && preg_match("/^[0-9]*$/",$POST['perpage']) ? $POST['perpage'] : 0;
		$data['title_bytes'] = !empty($POST['title_bytes']) && preg_match("/^[0-9]*$/",$POST['title_bytes']) ? $POST['title_bytes'] : 0;
		$data['list_template'] = !empty($POST['list_template']) ? $POST['list_template'] : '';
		$data['view_template'] = !empty($POST['view_template']) ? $POST['view_template'] : '';
		$data['block_template'] = !empty($POST['block_template']) ? $POST['block_template'] : '';
		$data['url'] = !empty($POST['url']) ? $POST['url'] : '';
		$data['keywords'] = !empty($POST['keywords']) ? $POST['keywords'] : '';
		$data['description'] = !empty($POST['description']) ? $POST['description'] : '';
		$data['announce'] = isset($POST['announce']) ? html_entities($POST['announce']) : '';

		return $data;

	}

	/**
	 * �Ƿ���ʾ����
	 * param array &$POST ����
	 * $POST['ids']:����ID����
	 */
	function set_display(&$POST){

		$condition = $allids = $comma = '';

		if(!$this->valid_array($POST) || !$this->valid_array($POST['ids'])){
			return array();
		}

		foreach($POST['ids'] as $id){
			if($this->check_exists(array('id'=>$id))){
				$allids .= $comma . $id;
				$comma = ',';
			}
		}
		$condition = !empty($allids) ? " id IN($allids) " : '';

		if(empty($condition)){
			return array();
		}

		return $this->model->set_display($condition);

	}

	/**
	 * ���·�������
	 * @param array &$POST ����
	 * @param int $data['id'] ����ID
	 * @param int $data['display_orders'] ��������
	 */
	function set_display_order(&$POST){

		$data = $POST;

		if(empty($data) || !$this->valid_array($data) || empty($data['id']) || !$this->check_exists(array('id'=>$data['id']))){
			return array();
		}
		
		if(empty($data['display_order']) || !$this->valid_numeric($data['display_order'])){
			$data['display_order'] = 0;
		}

		$this->model->set_display_order($data, "id='".$data['id']."'");
		return $data;

	}

	/**
	 * ��ȡ����������Ϣ
	 * param array $params ��������
	 * param array $params['read_cache'] �Ƿ��ȡ����
	 */
	function get_one($params = array(), $read_cache = true){

		if(empty($params) || !$this->valid_array($params) || empty($params['id']) || !$this->check_exists(array('id'=>$params['id']))){
			return array();
		}

		return $this->model->get_one($params, $read_cache);

	}

}