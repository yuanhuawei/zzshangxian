<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'GET'){

	//load_language($this_plugin, 'global');	//¼ÓÔØÓïÑÔ°ü
	$job = isset($_GET['job'])? $_GET['job'] : '';
	if(!$job){
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = max(1, $page);
		$page_url = $this_url .'?plugin=schedul&page=?page?';
		$page_param= array();

		$select = select();
		$select->from($this_plugin->table, '*');
		
		if(!empty($_GET['date'])){
			$date = $_GET['date'];
			$select->in('date',$date);
			$page_param['date'] = $date;
		}
		if(!empty($_GET['name'])){
			$name = $_GET['name'];
			$select->like('name',$name);
			$page_param['name'] = $name;
		}
		$select->order('date DESC, list_order ASC, id ASC');
		$count = 0;
		$list = $core->list_item(
			$select,
			array(
				'page' => &$page,
				'count' => &$count,
				'page_size' => 20
			)
		);
		
		if($page_param){
			$page_param = http_build_query($page_param);
			$page_url .=(strpos($page_url,'?')===false? '?':'&').$page_param;
		}
		
		$pages = list_page(array(
				'count' => $count,
				'page' => $page,
				'page_size' => 20,
				'url' => $page_url
			));
		
		include $this_plugin->template('index');
		exit;
	}else if($job=='cache'){
		$this_plugin->_cache();
	}else if($job=='add'){
		include $this_plugin->template('add');
		exit;
	}else if($job=='edit'){
		$id = isset($_GET['id'])?intval($_GET['id']):0;
		$row = $this_plugin->get_data($id);
		include $this_plugin->template('add');
		exit;
	}
	message('done',$this_url.'?plugin=schedul');
	
}elseif(REQUEST_METHOD == 'POST'){
$do=isset($_POST['do'])? $_POST['do']:'';

	if($do=='config'){
		$config = isset($_POST['config']) && is_array($_POST['config']) ? $_POST['config'] : array();
		
		$config['appid'] = $config['appid'];
		$config['appkey'] = $config['appkey'];
		$config['display'] = $config['display'];
		$config['role_gid'] = $config['role_gid'];
		$this_plugin->set_config($config);
		$this_plugin->_cache();
		message('done',$this_url.'?plugin=schedul',2);
	}else if($do=='order'){
		$listorder = isset($_POST['listorder'])?$_POST['listorder']:array();
		foreach($listorder as $key=>$id){
			$this_plugin->update($id,array('list_order'=>$key));
		}
		message('done',$this_url.'?plugin=schedul',2);
	}else if($do=='delete'){
		$id = isset($_POST['id'])?intval($_POST['id']):0;
		$this_plugin->delete($id);
		message('done',$this_url.'?plugin=schedul',2);
	}else if($do=='add'){
		$dates = isset($_POST['date'])?$_POST['date']:array();
		$date_time = isset($_POST['date_time'])?$_POST['date_time']:array();
		$name = isset($_POST['name'])?$_POST['name']:array();
		$level = isset($_POST['level'])?$_POST['level']:array();
		$phone = isset($_POST['phone'])?$_POST['phone']:array();
		$event = isset($_POST['event'])?$_POST['event']:array();
		foreach($dates as $key=>$date){
			if(!$date || !$name[$key])continue;
			$this_plugin->add(array(
				'date'=>$date,
				'name'=>$name[$key],
				'date_time'=>isset($date_time[$key])?$date_time[$key]:0,
				'level'=>$level[$key],
				'phone'=>$phone[$key],
				'event'=>$event[$key],
			));
		}
		$this_plugin->_cache();
		message('done',$this_url.'?plugin=schedul',2);
	}else if($do=='edit'){
		$id = isset($_POST['id'])?intval($_POST['id']):0;
		$dates = isset($_POST['date'])?$_POST['date']:array();
		$date_time = isset($_POST['date_time'])?$_POST['date_time']:array();
		$name = isset($_POST['name'])?$_POST['name']:array();
		$level = isset($_POST['level'])?$_POST['level']:array();
		$phone = isset($_POST['phone'])?$_POST['phone']:array();
		$event = isset($_POST['event'])?$_POST['event']:array();
		foreach($dates as $key=>$date){
			if(!$date || !$name[$key])continue;
			$this_plugin->update($id,array(
				'date'=>$date,
				'name'=>$name[$key],
				'date_time'=>isset($date_time[$key])?$date_time[$key]:0,
				'level'=>$level[$key],
				'phone'=>$phone[$key],
				'event'=>$event[$key],
			));
		}
		$this_plugin->_cache();
		message('done',$this_url.'?plugin=schedul',2);
	}
}