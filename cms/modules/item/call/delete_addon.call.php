<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::delete_addon($data)
	
	$ids = implode(',', $data['id']);
	
	$this->set_model($data['item']['model']);
	
	if(
		$rows = $this->DB_master->delete(
			$this->addon_table,
			"iid = '$data[iid]' AND id IN ($ids) AND page != 1"
		)
	){
		
		if($data['verified']){
			
			require_once PHP168_PATH .'inc/html.func.php';
			
			//删除静态文件
			$data['item']['#category'] = &$this->system->fetch_category($data['item']['cid']);
			
			if($file = p8_html_url($this, $data['item'], 'view', false)){
				
				$_no_page_file = preg_replace('/#([^#]+)#/', '', $file);
				$_page_file = preg_replace('/#([^#]+)#/', '$1', $file);
				
				for($i = 1; $i <= $data['item']['pages']; $i++){
					$file = $i == 1 ? $_no_page_file : str_replace('?page?', $i, $_page_file);
					@unlink($file);
				} 
			}
			
			
			$this->DB_master->update(
				$this->main_table,
				array(
					'pages' => 'pages -'. $rows
				),
				"id = '$data[iid]'",
				false
			);
			
			$this->DB_master->update(
				$this->table,
				array(
					'pages' => 'pages -'. $rows
				),
				"id = '$data[iid]'",
				false
			);
			
			$this->data('delete', $data['iid']);
			
			//重新生成静态
			if(defined('P8_ADMIN')){
				global $P8LANG, $ADMIN_LOG;
				$ADMIN_LOG = array('title' => $P8LANG['_module_add_admin_log']);
			}
			
			$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$data[iid]'"));
			
		}else{
			
			$this->DB_master->update(
				$this->unverified_table,
				array(
					'pages' => 'pages -'. $rows
				),
				"id = '$data[iid]'",
				false
			);
		}
	}
	
	
	
	return $rows;