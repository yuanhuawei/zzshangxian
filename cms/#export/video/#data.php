<?php
return array (
  'name' => 'video',
  'config' => 
  array (
    'frame_thumb_width' => '120',
    'frame_thumb_height' => '90',
  ),
  '#fields' => 
  array (
    'content' => 
    array (
      'parent' => '0',
      'name' => 'content',
      'alias' => '����',
      'type' => 'mediumtext',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '0',
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
      'display_order' => '99',
      'units' => '',
      'description' => '',
    ),
    'video_height' => 
    array (
      'parent' => '0',
      'name' => 'video_height',
      'alias' => '��Ƶ�߶�',
      'type' => 'smallint',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '5',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '390',
      'data' => 
      array (
      ),
      'config' => 
      array (
      ),
      'widget' => 'text',
      'widget_addon_attr' => '',
      'display_order' => '77',
      'units' => '����',
      'description' => '',
    ),
    'video_url' => 
    array (
      'parent' => '0',
      'name' => 'video_url',
      'alias' => '��Ƶ��ַ',
      'type' => 'varchar',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '0',
      'length' => '255',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => 'http://',
      'data' => 
      array (
      ),
      'config' => 
      array (
        'thumb_width' => '120',
        'thumb_height' => '90',
      ),
      'widget' => 'video_uploader',
      'widget_addon_attr' => '',
      'display_order' => '66',
      'units' => '',
      'description' => '',
    ),
    'video_width' => 
    array (
      'parent' => '0',
      'name' => 'video_width',
      'alias' => '��Ƶ���',
      'type' => 'smallint',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '5',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '450',
      'data' => 
      array (
      ),
      'config' => 
      array (
      ),
      'widget' => 'text',
      'widget_addon_attr' => '',
      'display_order' => '88',
      'units' => '����',
      'description' => '',
    ),
  ),
);