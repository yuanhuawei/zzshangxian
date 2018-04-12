<?php

class P8_Ask_answer_Controller extends P8_Controller{
		var $category_acl;
	function P8_Ask_answer_Controller(&$obj){
		parent::__construct($obj);
		
	}

	function _init(){
	//获取基于分类的权限控制表
		$this->category_acl = $this->get_acl('category_acl');
	}
	/**
	 * 验证是否为数组
	 * param array &$POST 数据
	 */
	function valid_array(&$params){
		
		if(empty($params) || !is_array($params)){
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
	 * 检查答案是否存在
	 * param array $params 数据
	 * param int $params['id'] 答案ID,可为空
	 * param int $params['tid'] 问题ID,可为空
	 * param int $params['uid'] 用户ID,可为空
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
	 * 检查投诉是否存在
	 * @param array $params 数据
	 * @param int $params['id'] 投诉ID
	 * @param int $params['aid'] 答案ID
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
	 * 检查答案投票是否存在
	 * @param array $params 数据
	 * @param int $params['aid'] 答案ID
	 * @param int $params['result'] 结果,1:支持,0:反对
	 * @param int $params['uid'] 用户ID
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
	 * 审核答案
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 答案ID数组
	 * @param int $POST['verify'] 1:通过审核,0:锁定
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
	 * 设置最佳答案
	 * @param array &$POST 数据
	 * @param int $executor 指定最佳答案的用户身份,1:用户本身,2:栏目管理员,3:管理员
	 */
	function set_best_answer(&$POST){

		global $UID;
		$data = array();

		if(empty($UID) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id'])) || !isset($POST['bestanswer']) || !in_array($POST['bestanswer'],array(0,1))){
			return array();
		}

		$data['bestanswer'] = $POST['bestanswer'];	
	//载入问题模块		
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
			//己解决
			$item->solved("id='".$POST['tid']."'", 3);
		}else{
			$data['executor'] = 0;
			$this->model->remove_bestanswer_summary("id='".$POST['id']."'");
			//未解决
			$item->solved("id='".$POST['tid']."'", 1);
		}

		$this->model->set_best_answer("id='".$POST['id']."'", $data);
		return $POST['id'];

	}

	/**
	 * 标记投诉内容已处理
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 投诉ID数组
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
	 * 获取问题的答案ID数组
	 * param array $params 数据
	 * param array $params['ids'] 问题ID数组,可为空
	 */
	function get_allids($params = array()){

		$allids = $comma = $condition = '';
		//载入问题模块
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
	 * 更新答案
	 * @param array &$POST 数据
	 * @param int $POST['id'] 答案ID
	 * @param int $POST['is_update_time'] 是否更新时间
	 * @param string $POST['content'] 答案内容
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
	 * 删除答案
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 答案ID数组
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
			//删除答案投票
			$this->model->delete_votes("aid IN($allids)");
			//删除答案投诉
			$this->model->delete_poller("aid IN($allids)");
		}

		return $ids_arr;

	}

	/**
	 * 删除答案投票
	 * @param array $params 数据
	 * @param array $aid 答案ID数组
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
	 * 删除答案投诉
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 投诉ID
	 * @return array $ids_arr 返回投诉的ID数组
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
	 * 清空最佳答案投票结果
	 * @param array &$POST 数据
	 * @param int $POST['id'] 答案ID
	 * @return int 返回答案ID
	 */
	function remove_votes(&$POST){

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id']))){
			return array();
		}

		$this->model->remove_votes($POST);
		return $POST['id'];

	}

	/**
	 * 提交问题答案
	 * param array &$POST 数据
	 */
	function post(&$POST){

		$data = array();
		//是否允许匿名回答
		$allow_anonymous_answer = !empty($this->model->system->CONFIG['allow_anonymous_answer']) ? true : false;
		//回答问题内容长度
		$answer_content_length = !empty($this->model->system->CONFIG['answer_content_length']) ? intval($this->model->system->CONFIG['answer_content_length']) : 1;

		//载入问题分类
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

		//是否允许匿名回答
		if($allow_anonymous_answer){
			if(empty($data['uid'])) $data['anonymous'] = 1;
		}else{
			//用户未登录、问题属于当前用户和已经回答过不充许回答
			if(empty($data['uid']) || $item_controller->check_exists(array('id'=>$data['id'],'uid'=>$data['uid'])) || $this->check_exists(array('tid'=>$data['id'],'uid'=>$data['uid'])))
				return;
		}
		
		//问题是否充许回答，未解决和未过期
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
	 * 验证提交问题
	 * param array &$POST 数据
	 * param int $data['id'] 问题ID
	 * param int $data['cid'] 所属分类ID
	 * param int $data['anonymous'] 是否匿名提交
	 * param string $data['content'] 提交内容
	 * param int $data['uid'] 用户ID
	 * param string $data['username'] 用户名称
	 * param int $data['verify'] 是否验证
	 * param int $data['addtime'] 时间
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
	 * 会员提交答案投诉信息
	 * @param array &$POST 数据
	 */
	function post_poller(&$POST){
		
		$data = array();
		global $UID,$USERNAME;

		//是否允许匿名投诉
		$allow_anonymous_poller = !empty($this->model->system->CONFIG['allow_anonymous_poller']) ? true : false;
		//投诉内容字符长度
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
	 * 提交答案投票
	 * @param array &$POST 数据
	 * @param int $POST['id'] 答案ID
	 * @param int $POST['result'] 1:支持,0:反对
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
	 * 提交追问
	 * @param array &$POST 数据
	 */
	function post_follow(&$POST)
	{
		global $UID;
		$data = $POST;

		//载入问题模块
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
	 * 提交补充提问
	 * @param array &$POST 数据
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
	* 检查分类权限
	**/
	function check_category_action($action, $cid = 0){
		global $IS_FOUNDER;
		if($IS_FOUNDER) return true;
		
		//如果没有上一级权限
		if(!parent::check_action($action)) return false;
		
		//如果拥有所有分类的权限
		if(!empty($this->category_acl[0]['actions'][$action])) return true;
		
		return !empty($this->category_acl[$cid]['actions'][$action]);
	}

}