<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::update_addon(&$data, &$orig_data)
	$attachment_hash = $data['attachment_hash'];
	unset($data['attachment_hash']);
	$verified = $data['verified'];
	unset($data['verified']);
	
	if(
		$this->DB_master->update(
			$this->addon_table,
			$this->DB_master->escape_string($data),
			"id = '$data[id]' AND iid = '$data[iid]'"
		)
	){
		//收集己上传的附件
		uploaded_attachments($this, $data['iid'], $attachment_hash);
		
		
		//生成HTML
		if(defined('P8_ADMIN')){
			global $P8LANG, $ADMIN_LOG;
			$ADMIN_LOG = array('title' => $P8LANG['_module_add_admin_log']);
		}
		
		if($verified){
			$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$data[iid]'"));
		}
	}
	
	return true;