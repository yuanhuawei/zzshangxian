<?php
defined('PHP168_PATH') or die();

//�������ģ��
$category = &$this_system->load_module('category');
$category->cache();

//����ͳ����Ϣ����
$this_system->cache_statistics();

message('done', $this_router . '-config');

?>