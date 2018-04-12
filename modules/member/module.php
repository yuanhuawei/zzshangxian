<?php
defined('PHP168_PATH') or die();

class P8_Member extends P8_Module{

var $table;						//��Ա��
var $friend_table;				//���ѱ�
var $unverified_friend_table;	//���ѱ�
var $friend_category_table;		//���ѷ����
var $getpasswd_table;			//��Ա��֤��״̬��
var $acl_table;					//��ԱȨ�ޱ�
var $models;
var $delimiter;
var $col_delimiter;
var $addon_table;
var $role_gid;
var $role_id;
var $status;
var $username_reg;
var $last_cache;		//���һ�θ���Ȩ�޻����ʱ���

function __construct($system, $name){
	$this->system = &$system;
	parent::__construct($name);

	$this->table = $this->core->TABLE_ .'member';
	$this->getpasswd_table = $this->TABLE_ .'getpasswd';
	$this->friend_table = $this->TABLE_ .'friend';
	$this->unverified_friend_table = $this->TABLE_ .'friend_unverified';
	$this->friend_category_table = $this->TABLE_ .'friend_category';
	$this->acl_table = $this->TABLE_ .'acl';
	$this->username_reg = '[#@%<>&,\$\(\)\*"\'\s\\\\]';
	$this->last_cache = '@'. $this->core->CONFIG['last_user_acl_cache'];
	
	$this->delimiter = chr(7);
	$this->col_delimiter = chr(6);
	
	$this->models = array();
	$this->status = array(
		0 => 0,
		1 => 1,
		2 => 2,
	);
}

function P8_Member(&$system, $name){
	$this->__construct($system, $name);
}

function set_model($role_gid){
	$this->role_gid = $role_gid;
	$this->addon_table = $this->core->TABLE_ .'role_group_'. $role_gid .'_data';
}

function &get_model($role_gid){
	global $CACHE;
	$this->models[$role_gid] = $CACHE->read('core/modules', 'role', 'group_'. $role_gid, 'serialize');
	return $this->models[$role_gid];
}

function format_data(&$data){
	foreach($this->models[$this->role_gid]['fields'] as $field => $v){
		
		if(!isset($data[$field])) continue;
		
		switch($v['widget']){
		
		//�ָ��ѡ��
		case 'checkbox':
		case 'multi_select':
			$data[$field] = explode($this->delimiter, $data[$field]);
		break;
		
		//�ϴ���,�༭��Ҫ�Ը�����ַ����
		case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
			$data[$field] = attachment_url($data[$field]);
		break;
		
		case 'uploader':
			$tmp = explode($this->delimiter, attachment_url($data[$field]));
			$data[$field] = array(
				'title' => $tmp[0],
				'url' => isset($tmp[1]) ? $tmp[1] : ''
			);
		break;
		
		//���ϴ���
		case 'multi_uploader':
			$tmp = explode($this->delimiter, attachment_url($data[$field]));
			
			$data[$field] = array();
			foreach($tmp as $v){
				$v = explode($this->col_delimiter, $v);
				$data[$field][] = array(
					'title' => $v[0],
					'url' => isset($v[1]) ? $v[1] : ''
				);
			}
			unset($tmp);
		break;
		}
	}
}

/**
 * �û�ע��
 * @param string $username �û���
 * @param string $password ����
 * @param array $datas ��������
 * @return int
 * >0 ���ص��û�ID
 * -1 �û������Ϸ�
 * -2 �û���������
 * -3 email���Ϸ�
 * -4 email��ע��
 **/
function register($username, $password, $email, $datas = array()){
	return include $this->path .'call/register.call.php';
}

/**
 * ��Ա��¼
 * @param string $username �û���
 * @param string $password ����
 * @param int $id �û�ID,ΪAPI���Ľӿ�,ע��,����$id����ֱ�ӵ�¼
 * @param bool $test ֻ����û����������Ƿ���ȷ,�����е�¼�Ĳ���
 * @return array('status' => ��¼״̬, 'id' => ��ԱID, 'message' => ��Ϣ) 
 * 0	��¼�ɹ�
 * -1	�û���������
 * -2	�������
 **/
function login($username, $password, $id = 0, $test = false, $type = 'username'){
	
	$ret = array(
		'status' => 0,
		'id' => 0,
		'useranme' => '',
		'email' => '',
		'message' => '',
	);
	
	if(
		$type == 'username' && empty($this->CONFIG['administrators'][$username]) && //����Ա��������Ӱ��
		($inte = &$this->core->integrate()) && empty($id)
	){
		//��վ�����ϵ�¼

		$odata = $inte->login($username, $password);

		if($odata['id'] > 0){	//��¼�ɹ���
			$data = get_member($username);
			
			if(empty($data)){	//��ϵͳû���û�
				$data = array('id' => $odata['id']);

				$data['role_id'] = $this->core->CONFIG['member_role'];
				//ֱ���ڱ�ϵͳע��
				$this->register($odata['username'], $odata['password'], $odata['email'], $data);
			}elseif($data['status']!=0){
				$this->logout();
				$ret['status'] = $data['status'];
				return $ret;
			}
			
			$data['username'] = $username;
			
			if(!$test) $this->_login($data, $password);
			
			$ret['status'] = 0;
			$ret['id'] = $odata['id'];
			$ret['username'] = $odata['username'];
			$ret['email'] = $odata['email'];
			$ret['message'] = $this->sync_session() . $odata['message'];
			
			return $ret;
		}
		//�������

	}else{
		//{������
		$data = get_member($username, false, $type);

		//�û�������
		if(empty($data)){
			$this->logout();
			$ret['status'] = -1;
			return $ret;
		}elseif($data['status']!=0){
			$this->logout();
			$ret['status'] = $data['status'];
			return $ret;	
		}

		$ret['id'] = $data['id'];
		$ret['username'] = $data['username'];
		$ret['email'] = $data['email'];
		$flag = false;

		if($data['password'] == md5(md5($password) . $data['salt'])){
			//��¼�ɹ�
			$flag = true;
		}elseif($data['password'] == md5($password . $data['salt'])){//����֮ǰ��
			//��¼�ɹ�
			$flag = true;
		}else if($id == $data['id'] && $username == $data['username']){
			//�����$id����,�û���Ҳ��ͬ,�������ϵ�API
			$flag = true;
		}
		
		/*
		if(!$flag && md5(md5($password . $data['dz_salt'])) == $data['password']){
			$flag = true;
		}
		*/
		
		if($flag){
			if(!$test) $this->_login($data, $password);
			
			$ret['message'] = $this->sync_session() . $ret['message'];
			
			return $ret;
		}
		//}
	}

	$this->logout();
	//�������
	$ret['status'] = -2;
	return $ret;
}

/**
 * ���óɹ���¼��SESSION��cookie
 **/
function _login(&$data, $password){
	global $P8SESSION, $_P8SESSION;

	$P8SESSION['uid'] = $data['id'];
	$P8SESSION['username'] = $data['username'];
	$_P8SESSION['is_founder'] = empty($data['is_founder']) ? 0 : 1;
	$_P8SESSION['role@system'] = array('core' => $data['role_id']);
	$_P8SESSION['status'] = $data['status'];
	//��ո�ϵͳ�Ľ�ɫ

	//Ӧ�û��ֹ���
	$credit = &$this->core->load_module('credit');
	$credit->apply_rule($this, 'login', $data['id'], $data['role_id']);
	
	set_cookie('UID', $data['id']);
	set_cookie('USERNAME', jsonencode($data['username']));
	set_cookie('ROLE', $data['role_id']);
	
	$_P8SESSION['is_admin'] = $data['is_admin'];
	$_P8SESSION['role_gid'] = $data['role_gid'];
	
	if($_P8SESSION['is_admin']) set_cookie('IS_ADMIN', 1);
	
	if(!empty($_POST['remember_me'])){
		set_cookie('LOGIN', p8_code(md5_16(USER_AGENT) ."\t". $data['username'] ."\t". $password), 31536000);
	}
	delete_session('uid = '.$data['id'].' and id<>\''.SESSION_ID.'\'');

	//���µ�¼ʱ��,����,IP
	$this->DB_master->update(
		$this->table,
		array(
			'last_login' => P8_TIME,
			'login_time' => 'login_time +1',
			'last_login_ip' => '\''. P8_IP .'\''
		),
		"id = '$data[id]'",
		false
	);
}

/**
* ����ͬ��SESSION
**/
function sync_session(){
	
	$js = '';
	if(!empty($this->core->CONFIG['session_cross_domains'])){
		//ÿ�������ĸ�Ŀ¼�±���Ҫ��sync_session.php
		
		foreach($this->core->CONFIG['session_cross_domains'] as $k => $v)
			$js .= '<script type="text/javascript" src="'. $v .'?SESSION_ID='. SESSION_ID .'&domain='. urlencode($k) .'"></script>';
	}
	
	return $js;
}


/**
* �˳�
* @param bool $fromapi �Ƿ��API����
**/
function logout($fromapi = false){
	global $P8SESSION, $_P8SESSION;
	//�����˳�
	$message = '';
	if(!$fromapi && ($inte = &$this->core->integrate())){
		
		$message = $inte->logout();
	}

	$P8SESSION['uid'] = 0;
	$_P8SESSION['is_admin'] = 0;
	$_P8SESSION['role@system'] = array('core' => $this->core->CONFIG['guest_role']);
	$P8SESSION['username'] = '';
	unset($_P8SESSION['#admin_login#']);

	set_cookie('UID', '', -1);
	set_cookie('USERNAME', '', -1);
	set_cookie('IS_ADMIN', '', -1);
	set_cookie('LOGIN', '', -1);
	
	return array(
		'status' => 1, 
		'message' => $message
	);
}

function delete($data, $from_api = false){
	return include $this->path .'call/delete.call.php';
}

/**
* �޸�����
* @param string $username �û���
* @param string $new ������
* @param bool $from_api �Ƿ��API��������
**/
function change_password($username, $new, $old = '', $from_api = false){
	return include $this->path .'call/change_password.call.php';
}

function update($id, &$data, &$orig_data){
	return include $this->path .'call/update.call.php';
}

/**
*ע�ᷢ��֪ͨ
**/
function send_register($data, $uid, $_password){
	if($this->CONFIG['register']['verify']==1){
		global $P8LANG;
		$title = p8lang($P8LANG['register_mail_title'],$this->core->CONFIG['site_name']);
		$content = p8lang($P8LANG['register_mail_content'],$data['username'],$this->controller.'-active?id='.$uid.'&salt='.$data['salt'],$this->core->CONFIG['site_name']);
		$email = $this->core->load_module('mail');
			$email->set(array(
				'subject' => $title,
				'message' => nl2br($content),
				'send_to' => $data['email']
			));
			$email->send();
	}else
	if(!$this->CONFIG['register']['verify']){
		if($this->CONFIG['register']['message'] || $this->CONFIG['register']['email'] || $this->CONFIG['register']['sms']){
			$title = str_replace(array('{username}', '{sitename}'),array($data['username'],$this->core->CONFIG['site_name']),$this->CONFIG['register']['title']);
			$content = str_replace( array('{username}', '{sitename}','{password}', '{time}','{adminemail}'),
									array($data['username'], $this->core->CONFIG['site_name'], $_password, date('Y-m-d H:i',P8_TIME),$this->core->CONFIG['admin_email']),
									$this->CONFIG['register']['notice']
									);
		}
		if($this->CONFIG['register']['message']){
			$message = $this->system->load_module('message');
			$msg = array(
				'uid' => $uid,
				'title' => $title,
				'content' => nl2br($content)
			);
			$status = $message->send($msg);
		}
		if($this->CONFIG['register']['email']){
			$email = $this->core->load_module('mail');
			$email->set(array(
				'subject' => $title,
				'message' => nl2br($content),
				'send_to' => $data['email']
			));
			$email->send();
		}
		if($this->CONFIG['register']['sms'] && $data['cell_phone']){
			$sms = $this->core->load_module('sms');
			$content = str_replace(array("\t"), '', strip_tags($content));
			$sms->send(
				$data['cell_phone'],
				$content
			);
		}
	}
}

/**
 * ���û�Ա��ɫ
 **/
function set_role($id, $role_id){
	
	if(
		$this->DB_master->update(
			$this->table,
			array(
				'last_role_id' => 'role_id',
				'role_id' => $role_id
			),
			"id = '$id'",
			false
		)
	){
		foreach($this->core->systems as $sys => $v){
			//�޸ĸ�ϵͳ�Ľ�ɫ
			$_system = get_system($sys);
			if(!$_system['installed']) continue;
			
			$this->DB_master->update(
				$_system['table_prefix'] .'member',
				array('role_id' => $role_id),
				"id = '$id'"
			);
		}
		
		/*
			$config = $this->core->get_config();
			$config['administrators'] = isset($config['administrators']) ? $config['administrators'] : array();
			$config['administrators'][$username] = 1;
			$this->set_config(array('administrators' => $config['administrators']));
		}*/
		
		delete_session("uid = '$id'");
	}
	
	$this->core->get_cache('role');
	if($this->core->roles[$role_id]['gid'] == $this->core->CONFIG['administrator_role_group']){
		$this->cache();
	}
}

/**
 * ��֤����
 * @param string $q �����,���Ϊfalseʱ����һ������,�����Ϊfalseʱ��֤����
 * @param bool $test ��������Ƿ���ȷ,���Ϊtrue,��ô�����SESSION,����AJAX����
 * @return string|bool �������ʱ����bool,��������ʱ����string
 **/
function verify_question($q = false, $test = false){
	global $_P8SESSION;

	if($q === false){
		//Ĭ�ϲ���ʱ,����һ������,��д��SESSION
		$qid = array_rand($this->CONFIG['verify_question']);
		$_P8SESSION['verify_question_id'] = $qid;

		return $this->CONFIG['verify_question'][$qid]['question'];

	}else{
		//��֤����
		$ret = true;
		if(!isset($_P8SESSION['verify_question_id'])) return false;

		if($this->CONFIG['verify_question'][$_P8SESSION['verify_question_id']]['answer'] != $q) $ret = false;

		if(!$test) unset($_P8SESSION['verify_question_id']);

		return $ret;
	}
}

function recharge_by_card($sn){
	$sn = preg_replace('/[^a-zA-Z0-9]/', '', $sn);
	
	$card = $this->DB_master->fetch_one("SELECT * FROM {$this->TABLE_}recharge_card WHERE sn = '$sn' AND used == '0'");
	if(empty($card)) return false;
	
	global $UID;
	$this->DB_master->update($this->TABLE_ .'recharge_card', array('uid' => $UID, 'used_timestamp' => P8_TIME), "sn = '$sn'");
	return $this->core->update_credit($UID, array($card['credit_type'] => $card['quantity']));
}

function pay_recharge(&$pay, $notify){
	return include $this->path .'call/pay_recharge.call.php';
}

function pay_buy_role(&$pay, $notify){
	return include $this->path .'call/pay_buy_role.call.php';
}

function cache(){
	$query = $this->DB_master->query("SELECT username FROM $this->table WHERE is_admin = '1'");
	
	$usernames = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$usernames[$arr['username']] = 1;
	}
	
	$this->set_config(array('administrators' => $usernames));
}

/**
 * ģ������,��������μ�core
 * integration_types Ϊ�����ֶ�,�洢���������ϵ�����
 **/
function set_config(
	$datas,
	$protect_fields = array(	//����������Ҫ�ֶ����
		'integration_types' => 1
	),
	$ignore_fields = array()
){
	parent::set_config($datas, $protect_fields, $ignore_fields);
}

function add_friend_category($name){
	global $UID;
	
	return $this->DB_master->insert(
		$this->friend_category_table,
		array(
			'uid' => $UID,
			'name' => $name
		),
		array('return_id' => true)
	);
}

function update_friend_category($id, $name){
	global $UID;
	
	return $this->DB_master->update(
		$this->friend_category_table,
		array(
			'name' => $name
		),
		"id = '$id' AND uid = '$UID'"
	);
}

function delete_friend_category($id){
	global $UID;
	$id = (array)$id;
	$ids = implode(',', $id);
	if(empty($ids)) return false;
	
	return $this->DB_master->delete(
		$this->friend_category_table,
		"id IN ($ids) AND uid = '$UID'"
	);
}

/**
* ��Ӻ���
* @param int $fuid ����ID
* @param int $cid ���ѷ���ID
* @param string $description ����
* @return int 	1 => �ɹ�, -1 => �û�������, -2 => ���Ѽ�����, -3 => �ȴ���֤, -4 => ��֤��, -5 => �û��ܾ�, 0 => ʧ��
**/
function add_friend($fuid, $cid = 0, $description = '', $verified = false){
	return include $this->path .'call/add_friend.call.php';
}

/**
* ��˻�ܾ�����
* @param int|array $fuid Ҫ��˻�ܾ��ĺ���UID
* @param int $value ��˻�ܾ�
* @param string $reason ��˻�ܾ�������
* @return bool
**/
function verify_friend($fuid, $value = 1, $reason = ''){
	return include $this->path .'call/verify_friend.call.php';
}

/**
* ɾ������
* @param int|array $fuid Ҫɾ�����ѵ�UID
* @return bool
**/
function delete_friend($fuid, $verified = true){
	return include $this->path .'call/delete_friend.call.php';
}

/**
* ɾ������
* @param int|array $fuid Ҫɾ�����ѵ�UID
* @param int $cid Ҫ�ƶ��ķ���ID
* @return bool
**/
function move_friend($fuid, $cid){
	return include $this->path .'call/move_friend.call.php';
}

/**
* ���·���ĺ�����
* @param int $id ����ID
* @param int $count ������
* @return bool
**/
function update_friend_category_count($id, $count){
	if(empty($id) || empty($count)) return false;
	
	return $this->DB_master->update(
		$this->friend_category_table,
		array('members' => 'members +'. $count),
		"id = '$id'",
		false
	);
}

/**
* ȡ�û�Ա��Ϣ
* @param int $uid ��ԱID
**/
function get_member_info($uid = 0){
	
	$SQL = "SELECT M.*,M.id as m_id,R.name as r_name,A.*, A.id as a_id,C.*,C.id as c_id,G.name AS g_name
		FROM $this->table AS M
		LEFT JOIN {$this->core->TABLE_}role AS R ON M.role_id=R.id 
		LEFT JOIN {$this->core->TABLE_}role_group AS G ON M.role_gid=G.id
		LEFT JOIN {$this->addon_table} AS A ON M.id = A.id
		LEFT JOIN {$this->core->TABLE_}credit_member AS C ON M.id = C.id 
		WHERE M.id = '$uid'";
	
	$query = $this->DB_slave->fetch_one($SQL);
	$mess = $this->DB_slave->fetch_one("SELECT COUNT(*) AS `count` FROM {$this->core->TABLE_}message WHERE sendee_uid = '$uid' AND new = '1'");
	if($query){
		$this->role_id = $query['role_id'];
		$this->role_name = $query['name'];
		$this->role_gid = $query['role_gid'];
		$this->address = $query['address'];
		$this->phone = $query['phone'];
		$this->cell_phone = $query['cell_phone'];
		$this->gender = $query['gender'];
		$this->qq = $query['qq'];
		$this->last_login_ip = $query['last_login_ip'];
		$this->last_login = $query['last_login'];
		$this->register_time = $query['register_time'];
		$this->login_time = $query['login_time'];
		$this->credit_1 = $query['credit_1'];
		$this->credit_2 = $query['credit_2'];
		$this->email = $query['email'];
		$this->birthday = $query['birthday'];
		$this->icon = attachment_url($query['icon']);
		$this->r_name = $query['r_name'];
		$this->g_name = $query['g_name'];
		$this->username = $query['username'];
		$this->new_messages = $mess['count'];
		//unset($query);
	}
	return $query;
}

function data($act, $data){
	
	if($act == 'read'){
		if($this->core->CACHE->memcache){
			$ret = $this->core->CACHE->memcache_read('member_'. $data);
			if(!$ret && $ret = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE username = '$data'")){
				$this->core->CACHE->memcache_write('member_'. $data, $ret);
			}
		}else{
			$ret = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE username = '$data'");
		}
		return $ret;
	}else if($act == 'write' && $this->core->CACHE->memcache){
		$this->core->CACHE->memcache_write('member_'. $data['id'], $d);
	}else if($act == 'delete' && $this->core->CACHE->memcache){
		$this->core->CACHE->memcache_delete('member_'. $data);
	}
}

function label(&$LABEL, &$label, &$var){
	
	$select = select();
	$select->from($this->table .' AS m', '*');
	
	$count = $page = 0;
	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count,
		)
	);
	
	$this->core->get_cache('role');
	
	foreach($list as $k => $v){
		$list[$k]['url'] = homepage_url($v['username']);
		$list[$k]['role'] = $core->roles[$v['role_id']]['name'];
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




/**
* ������ҳ��غ���
**/
function homepage_profile(&$block){
	
	global $core, $SKIN, $RESOURCE, $USER;
	
	ob_start();
	include template($this, 'block/profile');
	return ob_get_clean();
}

function homepage_view(&$block){
	global $core, $SKIN, $RESOURCE, $USER;
	
	$select = select();
	$select->from($core->TABLE_ .'homepage_view AS v', 'v.uid');
	$select->inner_join($this->table .' AS m', 'm.id, m.username, m.icon, m.role_id', 'v.view_uid = m.id');
	$select->in('v.uid', $USER['id']);
	
	$page = $count = 0;
	$page_size = $block['item_count'];
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	
	foreach($list as $k => $v){
		$list[$k]['url'] = homepage_url($v['username']);
	}
	
	ob_start();
	include template($this, 'block/view');
	return ob_get_clean();
}

function homepage_friend(&$block){
	global $core, $SKIN, $RESOURCE, $USER;
	
	$select = select();
	$select->from($this->friend_table .' AS f', 'f.uid');
	$select->inner_join($this->table .' AS m', 'm.id, m.username, m.icon, m.role_id', 'f.fuid = m.id');
	$select->in('f.uid', $USER['id']);
	
	$page = $count = 0;
	$page_size = $block['item_count'];
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count
		)
	);
	
	foreach($list as $k => $v){
		$list[$k]['url'] = homepage_url($v['username']);
	}
	
	ob_start();
	include template($this, 'block/friend');
	return ob_get_clean();
}

function homepage_diy(&$block){
	global $core, $SKIN, $RESOURCE, $USER;
	
	ob_start();
	include template($this, 'block/diy');
	return ob_get_clean();
}



/**
* ���÷��ʿ���,����ϵͳ/ģ��,��ɫ,��Զ��ӳ���ϵ
* @param string $system Ҫ����Ȩ�޵�ϵͳ
* @param string $module Ҫ����Ȩ�޵�ģ��
* @param int $role_id ��ɫID
* @param array $acl ���ʿ����б�
* @param array $info #.php�е���Ϣ
* @parma string $postfix ��׺
* @return boolean
**/
function set_acl($system, $module, $user_id, $acl, $info, $postfix = ''){
	$acl_db = $this->DB_master->fetch_one("SELECT v FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND user_id = '$user_id'");
	
	//�����ݿ�����ȡ������
	$acl_db = $acl_db ? mb_unserialize($acl_db['v']) : array();
	
	//���ACTIONȨ�޶���Ϊ��, Ϊ�վͲ�дACTIONȨ��
	if(!empty($acl['admin_actions'])){
		foreach($info['admin_actions'] as $k => $v){
			$acl_db['admin_actions'][$k] = empty($acl['admin_actions'][$k]) ? false : true;
		}
		if(empty($info['admin_actions'])) $acl_db['admin_actions'] = array();
	}
	
	if(!empty($acl['actions'])){
		foreach($info['actions'] as $k => $v){
			$acl_db['actions'][$k] = empty($acl['actions'][$k]) ? false : true;
		}
		if(empty($info['actions'])) $acl_db['actions'] = array();
	}
	unset($acl['admin_actions'], $acl['actions']);
	//�����궯��
	
	if(!empty($acl)){
		//��������ϸ��Ȩ������
		foreach($acl as $k => $v){
			$acl_db[$k] = $v;
		}
	}
	
	//replace into
	$status = $this->DB_master->insert(
		$this->acl_table,
		array(
			'system' => $system,
			'module' => $module,
			'postfix' => $postfix,
			'user_id' => $user_id,
			'v' => $this->DB_master->escape_string(serialize($acl_db))
		),
		array(
			'replace' => true
		)
	);
	
	$path = empty($module) ? $system : $system .'/modules/'. $module;
	
	global $CACHE;
	$CACHE->write($path, 'acl', 'user_'. $user_id .($postfix ? '#'. $postfix : ''). $this->last_cache, $acl_db);
	
	return $status;
}


/**
* ����ɫIDɾ��Ȩ��
* @param int|array $user_id ��ɫID
**/
function delete_acl_by_user($user_id){
	$uids = $comma = '';
	foreach((array) $role as $v){
		$uids .= $comma . $v;
	}
	
	if(empty($uids)) return false;
	
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table WHERE user_id IN ($uids)");
	
	global $CACHE;
	while($arr = $this->DB_master->fetch_array($query)){
		$key = $arr['system'];
		$key = $arr['module'] ? $key .'/modules/'. $arr['module'] : $key;
		
		$arr['postfix'] = $arr['postfix'] ? '#'. $arr['postfix'] : '';
		//ɾ������
		$CACHE->delete($key, 'acl', 'role_'. $arr['user_id'] . $arr['postfix']);
	}
	
	$this->DB_master->delete($this->acl_table, "user_id IN ($uids)");
	
	return true;
}


/**
* ��÷��ʿ����б�
* @param object $obj Ҫ����Ȩ�޵Ķ���
* @param int $user_id ��ɫID
* @return array ���ʿ����б�
**/
function get_acl(&$obj, $user_id, $postfix = ''){
	
	switch($obj->type){
	
	case 'core':
	case 'system':
		$system = $obj->name;
		$module = '';
	break;
	
	case 'module':
		$system = $obj->system->name;
		$module = $obj->name;
	break;
	
	}
	
	//�ܴ���postfix*,��ѯ��������postfix%����ģ������
	if(strpos($postfix, '*') !== false){
		$postfix = str_replace('*', '', $postfix);
		$acl_db = $this->DB_master->fetch_all("SELECT v, postfix FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND user_id = '$user_id' AND postfix LIKE '$postfix%'");
		
		$ret = array();
		foreach($acl_db as $v){
			$ret[$v['postfix']] = mb_unserialize($v['v']);
		}
		
		return $ret;
	}else{
		$acl_db = $this->DB_master->fetch_one("SELECT v FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND user_id = '$user_id' AND postfix = '$postfix'");
		
		return $acl_db ? mb_unserialize($acl_db['v']) : array();
	}
	
}


/**
* ����һ����ɫ��Ȩ�޵�һ��������ɫ
* @param int $src_user_idԴ��Ա
* @param int|array $tar_user Ŀ���Ա,����������
* @param boolean �Ƿ񸲸�Ŀ���ɫ��Ȩ��,�������,����Դ��ɫ��Ŀ���ɫ�ϲ�,������Ŀ���ɫ��Ȩ��,��������ظ���Ȩ�޽���Դ��ɫ��Ϊ׼
**/
function copy_acl($src_user_id, $tar_user = array(), $cover = true){
	if(empty($tar_user)) return false;
	
	//Դ��ɫ��Ȩ��
	$src_acls = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table WHERE user_id = '$src_user_id'");
	$_src_acls = array();
	foreach($src_acls as $k => $v){
		
		$_src_acls[$v['system']][$v['module']][$v['postfix']] = mb_unserialize($v['v']);
		
		unset($src_acls[$k]['user_id']);
		$src_acls[$k]['v'] = mb_unserialize($v['v']);
	}
	
	$uploader = &$this->core->load_module('uploader');
	
	foreach((array) $tar_user as $user_id){
		if($user_id == $src_user_id) continue; //���ܸ���Դ��ɫ��Ȩ��
		
		//�ϴ�Ȩ��
		$config = $this->core->get_config('core', 'uploader');
		$config = $config['role_filters'];
		$config[$user_id] = isset($config[$src_user_id]) ? $config[$src_user_id] : array();
		$uploader->set_config(array('role_filters' => $config));
		
		if($cover){
			
			//����д��
			
			//ɾ��Ŀ���ɫ������Ȩ��
			$this->delete_acl_by_user($user_id);
			
			foreach($src_acls as $vv){
				//����Ȩ�ޱ�
				$this->DB_master->insert(
					$this->acl_table,
					array(
						'system' => $vv['system'],
						'module' => $vv['module'],
						'postfix' => $vv['postfix'],
						'user_id' => $user_id,
						'v' => $this->DB_master->escape_string(serialize($vv['v']))
					)
				);
			}
			
		}else{
			
			//�ϲ�Ȩ��
			
			//��ȡĿ���ɫ��Ȩ��
			$tar_acls = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table WHERE user_id = '$user_id'");
			$_tar_acls = array();
			foreach($tar_acls as $k => $v){
				$_tar_acls[$v['system']][$v['module']][$v['postfix']] = mb_unserialize($v['v']);
				
				
			}
			
			//$_tar_acls = array_merge($_src_acls, $_tar_acls);
			$_acls = $_src_acls;
			foreach($_tar_acls as $system => $v){
				foreach($v as $module => $vv){
					foreach($vv as $postfix => $vvv){
						$_acls[$system][$module][$postfix] = array_merge($_acls[$system][$module][$postfix], $vvv);
						
					}
				}
			}
			print_r($_tar_acls);
			
			//ɾ��Ŀ���ɫ������Ȩ��
			$this->delete_acl_by_user($user_id);
			
			foreach($_tar_acls as $system => $v){
				foreach($v as $module => $vv){
					foreach($vv as $postfix => $vvv){
						
						$this->DB_master->insert(
							$this->acl_table,
							array(
								'system' => $system,
								'module' => $module,
								'postfix' => $postfix,
								'user_id' => $user_id,
								'v' => $this->DB_master->escape_string(serialize($vvv))
							)
						);
						
					}
				}
			}
			
		}
		
		//�˵���Ȩ��
		$this->set_menu_privilege($user_id);
	}
	
	//$this->cache_acl();
	return true;
}

/**
* �־�����Ȩ�ޱ�Ļ���
**/
function cache_acl_step($n, $tn, $on){
	global $CACHE;
	$query = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table LIMIT $n,100");
	if(!$query) return false;
	foreach($query as $key=>$arr){
		
		$path = $arr['module'] ? $arr['system'] .'/modules/'. $arr['module'] : $arr['system'];
		$filepre = 'user_'. $arr['user_id'];
		//�к�׺��
		$fielname = $arr['postfix'] ? $filepre .'#'. $arr['postfix'] : $filepre;
		$data = mb_unserialize($arr['v']);
		$CACHE->write($path, 'acl', $fielname . $tn, $data);
		//ɾ���ϴλ����
		$CACHE->delete($path, 'acl', $fielname . $on);
	}	
		return true;	
}

/**
* ����Ȩ�ޱ�Ļ���
**/
function cache_acl(){
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table");
	$acls = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$acls[$arr['system']][$arr['module']][$arr['user_id']][$arr['postfix']] = mb_unserialize($arr['v']);
	}
	
	$last_cache = '@'. $this->core->CONFIG['last_user_acl_cache'];
	//�����ϴ�Ȩ�޸��»���ʱ��
	if(!defined('P8_CLUSTER')){
		$this->core->set_config(array(
			'last_user_acl_cache' => P8_TIME
		));
		$this->last_cache = '@'. P8_TIME;
	}
	
	//�ļ�����д����ϵͳ/ģ�黺��Ŀ¼�е�aclĿ¼��
	global $CACHE;
	foreach($acls as $system => $v){
		//ϵͳ
		$vkey = $system;
		foreach($v as $module => $vv){
			//ϵͳ or ģ��Ȩ��
			$vvkey = $module ? $vkey .'/modules/'. $module : $vkey;
			
			foreach($vv as $user_id => $vvv){
				//��ɫID
				$vvvkey = 'user_'. $user_id;
				foreach($vvv as $postfix => $vvvv){
					//�к�׺��
					$vvvvkey = $postfix ? $vvvkey .'#'. $postfix : $vvvkey;
					
					$CACHE->write($vvkey, 'acl', $vvvvkey . $this->last_cache, $vvvv);
					
					//ɾ���ϴλ����
					$CACHE->delete($vvkey, 'acl', $vvvvkey . $last_cache);
				}
			}
		}
	}
}

/**
* ����Ȩ�����ò˵�����ʾ
* @param int $user_id ��ԱID
**/
function set_menu_privilege($user_id){
	global $admin_menu, $member_menu;
	
	static $admin_menus = array(), $member_menus = array();
	if(empty($admin_menus)){
		$query = $this->DB_master->query("SELECT * FROM {$this->core->TABLE_}admin_menu");
		while($v = $this->DB_master->fetch_array($query)){
			if(($pos = strpos($v['action'], '?')) !== false) $v['action'] = substr($v['action'], 0, $pos);
			
			$admin_menus[$v['system'] .'-'. $v['module'] .'-'. $v['action']][] = $v;
		}
		
		$query = $this->DB_master->query("SELECT * FROM {$this->core->TABLE_}member_menu");
		while($v = $this->DB_master->fetch_array($query)){
			if(($pos = strpos($v['action'], '?')) !== false) $v['action'] = substr($v['action'], 0, $pos);
			
			$member_menus[$v['system'] .'-'. $v['module'] .'-'. $v['action']][] = $v;
		}
	}
	
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table WHERE user_id = '$user_id' AND postfix = ''");
	
	//����ֹ�Ĳ˵�
	$admin_menu_denied = array();
	$member_menu_denied = array();
	
	while($v = $this->DB_master->fetch_array($query)){
		$acl = mb_unserialize($v['v']);
		
		if(!empty($acl['admin_actions'])){
			foreach($acl['admin_actions'] as $action => $priv){
				if(
					!$priv && !empty($admin_menus[$v['system'] .'-'. $v['module'] .'-'. $action])
				){
					foreach($admin_menus[$v['system'] .'-'. $v['module'] .'-'. $action] as $vv){
						$admin_menu_denied[$vv['id']] = 1;
					}
				}
			}
		}
		
		if(!empty($acl['actions'])){
			foreach($acl['actions'] as $action => $priv){
				if(
					!$priv && !empty($member_menus[$v['system'] .'-'. $v['module'] .'-'. $action])
				){
					foreach($member_menus[$v['system'] .'-'. $v['module'] .'-'. $action] as $vv){
						$member_menu_denied[$vv['id']] = 1;
					}
				}
			}
		}
	}
	
	global $CACHE;
	$CACHE->write('', 'core', 'admin_menu_user_'. $user_id, jsonencode($admin_menu_denied));
	$CACHE->write('core/modules', 'member', 'menu_json_user_'. $user_id, jsonencode($member_menu_denied));
}
}