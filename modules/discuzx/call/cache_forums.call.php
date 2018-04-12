<?php
defined('PHP168_PATH') or die();

//P8_Discuzx::cache_forums()
	
	$types = array();
	$query = $this->db->query("SELECT * FROM {$this->TABLE_}forum_threadclass ORDER BY displayorder ASC");
	while($arr = $this->db->fetch_array($query)){
		$types[$arr['fid']][$arr['typeid']] = array(
			'id' => $arr['typeid'],
			'name' => $arr['name']
		);
	}
	
	$query = $this->db->query("SELECT cname, ctype, data FROM {$this->TABLE_}common_syscache WHERE cname IN('forums', 'setting', 'usergroups')");
	while($v = $this->db->fetch_array($query)){
		
		switch($v['cname']){
		
		case 'forums':
			$data = mb_unserialize($v['data']);
			$data = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $data);
			
			foreach($data as $v){
				$this->forums[$v['fid']] = array(
					'id' => $v['fid'],
					'type' => $v['type'],
					'parent' => $v['fup'],
					'name' => $v['name']
				);
			}
			
			foreach($this->forums as $v){
				if($v['parent'] == 0){
					$this->top_forums[$v['id']] = &$this->forums[$v['id']];
				}else{
					$this->forums[$v['parent']]['forums'][$v['id']] = &$this->forums[$v['id']];
				}
			}
			
			
			$cache = array(
				'forums' => &$this->forums,
				'top_forums' => &$this->top_forums,
				'types' => &$types
			);
			
			$this->core->CACHE->write('core/modules', $this->name, 'forums', $cache, 'serialize');
			
			//生成JSON路径
			$path = array();
			foreach($this->forums as $v){
				$ps = array();
				if($v['parent']){
					$p = $v['parent'];
					
					while($p){
						array_unshift($ps, $this->forums[$p]['id']);
						
						$p = $this->forums[$p]['parent'];
					}
				}
				
				$ps[] = $v['id'];
				
				$path[$v['id']] = $ps;
			}
			
			$json = array(
				'json' => p8_json($this->top_forums),
				'path' => p8_json($path),
				'types' => p8_json($types)
			);
			
			
			$this->core->CACHE->write('core/modules', $this->name, 'forums_json', $json);
		break;
		
		case 'setting':
			$data = mb_unserialize($v['data']);
			$data = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $data);
			
			$config = array();
			
			//论坛以及帖子地址
			if(!empty($data['rewritestatus'])){
				foreach($data['rewritestatus'] as $v){
					switch($v){
					
					case 'forum_viewthread':
						$config['thread_url'] = str_replace(array('-{page}', '-{prevpage}'), '', $data['rewriterule']['forum_viewthread']);
					break;
					
					case 'forum_forumdisplay':
						$config['forum_url'] = str_replace('-{page}', '', $data['rewriterule']['forum_forumdisplay']);
					break;
					
					case 'home_space':
						$config['space_url'] = str_replace('-{value}', '', $data['rewriterule']['home_space']);
					break;
					
					}
				}
			}else{
				$config['forum_url'] = $this->CONFIG['url'] .'/forum.php?mod=forumdisplay&fid={fid}';
				$config['thread_url'] = $this->CONFIG['url'] .'/forum.php?mod=viewthread&tid={tid}';
				$config['space_url'] = $this->CONFIG['url'] .'/home.php?mod=space&uid={user}';
			}
			
			//附件地址
			if(empty($data['ftp']['on'])){
				$config['attachment_url'] = $this->CONFIG['url'] .'/'. $data['attachurl'];
			}else{
				$config['attachment_url'] = $this->CONFIG['url'] .'/'. $data['ftp']['attachurl'];
			}
			
			//UC URL
			$config['ucenterurl'] = $data['ucenterurl'];
			$config['avatarmethod'] = $data['avatarmethod'];
			
			$config['sphinx'] = array(
				'enabled' => $data['sphinxon'],
				'host' => $data['sphinxhost'],
				'port' => $data['sphinxport'],
				'index' => $data['sphinxsubindex'],
				'post_index' => $data['sphinxmsgindex'],
				'limit' => empty($data['sphinxlimit']) ? 10000 : $data['sphinxlimit'],
			);
			
			$this->set_config($config);
		break;
		
		case 'usergroups':
			$data = mb_unserialize($v['data']);
			$data = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $data);
			
			$config = array();
			foreach($data as $id => $v){
				$config[$id] = array(
					'id' => $id,
					'name' => $v['grouptitle'],
					'icon' => $v['icon'],
					'color' => $v['color']
				);
			}
			
			$this->set_config(array('usergroups' => $config));
		break;
		
		}
	}
	
	