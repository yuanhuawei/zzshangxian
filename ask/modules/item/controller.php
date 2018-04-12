<?php

class P8_Ask_item_Controller extends P8_Controller{
	var $category_acl;
	function P8_Ask_item_Controller(&$obj){
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
	 * 检查问题是否存在
	 * param array $params 数据
	 * param int $params['id'] 问题ID
	 * param int $params['uid'] 用户ID
	 * param int $params['verify'] 1:验证,0:未验证
	 * param int $params['closed'] 1:锁定,0:未锁
	 * param int $params['status'] 问题状态,1:未解决,2:续问,3:已解决
	 * param bool $params['status_exclude'] 状态取值,true:等于(status=1),false:不等于(status!=3)
	 * param int $params['endtime'] 问题结束时间
	 * param string $params['endtime_exclude'] 时间取值,than:大于(endtime>P8_TIME),equal:等于(endtime=P8_TIME),less:小于(endtime<P8_TIME)
	 */
	function check_exists($params = array()){

		$condition = '';

		if(empty($params) || !$this->valid_array($params)){
			return false;
		}		

		if(!empty($params['id'])) $condition = "id='" . $params['id'] . "'";

		if(!empty($params['uid'])) $condition = empty($condition) ? "uid='".$params['uid']."'" : $condition." AND uid='".$params['uid']."'";

		if(isset($params['verify'])) $condition = empty($condition) ? "verify='".$params['verify']."'" : $condition." AND verify='".$params['verify']."'";

		if(isset($params['closed'])) $condition = empty($condition) ? "closed='".$params['closed']."'" : $condition." AND closed='".$params['closed']."'";

		if(isset($params['status'])){
			$status_exclude = array_key_exists('status_exclude',$params) && $params['status_exclude'] ? true : false;
			if(empty($condition)){
				$condition = $status_exclude ? "status='".$params['status']."'" : "status!='".$params['status']."'";
			}else{
				$condition = $status_exclude ? $condition." AND status='".$params['status']."'" : $condition." AND status!='".$params['status']."'";
			}
		}

		if(isset($params['endtime_exclude'])){
			if($params['endtime_exclude'] == 'than'){
				$condition = empty($condition) ? "endtime>'".P8_TIME."'" : $condition." AND endtime>'".P8_TIME."'";
			}
			elseif($params['endtime_exclude'] == 'equal'){
				$condition = empty($condition) ? "endtime='".P8_TIME."'" : $condition." AND endtime='".P8_TIME."'";
			}else{
				$condition = empty($condition) ? "endtime<'".P8_TIME."'" : $condition." AND endtime<'".P8_TIME."'";
			}
		}

		if(empty($condition)){
			return false;
		}

		return $this->model->check_exists($condition);
	}

	/**
	 * 检查收藏是否存在
	 * param array $params 数据
	 * param int $params['id'] 收藏ID
	 * param int $params['tid'] 问题ID
	 * param int $params['uid'] 用户ID
	 */
	function check_exists_favorites($params = array()){

		$condition = '';
		
		if(empty($params) || !$this->valid_array($params) || (empty($params['id']) && empty($params['tid']) && empty($params['uid']))){
			return false;
		}

		if(!empty($params['id'])) $condition = "id='".$params['id']."'";

		if(!empty($params['tid']) && $this->check_exists(array('id'=>$params['tid']))){
			$condition = empty($condition) ? "tid='" .$params['tid']."'" : $condition." AND tid='" .$params['tid']."'";
		}

		if(!empty($params['uid'])) $condition = empty($condition) ? "uid='".$params['uid']."'" : $condition." AND uid='".$params['uid']."'" ;
		
		return $this->model->check_exists_favorites($condition);
		
	}

	/**
	 * 检查问题投诉是否存在
	 * param array $params 数据
	 * param int $params['id'] 投诉ID
	 * param int $params['tid'] 问题ID
	 * param int $params['uid'] 用户ID
	 */
	function check_exists_poller($params = array()){

		$condition = '';

		if(empty($params) || !$this->valid_array($params)){
			return false;
		}

		if(!empty($params['id'])) $condition = "id='".$params['id']."'";

		if(!empty($params['tid'])) $condition = empty($condition) ? "tid='".$params['tid']."'" : $condition." AND tid='".$params['tid']."'";

		if(!empty($params['uid'])) $condition = empty($condition) ? "uid='".$params['uid']."'" : $condition." AND uid='".$params['uid']."'";

		return $this->model->check_exists_poller($condition);

	}
	
	/**
	 * 计算问题到期时间
	 * param int $endtime 问题到期时间
	 */
	function endtime($endtime){

		if(empty($endtime) || !is_numeric($endtime)){
			return array();
		}
		
		return $this->model->endtime($endtime);

	}

	/**
	 * 审核问题
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 问题ID数组
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
	 * 推荐问题
	 * params array &$POST 数据
	 * param array $POST['ids'] 问题ID数组
	 * param int $POST['recommend'] 1:推荐,0:取消推荐
	 */
	function recommend(&$POST){

		$ids_arr = array();
		$allids = $comma = '';

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || !$this->valid_array($POST['ids']) || !isset($POST['recommend']) || !in_array($POST['recommend'],array(0,1))){
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

		$this->model->recommend("id IN($allids)", $POST['recommend']);
		return $ids_arr;

	}

	/**
	 * 关闭问题
	 * 问题被关闭后不可再回答和投票等
	 * params array &$POST 数据
	 * param array $POST['ids'] 问题ID数组
	 * param int $POST['closed'] 1:关闭,0:取消关闭
	 */
	function closed(&$POST){

		$ids_arr = array();
		$allids = $comma = '';

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || !$this->valid_array($POST['ids']) || !isset($POST['closed']) || !in_array($POST['closed'],array(0,1))){
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

		$this->model->closed("id IN($allids)", $POST['closed']);
		return $ids_arr;

	}

	/**
	 * 更新问题
	 * param array &$POST 数据
	 * param int $POST['id'] 问题ID
	 * param string $POST['title'] 标题
	 * param string $POST['content'] 内容
	 * param string $POST['info'] 邮箱/QQ/MSN
	 * param string $POST['tel'] 电话
	 * param int $POST['cid'] 分类ID，不为空则更新分类
	 * param bool $POST['update_time'] 更新时间，true:更新，false:不更新
	 * param array $POST['tags'] 标签
	 */
	function update(&$POST){

		//载入分类模块
		$category = $this->model->system->load_module('category');
		$category_controller = &$this->core->controller($category);
		$category->cache(false, false);

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['id']) || !$this->check_exists(array('id'=>$POST['id']))){
			return false;
		}
		
		$data['id'] = $POST['id'];
		$data['cid'] = !empty($POST['cid']) ? intval($POST['cid']) : 0;
		$data['title'] = html_entities($POST['title']);
		$data['sub_title'] = !empty($POST['sub_title']) ? html_entities($POST['sub_title']) : '';
		$acl = $this->core->load_acl('core', '', $this->core->ROLE);
		$data['content'] = p8_html_filter($_POST['content'], $acl['allow_tags'], $acl['disallow_tags']);
		$data['info'] = !empty($POST['info']) ? html_entities($POST['info']) : '';
		$data['tel'] = !empty($POST['tel']) ? html_entities($POST['tel']) : '';
		$data['update_time'] = isset($POST['update_time']) ? true : false;
		$data['addtime'] = P8_TIME;
		$data['endtime'] = P8_TIME + intval($this->model->system->CONFIG['expired_days']) * 86400;

		if(!empty($data['cid']) && (!$category_controller->check_exists(array('id'=>$data['cid'])) || !empty($category->categories[$data['cid']]['categories']))){
			return false;
		}
		
		$tags = '';
		$data['tags'] = array();
		if(!empty($POST['tags'])){
			$tags = str_replace(array(' ', chr(0xa1).chr(0xa1),chr(0xa3).chr(0xac), chr(0xa1).chr(0x40), chr(0xa1).chr(0x41), chr(0xe3).chr(0x80).chr(0x80), chr(0xef).chr(0xbc).chr(0x8c)), ',', $POST['tags']);
			if(strpos($tags, ',')) {
				$data['tags'] = array_unique(explode(',', $tags));
			}else{
				$data['tags'][] = $tags;
			}
		}

		return $this->model->update($data);
		
	}

	/**
	 * 设置置顶问题
	 * @params &$POST 数据 
	 * @param array $POST['ids'] 问题ID数组
	 * @param int $POST['display_order'] 置顶位置,0:取消,1:当前栏目置顶,2:栏目置顶,3:总置顶
	 * @return array $ids_arr 返回置顶的问题ID数组
	 */
	function set_display_order(&$POST){

		$ids_arr = array();
		$allids = $comma = '';

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || !$this->valid_array($POST['ids']) || !isset($POST['display_order']) || !in_array($POST['display_order'],array(0,1,2,3,4))){
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

		$this->model->set_display_order("id IN($allids)", $POST['display_order']);
		return $ids_arr;

	}

	/**
	 * 标记问题投诉内容已处理
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 投诉内容ID数组
	 * @return array $ids_arr 返回投诉内容的ID数组
	 */
	function set_poller_handler(&$POST){

		$ids_arr = array();
		$allids = $comma = '';

		if(empty($POST) || !$this->valid_array($POST) || empty($POST['ids']) || !$this->valid_array($POST['ids'])){
			return array();
		}

		foreach($POST['ids'] as $id){
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
	 * 删除问题
	 * @param array &$POST 数据
	 * @param array $POST['ids'] 问题ID数组
	 */
	function delete(&$POST){

		$allids = $comma = '';
		$ids_arr = $answer_ids = array();
		
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
				$allids .= $comma.$id;
				$comma=",";
			}
		}
		if(empty($ids_arr)){
			return array();
		}
		$T=$this->model->table;
		if($this->model->delete(array(
				'where' => "$T.id IN($allids)"
			))){
			//载入答案模块
			$answer = $this->model->system->load_module('answer');
			$answer->delete(array('where'=>"$answer->table.tid IN($allids)"));
			//获取问题的答案ID数组
			//$answer_ids['ids'] = $answer_controller->get_allids(array('ids'=>$ids_arr));
			//if(!empty($answer_ids['ids'])) $answer_controller->delete($answer_ids);
			
		}
		return $ids_arr;
	}

	/**
	 * 删除问题投诉
	 * param array &$POST 数据
	 * param array $POST['ids'] 投诉ID数组
	 * return array $ids_arr 返回所有删除问题投诉的ID数组
	 */
	function delete_poller(&$POST){

		$allids = $comma = '';
		$ids_arr = array();

		if(empty($POST) || !$this->valid_array($POST)){
			return array();
		}

		if(!empty($POST['ids']) && $this->valid_array($POST['ids'])){
			foreach($POST['ids'] as $id){
				if($this->check_exists_poller(array('id'=>$id))){
					$ids_arr[] = $id;
					$allids .= $comma . $id;
					$comma = ',';
				}
			}
		}

		if(empty($allids)) return array();

		$this->model->delete_poller("id IN($allids)");
		return $ids_arr;
		
	}

	/**
	 * 会员删除提问
	 * param array $ids 问题ID数组
	 */
	function delete_myask($ids = array()){

		global $UID;

		if(empty($UID) || empty($ids) || !is_array($ids)) return array();

		return $this->model->delete_myask($ids, " AND uid='$UID'");

	}

	/**
	 * 会员删除收藏夹
	 * param array $ids 收藏ID数组
	 */
	function delete_myfavorite($ids = array()){

		global $UID;

		if(empty($UID) || empty($ids) || !is_array($ids)) return array();

		return $this->model->delete_myfavorite($ids, " AND uid='$UID'");
		
	}

	/**
	 * 会员提交问题
	 * param array &$POST 数据
	 * param int $data['cid'] 分类ID
	 * param string $data['title'] 问题标题
	 * param string $data['content'] 问题内容
	 * param int $data['offercredit'] 是否提供悬赏
	 * param int $data['credits'] 悬赏积分
	 * param int $data['urgent'] 是否为紧急
	 * param int $data['anonymous'] 是否匿名提交
	 * param int $data['verify'] 默认是否审核
	 * param string $data['info'] 邮箱/QQ/MSN
	 * param string $data['tel'] 电话
	 * param array $data['tags'] 标签
	 */
	function post(&$POST){

		global $this_router;

		$title_length = empty($this->model->system->CONFIG['title_length']) ? 5 : intval($this->model->system->CONFIG['title_length']);

		if(empty($POST) || !$this->valid_array($POST)){
			return false;
		}

		$data = $this->valid_post($POST);

		//载入分类模块
		$category = $this->model->system->load_module('category');
		$category_controller = $this->core->controller($category);
		$category->get_cache(true);	
		
		$member = $this->model->system->load_module('member');
		$member_controller=$this->core->controller($member);
		if(
			empty($data['title']) || 
			strlen($data['title'])<5 || 
			strlen($data['title'])>80 || 
			empty($data['content']) || 
			empty($category->categories[$data['cid']]) || 
			!empty($category->categories[$data['cid']]['categories'])
		){
			return false;
		}	
		$insert_id = $this->model->post($data);
		
		if($insert_id){
			//更新分类条目
			$category_controller->update_item_count(
					array(
						'id'=>$data['cid'],
						'number'=>1,
						'mark'=>'+'
					)
				);
			//更新统计数据	
			$this->model->set_statistics(
			array(
				'field'=>'item_count',
				'mark' => '+',
				'number' =>1
				)
			);
			if($data['verify']){
				$mkey = 'ask_success_post';
				$url = $this_router . '-view-id-' . $insert_id;
			}else{
				$mkey = 'ask_success_post_verify';
				$url = $this->model->system->controller;
			}
			
			$member_controller->update_count_item($data['uid'], 'add','item', 1);
			message($mkey, $url, 3);
		}

		return $insert_id;

	}

	/**
	 * 验证提交问题数据
	 * param array &$POST 提交数据
	 * param array $data 返回数据
	 */
	function valid_post(&$POST){

		global $UID, $USERNAME,$IS_ADMIN;

		$data = $tags = array();
		
		$data['uid'] = $UID;
		$data['username'] = $USERNAME;
		$data['cid'] = isset($POST['cid']) && $this->valid_numeric($POST['cid']) ? intval($POST['cid']) : 0;
		$data['title'] = !empty($POST['title']) ? html_entities($POST['title']) : '';
		$acl = $this->core->load_acl('core', '', $this->core->ROLE);
		$data['content'] = !empty($POST['content']) ? p8_html_filter(stripslashes($POST['content']), $acl['allow_tags'], $acl['disallow_tags']) : '';
		$data['offercredit'] = !empty($POST['offercredit']) ? 1 : 0;
		$data['credits'] = $data['offercredit'] && !empty($POST['credits']) ? intval($POST['credits']) : 0;
		$data['urgent'] = !empty($POST['urgent']) ? 1 : 0;
		$data['anonymous'] = !empty($POST['anonymous']) ? 1 : 0;
		$data['info'] = !empty($POST['info']) ? html_entities($POST['info']) : '';
		$data['tel'] = !empty($POST['tel']) ? html_entities($POST['tel']) : '';
		$data['to_uid'] = !empty($POST['to_uid']) ? html_entities($POST['to_uid']) : '';
		$data['verify'] = !empty($this->model->system->CONFIG['verify']) ? 0 : 1;
		$IS_ADMIN && $data['verify'] = 1;
		//标签
		$POST['tags'] = !empty($POST['tags']) ? $POST['tags'] : '';
		if(!empty($POST['tags'])){		
			$tags = str_replace(array(' ', chr(0xa1).chr(0xa1),chr(0xa3).chr(0xac), chr(0xa1).chr(0x40), chr(0xa1).chr(0x41), chr(0xe3).chr(0x80).chr(0x80), chr(0xef).chr(0xbc).chr(0x8c)), ',', $POST['tags']);
			if(strpos($tags, ',')) {
				$tags = array_unique(explode(',', $tags));
			}
		}
		$data['tags']  = $tags;
		$data['keywords']  = sizeof($tags)?implode(",",$tags):'';
		//到期时间戳
		$data['endtime'] = P8_TIME + intval($this->model->system->CONFIG['expired_days']) * 86400;
		$data['anonymous'] = empty($UID) ? 1 : 0;
		$data['addtime'] = P8_TIME;
		$data['lastpost'] = P8_TIME;
		$data['ip'] = P8_IP;
		

		return $data;
	}

	/**
	 * 会员更新问题
	 * @param array &$POST 数据
	 */
	function post_edit(&$POST){
		
		$data = $this->valid_post_edit($POST);
		
		if(!$this->check_exists(array('id'=>$data['id']))) return false;

		return $this->model->post_edit($data);

	}

	/**
	 * 验证修改问题
	 * @param array &$POST 提交数据
	 * @param array $data 返回数据
	 */
	function valid_post_edit(&$POST){

		global $UID;
		$data = $tags = array();
		
		
		$data['id'] = isset($POST['id']) ? intval($POST['id']) : 0;
		$data['cid'] = isset($POST['cid']) ? intval($POST['cid']) : 0;
		$data['title'] = !empty($POST['title']) ? html_entities($POST['title']) : '';
		$acl = $this->core->load_acl('core', '', $this->core->ROLE);
		$data['content'] = !empty($POST['content']) ? p8_html_filter(stripslashes($POST['content']), $acl['allow_tags'], $acl['disallow_tags']) : '';
		$data['offercredit'] = !empty($POST['offercredit']) ? 1 : 0;
		$data['credits'] = $data['offercredit'] && !empty($POST['credits']) ? intval($POST['credits']) : 0;
		$data['urgent'] = !empty($POST['urgent']) ? 1 : 0;
		$data['anonymous'] = !empty($POST['anonymous']) ? 1 : 0;
		$data['info'] = !empty($POST['info']) ? html_entities($POST['info']) : '';
		$data['tel'] = !empty($POST['tel']) ? html_entities($POST['tel']) : '';
		//标签
		$POST['tags'] = !empty($POST['tags']) ? $POST['tags'] : '';
		if(!empty($POST['tags'])){		
			$tags = str_replace(array(' ', chr(0xa1).chr(0xa1),chr(0xa3).chr(0xac), chr(0xa1).chr(0x40), chr(0xa1).chr(0x41), chr(0xe3).chr(0x80).chr(0x80), chr(0xef).chr(0xbc).chr(0x8c)), ',', $POST['tags']);
			if(strpos($tags, ',')) {
				$tags = array_unique(explode(',', $tags));
			}
		}
		$data['tags']  = $tags;

		return $data;
	}
	
	/**
	 * 提交补充提问
	 * param array &$POST 数据
	 * param int $data['tid'] 所属问题ID
	 * param string $data['content'] 补充问题内容
	 */
	function post_addition(&$POST){
		
		global $UID;
		$data = $POST;

		$addition_length = !empty($this->model->system->CONFIG['addition_length']) ? intval($this->model->system->CONFIG['addition_length']) : 200;

		if(empty($UID) || empty($data) || !$this->valid_array($data)){
			return array();
		}

		if(empty($data['tid']) || !$this->check_exists(array('id'=>$data['tid'],'uid'=>$UID))){
			return array();
		}

		$data['content'] = from_utf8($data['content']);
		if(empty($data['content']) || strlen($data['content']) > $addition_length){
			return;
		}

		$data['uid'] = $UID;
		$data['addtime'] = P8_TIME;
		$data['content'] = html_entities($data['content']);

		return $this->model->post_addition($data);
		
	}
	
	/**
	 * 提交问题投诉
	 * param array &$POST 数据
	 * param int $POST['tid'] 问题ID
	 * param int $POST['anonymous'] 是否匿名,1:匿名,0:非匿名
	 * param string $POST['content'] 投诉内容
	 */
	function post_poller(&$POST){

		global $UID, $USERNAME;

		$data = array();
		$allow_anonymous_poller = !empty($this->model->system->CONFIG['allow_anonymous_poller']) ? true : false;
		$poller_length = !empty($this->model->system->CONFIG['poller_length']) ? intval($this->model->system->CONFIG['poller_length']) : 150;

		if(empty($POST) || !$this->valid_array($POST)){
			return;
		}

		$data = $POST;

		if(empty($data['tid']) || !$this->check_exists(array('id'=>$data['tid']))){
			return;
		}

		//不允许匿名投诉
		if(!$allow_anonymous_poller && empty($UID)){
			return;
		}

		//不允许投诉自己的问题
		if(!empty($UID) && $this->check_exists(array('id'=>$data['tid'], 'uid'=>$UID))){
			return;
		}

		//投诉内容不允许为空
		if(empty($data['content']) || strlen($data['content']) > $poller_length){
			return;
		}

		$data['uid'] = $UID;
		$data['username'] = $USERNAME;
		$data['anonymous'] = empty($UID) ? 1 : 0;
		$data['ip'] = P8_IP;
		$data['addtime'] = P8_TIME;
		$data['content'] = html_entities(from_utf8($data['content']));

		return $this->model->post_poller($data);

	}
	
	/**
	 * 收藏问题
	 * param array &$POST 数据
	 * param int $id 问题ID
	 */
	function collection(&$POST){

		global $UID;
			$member = $this->model->system->load_module('member');
			$member_controller=$this->core->controller($member);
		$data = $POST;

		if(empty($UID) || empty($data) || !$this->valid_array($data)){
			return;
		}

		if(empty($data['id']) || !$this->check_exists(array('id'=>$data['id']))){
			return;
		}

		if($this->check_exists_favorites(array('tid'=>$data['id'],'uid'=>$UID))){
			return 'exists';
		}
		
		$data['uid'] = $UID;
		$data['addtime'] = P8_TIME;

		 $statu=$this->model->collection($data);
		 if($statu){//增加会员收藏记录
			
			$member_controller->update_count_item($data['uid'], 'add','fav', 1);
			
		 }
		 return $statu;
	}

	/**
	 * 补充问题列表
	 * param array $params 数据
	 * param int $params['id'] 所属问题ID
	 */
	function get_addition($params = array()){

		global $UID;

		if(empty($params) || !$this->valid_array($params)){
			return array();
		}

		if(empty($params['id']) || !$this->check_exists(array('id'=>$params['id']))){
			return array();
		}

		return $this->model->get_addition("tid='".$params['id']."'");
		
	}

	/**
	 * 获取置顶问题
	 * param array $params 数据
	 * params int $params['cid'] 当前分类ID
	 * param array $params['categories'] 分类ID数组
	 */
	function get_displayorder_items($params = array()){

		$data = array();

		//载入分类模块
		$category = &$this->model->system->load_module('category');
		$category->get_cache(true);

		if(empty($params) || !$this->valid_array($params)){
			return array();
		}

		if(empty($params['cid']) || empty($category->categories[$params['cid']])){
			return array();
		}

		$data['cid'] = $params['cid'];
		
		if(!empty($params['categories']) && $this->valid_array($params['categories'])){
			foreach($params['categories'] as $cid){
				if(!empty($category->categories[$cid])) $data['categories'][] = $cid;
			}
		}

		return $this->model->get_displayorder_items($data);

	}

	/**
	 * 取得问题标签(TAG)
	 * @param array $params 数据
	 * @param int $params['id'] 问题ID
	 */
	function get_itemtags($params = array()){

		$condition = '';

		if(empty($params) || !$this->valid_array($params)){
			return '';
		}

		if(!empty($params['id'])) $condition = "id='".intval($params['id'])."'";

		if(empty($condition)) return '';

		return $this->model->get_itemtags($condition);

	}

	/**
	 * 取问题标签信息
	 * param int $num 标签数目
	 */
	function get_alltags($num = 20){

		return $this->model->get_tags($num);

	}
	
	function maketemplate($list='',$view='',$block=''){
		$list=empty($list)? 'list/list' : 'list/'.$list;
		$view=empty($view)? 'view/view' : 'view/'.$view;
		$block=empty($block)? 'category_block/default' : 'category_block/'.$block;
		return array($list,$view,$block);
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
	
	function get_category_acl($action, $cids){
		foreach ($cids as $key => $cid){
			if(!$this->check_category_action($action,$cid))unset($cids[$key]);
		}
		return $cids;
	}

}