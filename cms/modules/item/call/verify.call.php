<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::verify($data ($where, $value = 1, $verified = 1, $push_back_reason))
	
	$T = $data['value'] == 1 ? $this->unverified_table : $this->main_table;
	$T = $data['verified'] ? $this->main_table : $this->unverified_table;
	
	$query = $this->DB_master->query("SELECT
		$T.id, $T.cid, $T.model, $T.uid, $T.ever_verified, m.role_id FROM $T 
		LEFT JOIN {$this->system->member_table} m ON $T.uid = m.id 
		WHERE $data[where]");
	
	$ids = $comma = '';
	$credit_info = $id = array();
	//$model_ids = array();
	
	$num = 0;
	
	while($arr = $this->DB_master->fetch_array($query)){
		$id[] = $arr['id'];
		$ids .= $comma . $arr['id'];
		$comma = ',';
		if(empty($arr['ever_verified'])){
			//�Ѿ�ͨ��һ����˾Ͳ���Ӧ�û��ֹ���
			$credit_info[] = array($arr['uid'], $arr['role_id'], $arr['cid']);
		}
		
		$num++;
	}
	
	if(!$num) return $id;
	
	//�޸Ļ�Ա��ϵ��
	$this->DB_master->update(
		$this->member_table,
		array('verified' => $data['value']),
		"iid IN ($ids)"
	);
	
	if($data['value'] == 1 && $data['verified'] == 0){
		//����
		$num = 0;
		
		$orig_model = $this->model;
		
		global $P8LANG, $UID,$USERNAME;
		$message = &$this->core->load_module('message');
		
		$query = $this->DB_master->query("SELECT * FROM $this->unverified_table WHERE id IN ($ids)");
		while($_data = $this->DB_master->fetch_array($query)){
			
			$add_data = mb_unserialize($_data['data']);
			$this->set_model($_data['model']);
			
			//���ͨ���ŵ�������
			$add_data['verify'] = true;
			//���ɾ�̬
			$add_data['html'] = true;
			$add_data['main']['cid'] = $add_data['item']['cid'] = $_data['cid'];
			$add_data['main']['pages'] = $add_data['item']['pages'] = $_data['pages'];
			$add_data['main']['verifier'] = $add_data['item']['verifier'] = $USERNAME;
			$add_data['main']['verify_time'] = $add_data['item']['verify_time'] = time();
			
			//��ӵ�ʱ���޸ķ������������߼��Ѿ�����,������д�߼�
			if($this->add($add_data)){
				//��ӳɹ���ɾ��δ��˱��������
				$this->DB_master->delete(
					$this->unverified_table,
					"id = '$_data[id]'"
				);
				
				$num++;
			}
			
			if($_data['uid'] && $_data['uid'] != $UID){
				$m = array(
					'username' => $_data['username'],
					'title' => $P8LANG['cms_item']['verify']['changed'],
					'content' => p8lang($P8LANG['cms_item']['verify']['changed_message'], $_data['title'], $P8LANG['cms_item']['verify'][1], $data['push_back_reason']),
					'system' => true
				);
				$message->send($m);
			}
			//�������
			if(!empty($_data['push_item_id']) && $this->core->modules['cluster']['installed']){
				$cluster = &$this->core->load_module('cluster');
				if(!empty($cluster->CONFIG['clients'])){
					//echo 'ssssss';
					$client = $cluster->load_service('client', 'cms_item');
					$client->set_push_item_status($_data['push_item_id'],1);
				}	

			}
			$this->data('delete', $_data['id']);
		}
		
		if($num){
			$credit = &$this->core->load_module('credit');
			//Ӧ�û��ֹ���
			foreach($credit_info as $v){
				$credit->apply_rule(
					$this,
					'verify',
					$v[0], $v[1],
					array('category_'. $v[2], '')
				);
			}
			
			//push
		}
		
		$this->set_model($orig_model);
		
		return $id;
		
	}else{
		
		//ȡ����˻�δͨ��
		$num = 0;
		
		$orig_model = $this->model;
		
		if($data['verified']){
			$T = $this->main_table;
			$category = $this->system->load_module('category');
			$category->get_cache();
			$delete_file = array();
			
			//ȡ����˵�Ҫɾ����̬�ļ�
			require_once PHP168_PATH .'inc/html.func.php';
		}else{
			$T =  $this->unverified_table;
		}
		
		$message = &$this->core->load_module('message');
		global $P8LANG;
		
		$cids = $user_item_count = array();
		$query = $this->DB_master->query("SELECT * FROM $T WHERE id IN ($ids)");
		while($main = $this->DB_master->fetch_array($query)){
			
			if($data['verified']){
				//ȡ�����
				$this->set_model($main['model']);
				$_data = array();
				$_data['main'] = $main;
				$_data['item'] = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$main[id]'");
				$_data['addon'] = $this->DB_master->fetch_one("SELECT * FROM $this->addon_table WHERE iid = '$main[id]' AND page = 1");
				
				$cids[$main['cid']] = isset($cids[$main['cid']]) ? $cids[$main['cid']] +1 : 1;
				$user_item_count[$arr['uid']] = isset($user_item_count[$arr['uid']]) ? $user_item_count[$arr['uid']] +1 : 1;
				
				//���뵽δ��˱�
				$this->DB_master->insert(
					$this->unverified_table,
					array(
						'id' => $main['id'],
						'model' => $main['model'],
						'cid' => $main['cid'],
						'title' => $main['title'],
						'uid' => $main['uid'],
						'username' => $main['username'],
						'attributes' => $main['attributes'],
						'timestamp' => $main['timestamp'],
						'verified' => $data['value'],
						'pages' => $main['pages'],
						'ever_verified' => $main['ever_verified'],
						'data' => $this->DB_master->escape_string(serialize($_data)),
						'push_back_reason' => $data['push_back_reason']
					)
				);
				
				//ɾ��ԭ��������
				$this->DB_master->delete($this->main_table, "id = '$main[id]'");
				$this->DB_master->delete($this->table, "id = '$main[id]'");
				$this->DB_master->delete($this->addon_table, "iid = '$main[id]' AND page = 1");
				
				
				if(!empty($category->categories[$main['cid']]['htmlize'])){
					//��ȡҪɾ����HTML�ļ�
					$main['#category'] = &$category->categories[$main['cid']];
					
					if($file = p8_html_url($this, $main, 'view', false)){
						$_no_page_file = preg_replace('/#([^#]+)#/', '', $file);
						$_page_file = preg_replace('/#([^#]+)#/', '$1', $file);
						
						for($i = 1; $i <= $main['pages']; $i++){
							$file = $i == 1 ? $_no_page_file : str_replace('?page?', $i, $_page_file);
							@unlink($file);
						}
					}
				}
				
			}else{
				
				//�޸�δ���״̬
				$this->DB_master->update(
					$this->unverified_table,
					array(
						'verified' => $data['value'],
						'push_back_reason' => $data['push_back_reason']
					),
					"id = '$main[id]'"
				);
				
			}
			$lang_status = in_array($data['value'], array(0, 1, -99)) ? 
				$P8LANG['cms_item']['verify'][$data['value']] :
				$this->CONFIG['verify_acl'][$data['value']]['name'];
			
			$m = array(
				'username' => $main['username'],
				'title' => $P8LANG['cms_item']['verify']['changed'],
				'content' => p8lang($P8LANG['cms_item']['verify']['changed_message'], $main['title'], $lang_status, $data['push_back_reason']),
				'system' => true
			);
			$message->send($m);
			
			$this->data('delete', $main['id']);
			
			$num++;
		}
		
		//ȡ����˵�Ҫ���·����������
		if($data['verified']){
			foreach($cids as $cid => $v){
				$category->update_count($cid, -$v);
			}
			
			//�������»�Ա������
			foreach($user_item_count as $uid => $count){
				$this->DB_master->update(
					$this->system->member_table,
					array(
						'item_count' => 'item_count -'. $count
					),
					"id = '$uid'",
					false
				);
			}
		}
		
		$this->set_model($orig_model);
		
		return $id;
	}
	
	return $id;