<?php
return array (
  'dynamic_list_url_rule' => '{$module_controller}-list-category-{$id}#-page-{$page}#.html',
  'dynamic_view_url_rule' => '{$module_controller}-view-id-{$id}.shtml',
  'htmlize' => '0',
  'html_list_url_rule' => '{$system_url}/special/list_{$id}#-page-{$page}#html',
  'html_view_url_rule' => '{$system_url}/special/{$id}.html',
  'mobile_template' => 'mobile/group',
  'template' => '',
  'view_page_cache_ttl' => '0',
);