<?php

class P8_Ask_Member_Controller extends P8_Controller{
	
	var $category_acl;
	
	function P8_Ask_Member_Controller(&$obj){
		parent::__construct($obj);
		
	}

	/**
	 * 验证是否为数组
	 * param array &$POST 数据
	 */
	function valid_array(&$POST){
		
		if(empty($POST) || !is_array($POST)){
			return false;
		}else{
			return true;
		}

	}

	/** 
	 * 验证是否为数字型
	 * param int $params 传值
	 */
	function valid_numeric($params){

		if(empty($params) || !preg_match("/^[0-9]*$/", $params)){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * 检查用户是否存在
	 * param array $params 数据数组
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
	 * 检查专家用户是否存在
	 * param array $params 数据数组
	 * param int $params['id'] 专家表ID
	 * param int $params['uid'] 用户ID
	 * param int $params['cid'] 分类ID
	 */
	function check_exists_expertor($params = array()){

		$condition = '';

		//载入分类模块
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
	 * 审核用户
	 * param array &$POST 数据
	 * return array $data 返回用户审核信息
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
	 * 设置问答之星
	 * param array &$POST 数据
	 * return array $data 返回用户信息
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
	 * 设置专家用户
	 * param array &$POST 数据
	 * param array $POST['ids'] 用户ID集
	 * param array $POST['cids'] 分类ID集
	 */
	function set_expertor(&$POST){

		$data = $uids_arr = array();

		//载入分类模块
		$category = $this->model->system->load_module('category');
		$category_controller = $this->core->controller($category);		
		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || empty($POST['cids'])){
		return array();
		}

		//选取了多个用户
		if(strpos($POST['ids'], ',')){
			$uids_arr = @explode(',', $POST['ids']);
			foreach($uids_arr as $uid){
				if($this->check_exists(array('id'=>$uid))){
					$data['uids'][] = $uid;
				}
			}

		}
		//选取单个用户
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
	 * 删除专家
	 * param array &$POST post提交的数据
	 * param array $params 相关参数
	 * param array $POST['uids'] 用户ID
	 * param array $params['cids'] 分类ID
	 */
	function delete_expertor($params = array()){

		$conditon = $allids = $alluids = $comma = '';

		if(empty($params) || !$this->valid_array($params)){
			return array();
		}

		//用户ID
		if(!empty($params['uids'])){
			foreach($params['uids'] as $uid){
				if($this->check_exists(array('id'=>$uid))){
					$alluids .= $comma . $uid;
					$comma = ',';
				}
			}

			if(!empty($alluids)) $condition = "uid IN($alluids)";
		}

		//专家表ID
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

		//分类ID
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
	 * 更新会员主题收藏数
	 * param int $uid 用户ID
	 * param string $method 增或减(add,cut) 
	 * param int $number 更新数目
	 */
	function update_count_favorites($uid = 0, $method = 'add', $number = 1){

		if(empty($uid) || !is_numeric($uid) || !in_array($method, array('add','cut')) || !is_numeric($number)){
			return array();
		}

		return $this->model->update_count_favorites($uid, $method, $number);

	}
	/**
	 * 更新会员主题数
	 * param int $uid 用户ID
	 * param string $method 增或减(add,cut) 
	 * param int $number 更新数目
	 */
	function update_count_item($uid = 0, $method = 'add',$filter='', $number = 1){
	$filters = array('item','solve_item','reply','fav');
		if(empty($uid) || !is_numeric($uid) || !in_array($method, array('add','cut')) || !is_numeric($number) || !in_array($filter,$filters)){
			return array();
		}
		return $this->model->update_count_item($uid, $method,$filter.'_count', $number);

	}
	/**
	 * 获取专家用户分类
	 * param array $params 数据
	 * param int $params['id'] 用户ID
	 * param bool $read_cache 是否读取分类缓存
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