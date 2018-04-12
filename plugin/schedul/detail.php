<?php
defined('PHP168_PATH') or die();

	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$page = max(1, $page);
		$page_url = $this_url .'?page=?page?';
		$page_param= array();

		$select = select();
		$select->from($this_plugin->table, 'date');
		
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
		
		$select->order('date DESC');
		$count = $core->DB_master->fetch_one($select->build_count_sql());
		$count = $count['num'];
		$select->group('date');
		$_list = $core->list_item(
			$select,
			array(
				'page' => &$page,
				'count' => &$count,
				'page_size' => 5
			)
		);
		
		$dat = $split = '';
		foreach($_list as $d){
			$dat .= $split."'{$d['date']}'";
			$split = ',';
		}
		
		$sql = "SELECT * FROM {$this_plugin->table} WHERE date IN($dat) ORDER BY date DESC, list_order ASC, id ASC";

		$query = $core->DB_master->fetch_all($sql);

		$list = array();
		
		foreach($query as $row){
			$list[$row['date']][] = $row;
		}
		
		if($page_param){
			$page_param = http_build_query($page_param);
			$page_url .=(strpos($page_url,'?')===false? '?':'&').$page_param;
		}
		
		$pages = list_page(array(
				'count' => $count,
				'page' => $page,
				'page_size' => 5,
				'url' => $page_url
			));
		
		include $this_plugin->template('detail');

?>