<?php
defined('PHP168_PATH') or die();

class P8_Message extends P8_Module{

var $table;
var $PRIV;

function __construct(&$system, $name){
	//�ݶ���������
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->core->TABLE_ .'message';
	$this->PRIV = array(//1111
		'view' => 4,	//0100
		'write' => 2,	//0010
		'log' => 1,		//0001
	);
}

function P8_Message(&$system, $name){
	$this->__construct($system, $name);
}

/**
* @param array|int $uid �û�ID
* @param array|string $username �û���
* @param string $title ����
* @param string $content ����
* @param bool $system �Ƿ���ϵͳ��Ϣ
* @example
send(array(
	'uid' => 1, // array(1, 2, 3)
	'username' => 'user1', // array('user1', 'user2')
	'title' => 'title',
	'content' => 'content',
	'system' => true, //false ϵͳ��Ϣ,Ĭ��Ϊfalse
	'outbox' => true, //false
	'role_id' => 1, //array(1,2,3) Ⱥ������ɫ��
));
**/
function send(&$data){
	/**
	if(!empty($this->core->CONFIG['integration']['type'])){
		
	}
	*/
	$batch = false;
	$draft = empty($data['draft']) ? false : true;
	
	global $UID, $USERNAME;
	
	if($draft){
		//�ݸ�
		$inbox[] = array(
			'username' => implode(',', $data['username']),
			'othername' => $USERNAME,
			'sender_uid' => $UID,
			'sendee_uid' => 0,
			'type' => 'draft',
			'new' => 0,
			'title' => $data['title'],
			'content' => $data['content'],
			'timestamp' => P8_TIME
		);
	}else if(isset($data['uid'])){
		
		//�����UID����ʹ��UID
		$uids = (array)$data['uid'];
		$uid = $comma = '';
		foreach($uids as $v){
			$uid .= $comma . $v;
			$comma = ',';
		}
		
		if(empty($uid)) return false;
		
		$query = $this->DB_slave->query("SELECT id, username, cell_phone, email FROM {$this->core->member_table} WHERE id IN ($uid)");
		$batch = false;
		
	}else if(isset($data['username'])){
		
		//�û���
		$usernames = (array)$data['username'];
		$comma = $username = '';
		foreach($usernames as $v){
			$username .= $comma .'\''. $v .'\'';
			$comma = ',';
		}
		
		if(empty($username)) return false;
		
		$query = $this->DB_slave->query("SELECT id, username, cell_phone, email FROM {$this->core->member_table} WHERE username IN ($username)");
		$batch = false;
		
	}else if(isset($data['role_id'])){
		//Ⱥ��,��ɫΪ0��ȫ���û�,ָ����ɫ�򷢸�ָ����ɫ
		
		$batch = true;
		
	}else{
		return false;
	}
	
	if($batch){
		
		$status = $this->DB_master->insert(
			$this->table,
			array(
				'sender_uid' => 0,
				'sendee_uid' => 0,
				'username' => '',
				'role_id' => $data['role_id'],
				'type' => 'in',
				'title' => $data['title'],
				'content' => $data['content'],
				'timestamp' => P8_TIME
			)
		);
		
	}else{
		
		if(!$draft){
			$username = $USERNAME;
			
			if(!empty($data['system'])){
				//ϵͳ��Ϣ���ô淢����
				$username = 'system';
				$data['sender_uid'] = 0;
				unset($data['outbox']);
			}
			$ids = $comma = '';
			$inbox = $outbox = $email = $cell_phone = array();
			
			while($arr = $this->DB_slave->fetch_array($query)){
				
				$ids .= $comma . $arr['id'];
				$comma = ',';
				//�ռ���
				$inbox[] = array(
					'username' => $username,
					'othername' => $arr['username'],
					'sender_uid' => $UID,
					'sendee_uid' => $arr['id'],
					'type' => 'in',
					'new' => 1,
					'title' => $data['title'],
					'content' => $data['content'],
					'timestamp' => P8_TIME
				);
				
				if(!$draft && !empty($data['outbox']) && empty($outbox)){
					//������
					$outbox[] = array(
						'username' => $arr['username'],
						'othername' => $USERNAME,
						'sender_uid' => $UID,
						'sendee_uid' => $arr['id'],
						'type' => 'out',
						'new' => 0,
						'title' => $data['title'],
						'content' => $data['content'],
						'timestamp' => P8_TIME
					);
				}
			}
		}
		
		$status = false;
		$field = array('username','othername', 'sender_uid', 'sendee_uid', 'type', 'new', 'title', 'content', 'timestamp');
		
		if(!empty($inbox)){
			//��������
			$status = $this->DB_master->insert(
				$this->table,
				$inbox,
				array(
					'multiple' => $field,
					'return_id' => true
				)
			);
			
			$hash = isset($_POST['attachment_hash']) ? $_POST['attachment_hash'] : '';
			
			uploaded_attachments($this, $status, $hash);
		}
		
		if(!$draft && !empty($outbox)){
			//�����Ҫ���浽������
			$this->DB_master->insert(
				$this->table,
				$outbox,
				array(
					'multiple' => $field
				)
			);
		}
		
		//���»�Ա������Ϣ��
		$status && !$draft && $this->DB_master->update(
			$this->core->member_table,
			array('new_messages' => 'new_messages +1'),
			"id IN ($ids)",
			false
		);
	}
	
	return $status;
}

/**
* ɾ������Ϣ
**/
function delete($data){
	
	$query = $this->DB_master->query("SELECT id, sendee_uid, new FROM $this->table WHERE $data[where]");
	$members = array();
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $arr['id'];
		if($arr['sendee_uid'] && $arr['new']){
			$members[$arr['sendee_uid']] = isset($members[$arr['sendee_uid']]) ? $members[$arr['sendee_uid']] +1 : 1;
		}
		$comma = ',';
	}
	
	if(
		$ids && 
		$status = $this->DB_master->delete(
			$this->table,
			"id IN ($ids)"
		)
	){
		//���»�Ա������Ϣ��
		foreach($members as $uid => $count){
			$this->DB_master->update(
				$this->core->member_table,
				array('new_messages' => 'new_messages -'. $count),
				"id = '$uid'",
				false
			);
		}
		
		//ɾ���ҹ�ģ������
		$this->delete_hook_module_item($ids);
		
		return $status;
	}
	
	return false;
}

/*�ҵ���Ϣ״̬*/
function my_message(){
	global $UID;
	$query = $this->DB_slave->fetch_one("SELECT COUNT(id) as count FROM ".$this->table." WHERE sendee_uid = '$UID' AND new='1'");
	$this->new_message=$query['count'];
}

}