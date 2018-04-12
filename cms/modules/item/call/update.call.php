<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::update($id, &$data, &$orig_data, $verified = true)
	
	$status = true;
	
	//收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	
	if($verified){
		
		//添加属性
		$this->add_attribute($data['main']['attributes'], $id, $data['main']['cid']);
		
		//添加tag
		$this->add_tag($data['item']['keywords'], $id, 'update');
		
		$cid = $data['main']['cid'];
		if($data['main']['cid'] != $orig_data['cid']){
			$move = true;
			unset($data['main']['cid'], $data['item']['cid']);
		}
		//修改己审核的数据
		
		$status |= $this->DB_master->update(
			$this->main_table,
			$this->DB_master->escape_string($data['main']),
			"id = '$id'"
		);
		
		$status |= $this->DB_master->update(
			$this->table,
			$this->DB_master->escape_string($data['item']),
			"id = '$id'"
		);
		
		unset($data['addon']['page']);
		
		//只能修改第一页的追加内容
		$status |= $this->DB_master->update(
			$this->addon_table,
			$this->DB_master->escape_string($data['addon']),
			"iid = '$id' AND page = 1"
		);
		
		
		$data['main']['id'] = $id;
		$data['main']['uid'] = $orig_data['uid'];
		$data['main']['model'] = $orig_data['model'];
		$data['main']['pages'] = $orig_data['pages'];
		$data['main']['cid'] = $cid;
		$this->data('write', $data['main']);
		
		if(isset($move)){
			//移动了分类
			$this->move($id, $cid, $verified);
		}
		if(!$data['verify']){
			//修改后变为未审核
			$this->verify(array(
				'where' => $this->main_table.".id = '$id'",
				'value' => 0,
				'verified' => $verified,
				'push_back_reason' => ''
			));
			
		}else{
			
			/*
			if(!empty($this->CONFIG['sphinx']['enabled'])){
				$attr = array(
					'cid' => $data['main']['cid'],
					'list_order' => $data['main']['list_order']
				);
				
				foreach($this_model['filterable_fields'] as $k => $v){
					$attr[$k] = $data['item'][$k];
				}
				
				$sphinx = p8_sphinx($this->CONFIG['sphinx']['host'], $this->CONFIG['sphinx']['port']);
				$sphinx->UpdateAttributes(
					$this->system->name .'-item-'. $mod,
					array($id => $attr)
				);
			}
			*/
			
			if(!empty($data['html'])){
				//生成静态
				$cat = $this->system->fetch_category($data['main']['cid']);
				if($cat['htmlize']){
					if(defined('P8_ADMIN')){
						global $P8LANG, $ADMIN_LOG;
						$ADMIN_LOG = array('title' => $P8LANG['_module_update_admin_log']);
					}
					$this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$id'"));
                    $this->html_list($cat['id']);
                }
                if(!empty($this->core->CONFIG['enable_mobile'])){
                    $_GLOBALS['core']->ismobile=true;
                    $this->core->ismobile=true;
                    $this->html($this->DB_master->query("SELECT * FROM $this->main_table WHERE id = '$id'"));
                }   
			}
		}
		
		
	}else{















		//修改未审核的数据
		
		$_data = mb_unserialize($orig_data['data']);
		//用新数据合并旧的数据
		$data['main'] = array_merge($_data['main'], $data['main']);
		$data['item'] = array_merge($_data['item'], $data['item']);
		$data['addon'] = array_merge($_data['addon'], $data['addon']);
		
		if($data['verify']){
			//通过审核
			
			if($status = $this->add($data)){
				//添加后删除旧数据
				$this->DB_master->delete($this->unverified_table, "id = '$id'");
			}
			
		}else{
			
			$status = $this->DB_master->update(
				$this->unverified_table,
				array(
					'cid' => $data['main']['cid'],
					'title' => $data['main']['title'],
					'verified' => 0,				//修改后为待审
					'data' => $this->DB_master->escape_string(serialize($data))
				),
				"id = '$id'"
			);
			
		}
		
	}
	
	//更新辅栏目
	$assist_category = &$this->system->load_module('assist_category');
	$assist_category->update_list($id, $data['assist_category']);
	
	return $status;