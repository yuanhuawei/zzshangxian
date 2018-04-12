<?php
return array (
  'name' => 'product',
  'config' => 
  array (
    'prev&next_item' => '1',
    'admin_edit_template' => '',
    'member_edit_template' => '',
    'frame_thumb_width' => '',
    'frame_thumb_height' => '',
    'content_thumb_width' => '',
    'content_thumb_height' => '',
  ),
  '#fields' => 
  array (
    'aboutinfo' => 
    array (
      'parent' => '0',
      'name' => 'aboutinfo',
      'alias' => '相关信息',
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
      'widget' => 'editor_basic',
      'widget_addon_attr' => '',
      'display_order' => '9',
      'units' => '',
      'description' => '',
    ),
    'attrbutes' => 
    array (
      'parent' => '0',
      'name' => 'attrbutes',
      'alias' => '产品参数',
      'type' => 'text',
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
      'widget' => 'editor_basic',
      'widget_addon_attr' => '',
      'display_order' => '8',
      'units' => '',
      'description' => '',
    ),
    'content' => 
    array (
      'parent' => '0',
      'name' => 'content',
      'alias' => '产品介绍',
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
      'widget' => 'editor_common',
      'widget_addon_attr' => '',
      'display_order' => '7',
      'units' => '',
      'description' => '',
    ),
    'pics' => 
    array (
      'parent' => '0',
      'name' => 'pics',
      'alias' => '图片欣赏',
      'type' => 'text',
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
      'widget' => 'multi_uploader',
      'widget_addon_attr' => '',
      'display_order' => '6',
      'units' => '',
      'description' => '',
    ),
    'pro_down' => 
    array (
      'parent' => '0',
      'name' => 'pro_down',
      'alias' => '相关下载',
      'type' => 'varchar',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '0',
      'length' => '255',
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
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
  ),
);