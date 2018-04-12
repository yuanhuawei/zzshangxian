<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::add(&$data)
	
	//ͨ�����
	$verified = false;
	
	$ever_verified = empty($data['main']['ever_verified']) ? 0 : 1;
	
	if($data['verify'] == 1){
		$verified = true;
		$data['main']['verified'] = $data['item']['verified'] = $data['main']['ever_verified'] = 1;
	}else{
		$data['main']['verified'] = $data['item']['verified'] = 0;
	}
	
	//��������ȡ��ID
	$id = $this->DB_master->insert(
		$this->main_table,
		$this->DB_master->escape_string($data['main']),
		array('return_id' => true)
	);
	
	//ԭ����ID,�ǵ���
	$id = isset($data['main']['id']) ? $data['main']['id'] : $id;
	
	if(empty($id)) return false;
	
	//�ռ����ϴ��ĸ���
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	
	if(!isset($data['main']['id'])){
		//��Ա���ݱ�
		$this->DB_master->insert(
			$this->member_table,
			array(
				'iid' => $id,
				'uid' => $data['item']['uid'],
				'model' => $data['main']['model'],
				'verified' => $data['main']['verified'],
				'timestamp' => $data['item']['timestamp']
			)
		);
	}
	
	//���»�Ա��������
	$this->DB_master->update(
		$this->system->member_table,
		array(
			'item_count' => 'item_count +1'
		),
		"id = '{$data['main']['uid']}'",
		false
	);
	
	if(isset($data['assist_category'])){
		//����Ŀ
		$assist_category = &$this->system->load_module('assist_category');
		$assist_category->add_list($id, $data['assist_category']);
	}
	
	
	
	//δ���
	if(!$verified){
		$data['main']['id'] = $id;
		
		//δ��˵ķŵ���һ����
		
		$this->DB_master->insert(
			$this->unverified_table,
			array(
				'id' => $id,
				'model' => $data['main']['model'],
				'cid' => $data['main']['cid'],
				'title' => $data['main']['title'],
				'uid' => $data['main']['uid'],
				'username' => $data['main']['username'],
				'attributes' => $data['main']['attributes'],
				'timestamp' => $data['main']['timestamp'],
				'push_item_id' => $data['push_item_id'],
				'data' => $this->DB_master->escape_string(serialize($data))
			)
		);
		
		//ɾ��
		$this->DB_master->delete(
			$this->main_table,
			"id = '$id'"
		);
		
		//����,���ͨ����ʱ����ִ�д˷�����������
		return $id;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	//�����
	$data['item']['id'] = $id;
	$data['item'] = $this->DB_master->escape_string($data['item']);
	$this->DB_master->insert(
		$this->table,
		$data['item']
	);
	
	//׷�ӱ�
	$data['addon'] = $this->DB_master->escape_string($data['addon']);
	$data['addon']['iid'] = $id;	//����ID
	$data['addon']['page'] = 1;		//ҳ��
	$this->DB_master->insert(
		$this->addon_table,
		$data['addon']
	);
	
	//�������
	$this->add_attribute($data['main']['attributes'], $id, $data['main']['cid']);
	$this->add_tag($data['item']['keywords'], $id);
	
	//���·����¼��
	$category = &$this->system->load_module('category');
	$category->update_count($data['item']['cid'], 1);
	
	//û����˹�,����ӵ�
	if(!$ever_verified && empty($data['main']['id'])){
		$credit = &$this->core->load_module('credit');
		//Ӧ�û��ֹ���
		$credit->apply_rule(
			$this,
			'verify',
			$data['main']['uid'], $this->system->ROLE,
			array('category_'. $data['main']['cid'], '')
		);
		
		/*
		$cluster = &$this->core->load_module('cluster');
		$service = &$cluster->load_service('client', $this->system->name .'_item');
		
		$map = array_flip($service->CONFIG['map']);
		$_data = $this->cluster_data($id, $map[$data['main']['cid']]);
		$cluster->server_call($this->system->name .'_item', 'push', $_data, true);
		*/
	}
	
	if(!empty($data['html']) && !defined('P8_CLUSTER')){
		//����HTML
		$cat = $category->categories[$data['main']['cid']];
		if(!empty($cat['htmlize'])){
			if(defined('P8_ADMIN')){
				global $P8LANG, $ADMIN_LOG;
				$ADMIN_LOG = array('title' => $P8LANG['_module_add_admin_log']);
			}
			$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$id'"));
            
            $this->html_list($cat['id']);
            
			if(!empty($this->core->CONFIG['enable_mobile'])){
				$_GLOBALS['core']->ismobile=true;
				$this->core->ismobile=true;
				$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$id'"));
                $_GLOBALS['core']->ismobile=false;
				$this->core->ismobile=false;
            }
		}
	}
    
    $reflashindex = false;//Ϊ����ҳ��ʾ
    if($reflashindex && !defined('P8_CLUSTER')){   

        if($this->core->ismobile)return;    
        //������
        //unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);
        
        require_once PHP168_PATH .'inc/cache.func.php';
        cache_label();  
        clear_page_cache();

        //�������ɾ�̬�ĳ���
        defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);

        $_SERVER['_REQUEST_URI'] = '/index.php/cms';
        
        foreach(array_keys($GLOBALS) as $v){
            global $$v;
        }

        ob_start();
        require PHP168_PATH .'index.php';

        $content = ob_get_clean();

        $index_file = &$this->system->index_files[$this_system->CONFIG['index_file']];

        if($this->core->CONFIG['index_system'] == $this_system->name){
            write_file(PHP168_PATH . $index_file, $content);
            @chmod(PHP168_PATH . $index_file, 0644);
        }
        
    }
	
	$data['main']['id'] = $id;
	
	$this->data('write', $data['main']);
	
	return $id;