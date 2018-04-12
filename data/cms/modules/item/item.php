<?php
return array (
  'allow_comment' => '1',
  'allow_digg' => '1',
  'allow_mood' => '0',
  'attribute_acl' => 
  array (
    1 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    2 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    3 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    4 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    5 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    6 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    7 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
    8 => 
    array (
      4 => 1,
      1 => 1,
      13 => 1,
    ),
  ),
  'comment' => 
  array (
    'enabled' => '0',
    'require_verify' => '0',
    'page_size' => '20',
    'view_page_size' => '5',
  ),
  'dynamic_homepage_list_url_rule' => '{$URL}#-page-{$page}#.shtml',
  'dynamic_list_url_rule' => '{$module_controller}-list-category-{$id}#-page-{$page}#.shtml',
  'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}#-page-{$page}#.shtml',
  'first_img_to_frame' => '1',
  'htmlize' => '0',
  'list_navigagion' => 'nav_list02',
  'list_page_cache_ttl' => '0',
  'list_page_cacle_ttl' => '0',
  'mobile_dynamic_list_url_rule' => '{$module_mobile_controller}-list-mid-{$id}#-page-{$page}#.html',
  'mobile_dynamic_view_url_rule' => '{$module_mobile_controller}-view-id-{$id}.html',
  'mobile_template' => 'mobile/group',
  'sphinx' => 
  array (
    'enabled' => '0',
    'host' => 'localhost',
    'port' => '3312',
  ),
  'template' => 'group5',
  'verify_acl' => 
  array (
    1 => 
    array (
      'name' => '终审',
      'role' => 
      array (
        1 => 1,
        '' => 1,
      ),
    ),
    0 => 
    array (
      'name' => '取消审核',
      'role' => 
      array (
        1 => 1,
        '' => 1,
      ),
    ),
    -99 => 
    array (
      'name' => '退稿',
      'role' => 
      array (
        1 => 1,
        '' => 1,
      ),
    ),
  ),
  'view_page_cache_ttl' => '0',
  'view_page_cacle_ttl' => '0',
);