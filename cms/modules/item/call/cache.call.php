<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::cache()
	
	$list = $this->DB_master->fetch_all("SELECT * FROM {$this->TABLE_}mood ORDER BY display_order DESC");
	
	//Éú³É»º´æ
	$moods = array();
	foreach($list as $m){
		$moods[$m['id']] = $m;
		unset($moods[$m['id']]['id'], $moods[$m['id']]['display_order']);
	}
	
	$this->core->CACHE->write($this->system->name .'/modules', $this->name, 'moods', $moods);