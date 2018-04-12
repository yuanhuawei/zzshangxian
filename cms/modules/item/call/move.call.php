<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::move($id, $cid, $verified = true){
	$ids = implode(',', (array)$id);
	
	if(!strlen($ids)){
		return false;
	}
	
	if($verified){
		$T = $this->main_table;
		$fields = 'url, html_view_url_rule, pages, timestamp';
	}else{
		$T = $this->unverified_table;
		$fields = '';
	}
	
	$cat = $this->system->fetch_category($cid);
	if(empty($cat)) return false;
	
	require_once PHP168_PATH .'inc/html.func.php';
	
	//ֻ���ƶ�����ͬģ�͵ķ���
	$query = $this->DB_master->query("SELECT id, cid, $fields FROM $T WHERE id IN ($ids) AND model = '$cat[model]'");
	$count = 0;
	$cids = array();
	while($arr = $this->DB_master->fetch_array($query)){
		
		$cids[$arr['cid']] = isset($cids[$arr['cid']]) ? $cids[$arr['cid']] +1 : 1;
		$count++;
		
		//ɾ��HTML�ļ�
		$arr['#category'] = &$this->system->fetch_category($arr['cid']);
		
		$file = p8_html_url($this, $arr, 'view', false);
		if(!$file) continue;
		
		$_no_page_file = preg_replace('/#([^#]+)#/', '', $file);
		$_page_file = preg_replace('/#([^#]+)#/', '$1', $file);
		
		for($i = 1; $i <= $arr['pages']; $i++){
			$file = $i == 1 ? $_no_page_file : str_replace('?page?', $i, $_page_file);
			@unlink($file);
		}
		
		$this->data('delete', $arr['id']);
	}
	
	if(empty($count)) return false;
	
	if($verified){
		//����˵�
		if(
			$this->DB_master->update(
				$this->main_table,
				array(
					'cid' => $cid
				),
				"id IN ($ids)"
			)
		){
			$category = &$this->system->load_module('category');
			
			/* if(!empty($this->CONFIG['sphinx']['enable'])){
				$sphinx = new p8_sphinx($this->CONFIG['sphinx']['host'], $this->CONFIG['sphinx']['host']);
				
				$sphinx->UpdateAttributes(
					$this->system->name .'-item-'. $cat['model'],
					array('cid'),
					array()
				);
			} */
			
			$this->set_model($cat['model']);
			
			$this->DB_master->update(
				$this->table,
				array(
					'cid' => $cid
				),
				"id IN ($ids)"
			);
			
			//���Ա�
			$this->DB_master->update(
				$this->attribute_table,
				array(
					'cid' => $cid
				),
				"id IN ($ids)"
			);
			
			
			//�����ƶ��ķ���
			$category->update_count($cid, $count);
			
			//���ٱ��ƶ��ķ���
			foreach($cids as $k => $v){
				$category->update_count($k, -$v);
			}
			
			//�������ɾ�̬
			if(defined('P8_ADMIN')){
				global $P8LANG, $ADMIN_LOG;
				$ADMIN_LOG = array('title' => $P8LANG['_module_move_admin_log']);
			}
			$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id IN ($ids)"));
			
			return true;
		}
		
	}else{
		
		//δ���
		
		$this->DB_master->update(
			$this->unverified_table,
			array(
				'cid' => $cid
			),
			"id IN ($ids)"
		);
		
		//���Ա�
		$this->DB_master->update(
			$this->attribute_table,
			array(
				'cid' => $cid
			),
			"id IN ($ids)"
		);
		
		return true;
		
	}
	
	return false;