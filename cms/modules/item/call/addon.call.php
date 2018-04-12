<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::addon(&$data)
	/* $select = select();
	$select->from($this->addon_table, 'MAX(page) AS page');
	$select->in('iid', $data['iid']);
	$tmp = $this->core->select($select, 'master'); */
	
	$attachment_hash = $data['attachment_hash'];
	unset($data['attachment_hash']);
	$html = $data['html'];
	unset($data['html']);
	$verified = $data['verified'];
	unset($data['verified']);
	
	$tmp = $this->DB_master->fetch_one("SELECT MAX(page) AS page FROM $this->addon_table WHERE iid = '$data[iid]'");
	
	//��ǰ׷�����ݵ�ҳ��
	if($verified){
		$data['page'] = $tmp['page'] +1;
	}else{
		$data['page'] = $tmp['page'] == 0 ? 2 : $tmp['page'] +1;
	}
	
	$id = $this->DB_master->insert(
		$this->addon_table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	
	//������ҳ��
	$this->DB_master->update(
		$this->main_table,
		array(
			'pages' => 'pages +1',
			'update_time' => P8_TIME
		),
		"id = '$data[iid]'",
		false
	);	//����
	
	if(
		!$this->DB_master->update(
			$this->table,
			array(
				'pages' => 'pages +1',
				'update_time' => P8_TIME
			),
			"id = '$data[iid]'",
			false
		)
	){
		//�п�������δ��˱�
		$this->DB_master->update(
			$this->unverified_table,
			array(
				'pages' => 'pages +1'
			),
			"id = '$data[iid]'",
			false
		);
	}
	//���ݱ�
	
	//�ռ����ϴ��ĸ���
	uploaded_attachments($this, $data['iid'], $attachment_hash);
	
	$this->data('delete', $data['iid']);
	
	if($verified && $html){
		//����HTML
		if(defined('P8_ADMIN')){
			global $P8LANG, $ADMIN_LOG;
			$ADMIN_LOG = array('title' => $P8LANG['_module_addon_admin_log']);
		}
		$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$data[iid]'"));
        $this->html_list($cat['id']);
    }
	
	return $id;