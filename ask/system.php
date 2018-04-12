<?php
class P8_Ask extends P8_System{

var $CACHE;
var $sitename; //ϵͳ����
var $sitetitle; //ϵͳ����
var $keywords; //ϵͳ�ؼ���
var $description;  //ϵͳ����
var $position; //����λ��
var $table_statistics;



function P8_Ask(&$core, $name){
	
	global $core, $CACHE, $SKIN;

	$this->core = &$core;
	parent::__construct($name);
	$this->CACHE = &$CACHE;
	$this->sitename = !empty($this->CONFIG['sitename']) ? $this->CONFIG['sitename'] : '';
	$this->sitetitle = !empty($this->CONFIG['sitetitle']) ? $this->CONFIG['sitetitle'] : '';
	$this->meta_keywords = !empty($this->CONFIG['meta_keywords']) ? $this->CONFIG['meta_keywords'] : '';
	$this->meta_description = !empty($this->CONFIG['meta_description']) ? $this->CONFIG['meta_description'] : '';

	$this->position = '<a href="' . $this->controller . '">' . $this->sitename . '</a>';

	$this->table_statistics = $this->TABLE_ . 'statistics';
	$this->statistics = $this->read_statistics();
	
	//��������
	$this->item_count = empty($this->statistics['item_count']) ? 0 : intval($this->statistics['item_count']);
	//�ѽ����������
	$this->solve_item_count = empty($this->statistics['solve_item_count']) ? 0 : intval($this->statistics['solve_item_count']);
	//δ�����������
	$this->unsolve_item_count = empty($this->statistics['unsolve_item_count']) ? 0 : intval($this->statistics['unsolve_item_count']);
			
}

/**
 * ����ͳ����Ϣ����
 */
function cache_statistics(){
	
	$data = $this->DB_master->fetch_one('SELECT * FROM ' . $this->table_statistics);

	//��վ������
	$data['item_count'] = !empty($data['item_count']) ? intval($data['item_count']) : 0;
	//�ѽ��������
	$data['solve_item_count'] = !empty($data['solve_item_count']) ? intval($data['solve_item_count']) : 0;
	//δ���������
	$data['unsolve_item_count'] = max($data['item_count'] - $data['solve_item_count'],0);

	$this->CACHE->write('', $this->name, 'statistics', $data);
}

/**
 * ��ȡͳ����Ϣ����
 */
function read_statistics(){

	return $this->CACHE->read('', $this->name, 'statistics');

}

}