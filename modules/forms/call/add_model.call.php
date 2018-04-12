<?php
defined('PHP168_PATH') or die();

//P8_Forms::add_model(&$data)
	//Ä£ĞÍÅäÖÃ
	empty($data['config']) && $data['config'] = array();
	
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	
	if(
		$id = $this->DB_master->insert(
			$this->model_table,
			$data,
			array('return_id' => true)
		)
	){

		require_once PHP168_PATH .'install/install.func.php';
		
		$model_sql = get_install_sql(
			$this->DB_master,
			file_get_contents($this->path .'install/model_sql.php'),
			$this->TABLE_ . 'item_' . $data['name'],
			true
		);
		
		foreach($model_sql as $sql){
			$this->DB_master->query($sql);
		}
		
		$path = $this->path .'model/'. $data['name'] .'/';
		is_dir($path) || cp($this->path .'model/'.'#/', $path);
		
		$this->cache($data['name']);
	}
	
	
	
	return $id;
