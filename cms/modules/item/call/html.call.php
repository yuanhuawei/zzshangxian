<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::html(&$query)
	//定义生成静态的常量
	defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);
	
	require_once PHP168_PATH .'inc/html.func.php';
	
	global $this_model, $MODEL, $HTML_DATA;
	foreach(array_keys($GLOBALS) as $v){
		global $$v;
	}
	$category = &$this->system->load_module('category');
	
	//变量尽可能怪异,防止冲突
	$__models__ = $__datas__ = array();
	while($__arr__ = $this->DB_master->fetch_array($query)){

	
		//设置有跳转的跳过
		if(!empty($HTML_DATA['url'])) continue;
		
		$__models__[$__arr__['model']][] = $__arr__['id'];
		$__datas__[$__arr__['id']] = $__arr__;
	}
	
	foreach($__models__ as $__model__ => $__ids__){
		
		if(! ($__ids__ = implode(',', filter_int($__ids__))) ) continue;
		
		$this->set_model($__model__);
		
		$this->_html['query'] = $this->DB_slave->query("SELECT i.*, a.*, i.timestamp AS timestamp, a.iid AS id FROM $this->table AS i
			INNER JOIN $this->addon_table AS a ON i.id = a.iid
			WHERE i.id IN ($__ids__) AND a.page = 1");
		
		while($__arr__ = $this->DB_slave->fetch_array($this->_html['query'])){
			$HTML_DATA = array_merge($__arr__, $__datas__[$__arr__['id']]);
				
			$__CAT__ = &$this->system->fetch_category($HTML_DATA['cid']);

			//如果分类不是生成静态的
			if(empty($__CAT__['htmlize'])) continue;
			
			
			$HTML_DATA['#category'] = &$__CAT__;
			$id = $HTML_DATA['id'];
			
			if($this->core->ismobile){
			    $__CAT__['html_view_url_rule'] = $__CAT__['html_view_url_rule_mobile'];
			}
			//很危险的啦,你懂的啦
			$__CAT__['html_view_url_rule'] = str_replace('"', '', $__CAT__['html_view_url_rule']);
			
			//取得要生成文件的绝对路径
			$__tmp_file__ = p8_html_url($this, $HTML_DATA, 'view', false);
			
			if(!$__tmp_file__) continue;
			
			$this->_html['basename'] = basename($__tmp_file__);
			//取路径
			$this->_html['path'] = str_replace($this->_html['basename'], '', $__tmp_file__);
			//分页文件
			$this->_html['page_file'] = preg_replace('/#([^#]+)#/', '\1', $__tmp_file__);
			//无分页的文件
			$this->_html['no_page'] = preg_replace('/#([^#]+)#/', '', $__tmp_file__);
			
			/*
			if(preg_match('/^#.*\.(.*)#$/', $basename, $m)){
				$this->_html['file'] = $this->_html['path'] .'index.'. $m[1];
			}else{
				$this->_html['file'] = $this->_html['no_page'];
			}
			*/
			
			if($HTML_DATA['pages'] > 1){
				$this->_html['datas'] = array();
				$this->_html['_query'] = $this->DB_slave->query("SELECT i.*, a.*, i.timestamp AS timestamp, a.iid AS id FROM $this->table AS i
					INNER JOIN $this->addon_table AS a ON i.id = a.iid
					WHERE i.id = '$id' ORDER BY a.page ASC LIMIT 1,$HTML_DATA[pages]");
				
				$__i__ = 2;
				while($___arr__ = $this->DB_slave->fetch_array($this->_html['_query'])){
					$this->_html['datas'][$__i__++] = array_merge($___arr__, $__datas__[$___arr__['id']]);
				}
			}
			
			//生成内容分页
			$__pages__ = $HTML_DATA['pages'];
			for($__i__ = 1; $__i__ <= $__pages__; $__i__++){
				$__view_uri__ = '/index.php/'. $this->system->name .'/item-view-id-{$id}-page-{$page}';
				
				if($__i__ > 1) $HTML_DATA = $this->_html['datas'][$__i__];
				
				$page = $__i__;
				if($page == 1){
					$this->_html['file'] = $this->_html['no_page'];
				}else{
					$this->_html['file'] = str_replace('?page?', $page, $this->_html['page_file']);
				}
			if($this->core->ismobile){
				$__view_uri__ = '/m'.$__view_uri__;
			}				
				//更改REQUEST_URI
				eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__view_uri__ .'";');
				
				
				
				if($this->core->ismobile){
					$filename = PHP168_PATH .'m/index.php';
				}else{
					$filename = PHP168_PATH .'index.php';
				}
					
				ob_start();
				require $filename;
				$__content__ = ob_get_clean();
				
				//创建文件夹
				md($this->_html['path']);
				//生成文件
				$this->_html['file'] = valid_path($this->_html['file']);				
					
					
				if(!write_file($this->_html['file'], $__content__)){
					return false;
				}
				@chmod($this->_html['file'], 0644);
				
				//write_file("view.txt", "{$this->_html['file']} {$this->DB_master->query_num}\r\n", 'a');
			}
			
			unset($HTML_DATA, $HTML_DATAS, $next_item, $prev_item);
		}
	}
		
	return true;