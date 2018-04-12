<?php
defined('PHP168_PATH') or die();

/**
* 某些内容的统计。写得太死，凡对应表单字段不可修改
**/
$for = isset($_GET['for'])? $_GET['for'] : '';
$this_module -> set_model('jixiaobiaoyan');
$this_model or exit('error');
$field = $for=='tian'? 'd.tiang' : 'd.shoukeshijian';
$SQL = "SELECT i.status,d.* FROM $this_module->data_table as d RIGHT JOIN $this_module->table AS i ON i.id=d.id WHERE $field !='' AND i.status>0 ORDER BY timestamp DESC";
$list = $this_module->core->DB_master->fetch_all($SQL);
include template($this_module, 'modeltemplade/jixiaobiaoyan');
