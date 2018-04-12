<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::delete($data)
	
	$data['verified'] = isset($data['verified']) && !$data['verified'] ? false : true;
	$T = $data['verified'] ? $this->main_table : $this->unverified_table;
	
	require_once PHP168_PATH .'inc/html.func.php';
	
	$query = $this->DB_master->query("SELECT $T.id, $T.cid, $T.uid, $T.model, m.role_id, $T.pages, $T.timestamp FROM $T
		LEFT JOIN {$this->system->member_table} m ON $T.uid = m.id
		WHERE $data[where]");
	
	$ids = $comma = '';
	$credit_info = $id = $models = array();
	
	//加载分类模块
	$category = &$this->system->load_module('category');
	$category->get_cache();
	$category_item_count = $user_item_count = $delete_file = array();
	
	while($arr = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $arr['id'];
		$id[] = $arr['id'];
		$comma = ',';
		$credit_info[] = array($arr['uid'], $arr['role_id'], $arr['cid']);
		
		//更新分类的条数
		$category_item_count[$arr['cid']] = isset($category_item_count[$arr['cid']]) ? $category_item_count[$arr['cid']] +1 : 1;
		$user_item_count[$arr['uid']] = isset($user_item_count[$arr['uid']]) ? $user_item_count[$arr['uid']] +1 : 1;
		$models[$arr['model']] = isset($models[$arr['model']]) ? $models[$arr['model']] +1 : 1;
		
		if(!empty($category->categories[$arr['cid']]['htmlize'])){
			//获取要删除的HTML文件
			$arr['#category'] = &$category->categories[$arr['cid']];
			$file = p8_html_url($this, $arr, 'view', false);
			$_no_page_file = preg_replace('/#([^#]+)#/', '', $file);
			$_page_file = preg_replace('/#([^#]+)#/', '$1', $file);
			
			for($i = 1; $i <= $arr['pages']; $i++){
				$file = $i == 1 ? $_no_page_file : str_replace('?page?', $i, $_page_file);
				@unlink($file);
			}
		}
		
		$this->data('delete', $arr['id']);
        if(!empty($category->categories[$arr['cid']]['htmlize'])){
            $this->html_list($arr['cid']);
        }
	}
	
	if(!$ids) return array();
	
	/* foreach($models as $model => $v){
		require $this->system->path . $model .'/delete.php';
		
		$func($ids);
	} */
	
	$num = 0;
	if(
		$num = $this->DB_master->delete($T, "id IN ($ids)")
	){
		$this->DB_master->delete($this->member_table, "iid IN ($ids)");
		$this->DB_master->delete($this->attribute_table, "id IN ($ids)");
		$this->DB_master->delete($this->tag_item_table, "iid IN ($ids)");
		$this->DB_master->delete($this->TABLE_ .'comment', "iid IN ($ids)");
		$this->DB_master->delete($this->TABLE_ .'mood_data', "iid IN ($ids)");
		
		$orig_model = $this->model;
		
		foreach($models as $model => $v){
			$this->set_model($model);
			
			$this->DB_master->delete($this->table, "id IN ($ids)");
			$this->DB_master->delete($this->addon_table, "iid IN ($ids)");
		}
		
		$this->set_model($orig_model);
		
		if($data['verified']){
			//批量更新分类内容数
			foreach($category_item_count as $cid => $count){
				$category->update_count($cid, -$count);
			}
			
			//批量更新会员内容数
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
			
			unset($orig_model, $category_item_count, $user_item_count);
			
		}
		
		$credit = &$this->core->load_module('credit');
		//应用积分规则
		foreach($credit_info as $v){
			$credit->apply_rule(
				$this,
				'delete',
				$v[0], $v[1],
				array('category_'. $v[2], '')
			);
		}
		
		//删除挂钩模块的数据,如果用户指定删除或是关联删除调用
		//if(!empty($data['delete_hook']) || !empty($data['hook'])){
		//	$this->delete_hook_module_item($ids);
		//}
		
		//删除相应辅栏目下内容
		$assist_category = &$this->system->load_module('assist_category');
		foreach($id as $v){
			$assist_category->delete_list_all($v);
		}
	}
	
	return $num ? $id : array();