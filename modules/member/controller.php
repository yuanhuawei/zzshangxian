<?php
defined('PHP168_PATH') or die();

class P8_Member_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Member_Controller(&$obj){
	$this->__construct($obj);	
}

function register(&$POST){
	$data = array();
	
	$data['username'] = isset($POST['username']) ? $POST['username'] : '';
	$data['password'] = isset($POST['password']) ? html_entities($POST['password']) : '';
	$data['email'] = isset($POST['email']) ? $POST['email'] : '';
	
	//����û���
	if(($status = $this->check_username($data['username'])) != 0){
		switch($status){
			case -1: return -1; break;
			case -2: return -2; break;
		}
	}
	
	//����ʼ�
	if(($status = $this->check_email($data['email'])) != 0){
		switch($status){
			case -1: return -3; break;
			case -2: return -4; break;
		}
	}
	
	unset($data['attachment_hash']);
	$_data = $this->valid_data($POST);
	
	$_data['status'] = $this->model->CONFIG['register']['verify']? 1 : 0;
	
	return $this->model->register($data['username'], $data['password'], $data['email'], $_data);
}

/**
* �޸�����
* @param int $uid Ҫ�޸ĵĵ��û�ID
* @param string $old ������
* @param string $new ������
* @param string $confirm ȷ������
* @return int
* 0 �޸ĳɹ�
* -1 �������벻һ��
* -2 ���������
* -3 δ֪����
**/
function change_password($username, $old, $new, $confirm){
	if(!strlen($old)) return -2;
	
	if(!strlen($new) && !strlen($confirm)) return -1;
	
	if($new !== $confirm){
		return -1;
	}
	
	return $this->model->change_password($username, $new, $old, false);
}

/**
* ����û����Ƿ�Ϸ������
* @param string $username �û���
* @return int 
* 0 �Ϸ�
* -1 �û����Ƿ�
* -2 �û���������
**/
function check_username($username){
	//����������ϵͳ
	if($inte = &$this->core->integrate()){
		return $inte->check_username($username);
	}else{
		
		//û����
		//if(!preg_match('/^[A-Za-z]\w{3,}/', $username)){
		if(preg_match('/'. $this->model->username_reg .'/', $username)){
			return -1;
		}
		
		//��ֹע��Ļ�Ա,����Ա��ӻ�վȺ��ӵĺ���
		global $IS_ADMIN;
		if(!empty($this->model->CONFIG['reg_disallow_username']) && !($IS_ADMIN || defined('P8_CLUSTER'))){
			$disallow = trim($this->model->CONFIG['reg_disallow_username']);
			$tmp = array_filter(explode('|', $disallow));
			$disallow = implode('|', $tmp);
			
			if(preg_match('/^('. $disallow .')/i', $username)){
				return -1;
			}
		}
		
		return get_member($username) ? -2 : 0;
	}
}

/**
* ��������Ƿ�Ϸ������
* @param string $email ����
* @return int 
* 0 �Ϸ�
* -1 �������Ƿ�
* -2 ������������
**/
function check_email($email){
	if(strlen($email) < 4 && !preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $email)){
		return -1;
	}
	
	if($inte = &$this->core->integrate()){
		
		return $inte->check_email($email);
		
	}else{
		
		return $this->DB_master->fetch_one("SELECT id FROM {$this->model->table} WHERE email = '$email'") ? -2 : 0;
	}
}

function update($id, &$POST){
	$data = $this->valid_data($POST);
	
	if(!empty($data['error']))
		return $data;
	
	$select = select();
	$select->from($this->model->table, '*');
	$select->in('id', $id);
	$orig_data = $this->core->select($select, array('single' => true, 'ms' => 'master'));
	
	return $this->model->update($id, $data, $orig_data);
}

function valid_data(&$POST){
	
	$data = array();
	
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	isset($POST['password']) && $data['password'] = html_entities($POST['password']) ;
	if(isset($POST['email'])){
		$data['email'] = html_entities($POST['email']) ;
		if(strlen($data['email']) < 4 && !preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $data['email'])){
			$data['error']='mail_error';
			return $data;
		}
	}
	isset($POST['name']) && $data['name'] = html_entities($POST['name']) ;
	isset($POST['gender']) && $data['gender'] = intval($POST['gender']) ;
	isset($POST['birthday']) && $data['birthday'] = strtotime($POST['birthday']) ;
	isset($POST['address']) && $data['address'] = html_entities($POST['address']) ;
	isset($POST['memo']) && $data['memo'] = html_entities($POST['memo']) ;
	isset($POST['number']) && $data['number'] = html_entities($POST['number']) ;
	isset($POST['phone']) && $data['phone'] = html_entities($POST['phone']) ;
	isset($POST['cell_phone']) && $data['cell_phone'] = html_entities($POST['cell_phone']) ;
	isset($POST['fax']) && $data['fax'] = html_entities($POST['fax']) ;
	isset($POST['qq']) && $data['qq'] = html_entities($POST['qq']) ;
	isset($POST['msn']) && $data['msn'] = html_entities($POST['msn']) ;
	
	isset($POST['icon']) && $data['icon'] = attachment_url(html_entities($POST['icon']),true) ;
	isset($POST['friend_setting']) && $data['friend_setting'] = intval($POST['friend_setting']);
	isset($POST['role_id']) && $data['role_id'] = intval($POST['role_id']);
	isset($POST['role_gid']) && $data['role_gid'] = intval($POST['role_gid']);
	$usercenter = isset($POST['usercenter'])? $POST['usercenter'] : 0;
	global $USERNAME;
	$pinyinname = empty($data['name'])? (empty($POST['username'])? $USERNAME : $POST['username']) : $data['name'];
	if(!empty($pinyinname)){
		require_once PHP168_PATH .'inc/pinyin.class.php';
		
		$pinyin = new P8_Pinyin();
		$p = $pinyin->convert($pinyinname);
		$data['pinyin'] = '';
		foreach(explode(' ', $p) as $v){
			$data['pinyin'] .= substr($v, 0, 1);
		}
	}
	
	global $IS_FOUNDER;
	if(!$usercenter && ($IS_FOUNDER || defined('ADMIN_FORCE') || defined('P8_CLUSTER'))){
		isset($POST['status']) && $data['status'] = intval($POST['status']);
		$data['is_admin'] = empty($POST['is_admin']) ? 0 : 1;
		$data['is_founder'] = empty($POST['is_founder']) ? 0 : 1;
	}
	
	
	$data['#data#'] = array();
	//ģ��
	global $this_model;
	
	if(!$this_model) return $data;
	
	//�Զ����ֶεĹ���
	foreach($this_model['fields'] as $field => $v){
		//����Ƿ���ȷ���ύ�ֶ�
		$posted = true || defined('P8_CLUSTER');
		
		$table = '#data#';
		
		switch($v['widget']){
		
		//�ı���,�����ı���,��ѡ,��ѡ������,�����ϴ���
		case 'text': case 'textarea': case 'radio': case 'select':
			switch($v['type']){
			
			//����
			case 'tinyint': case 'smallint': case 'mediumint': case 'int': case 'bigint':
				$data[$table][$field] = $posted && isset($POST['field#'][$field]) ?
					(int)$POST['field#'][$field] :
					$v['default_value'];
			break;
			
			//����
			case 'float': case 'double': case 'decimal':
				$data[$table][$field] = $posted && isset($POST['field#'][$field]) ?
					(float)$POST['field#'][$field] :
					$v['default_value'];
			break;
			
			//�ַ�
			case 'char': case 'varchar':
				$data[$table][$field] = $posted && isset($POST['field#'][$field]) ?
					html_entities($POST['field#'][$field]) :
					$v['default_value'];
			break;
			
			//Ĭ��
			default: 
				$data[$table][$field] = $posted && isset($POST['field#'][$field]) ?
					html_entities($POST['field#'][$field]) :
					$v['default_value'];
				
			}
		break;
		
		//��ѡ��,��ѡ������
		case 'checkbox': case 'multi_select':
			if($posted){
				if(isset($POST['field#'][$field]))
					$data[$table][$field] = implode($this->model->delimiter, (array)$POST['field#'][$field]);
				else
					$data[$table][$field] = '';
			}else{
				$data[$table][$field] = implode($this->model->delimiter, $v['default_value']);
			}
		break;
		
		//�ϴ���
		case 'uploader':
			if($posted){
				$title = isset($POST['field#'][$field]['title']) ? $POST['field#'][$field]['title'] : '';
				$url = isset($POST['field#'][$field]['url']) ? $POST['field#'][$field]['url'] : '';
				
				$data[$table][$field] = attachment_url(html_entities($title . $this->model->delimiter . $url), true);
			}else{
				$data[$table][$field] = $v['default_value'];
			}
		break;
		
		//�����ϴ�
		case 'multi_uploader':
			if($posted){
				$title = isset($POST['field#'][$field]['title']) ? (array)$POST['field#'][$field]['title'] : array();
				$url = isset($POST['field#'][$field]['url']) ? (array)$POST['field#'][$field]['url'] : array();
				
				$data[$table][$field] = $comma = '';
				foreach($title as $k => $v){
					$data[$table][$field] .= $comma . $v . $this->model->col_delimiter . (isset($url[$k]) ? $url[$k] : '');
					$comma = $this->model->delimiter;
				}
				
				$data[$table][$field] = attachment_url(html_entities($data[$table][$field]), true);
			}
		break;
		
		//�༭��,�༭�������ݺ�Σ��
		case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
			$acl = $this->core->load_acl('core', '', $this->core->ROLE);
			$data[$table][$field] = $posted && isset($POST['field#'][$field]) ?
				attachment_url(p8_html_filter($POST['field#'][$field], $acl['allow_tags'], $acl['disallow_tags']), true) :
				$v['default_value'];
		break;
		
		default:
			$data[$table][$field] = $posted && isset($POST['field#'][$field]) ?
				html_entities($POST['field#'][$field]) :
				$v['default_value'];
		}
		
	}
	
	return $data;
}


/**
* ����Ȩ��
* @param object $obj ģ�Ͳ����
* @param int $user_id ��ԱID
* @param array $acl Ȩ��
* @param string $postfix ��׺
**/
function set_acl(&$obj, $user_id, $acl, $postfix = ''){
	
	if(empty($user_id)) return false;
	
	$acl['admin_actions'] = empty($acl['admin_actions']) ? array() : $acl['admin_actions'];
	$acl['actions'] = empty($acl['actions']) ? array() : $acl['actions'];
	
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
	
	$info = include $obj->path .'#.php';
	
	$postfix = preg_replace("/[^0-9a-zA-Z_]/", '', $postfix);
	
	return $this->model->set_acl($system, $module, $user_id, $acl, $info, $postfix);
}

}