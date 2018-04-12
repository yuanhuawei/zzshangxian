<?php
return array (
  'name' => 'down',
  'config' => 
  array (
    'admin_edit_template' => '',
    'member_edit_template' => '',
    'frame_thumb_width' => '',
    'frame_thumb_height' => '',
    'content_thumb_width' => '',
    'content_thumb_height' => '',
    'hidedownurl' => '0',
    'thunderid' => '',
    'flashgetid' => '',
  ),
  '#fields' => 
  array (
    'content' => 
    array (
      'parent' => '0',
      'name' => 'content',
      'alias' => '资源介绍',
      'type' => 'mediumtext',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
      ),
      'config' => 
      array (
      ),
      'widget' => 'editor',
      'widget_addon_attr' => '',
      'display_order' => '33',
      'units' => '',
      'description' => '',
    ),
    'softsize' => 
    array (
      'parent' => '0',
      'name' => 'softsize',
      'alias' => '资源大小',
      'type' => 'varchar',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '10',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
      ),
      'config' => 
      array (
      ),
      'widget' => 'text',
      'widget_addon_attr' => '',
      'display_order' => '55',
      'units' => 'K',
      'description' => '',
    ),
    'softurl' => 
    array (
      'parent' => '0',
      'name' => 'softurl',
      'alias' => '资源地址',
      'type' => 'mediumtext',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
      ),
      'config' => 
      array (
      ),
      'widget' => 'uploader',
      'widget_addon_attr' => '',
      'display_order' => '44',
      'units' => '',
      'description' => '',
    ),
    'totaldown' => 
    array (
      'parent' => '0',
      'name' => 'totaldown',
      'alias' => '总下载量',
      'type' => 'mediumint',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '5',
      'is_unsigned' => '0',
      'editable' => '0',
      'default_value' => '',
      'data' => 
      array (
      ),
      'config' => 
      array (
      ),
      'widget' => 'text',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
  ),
);