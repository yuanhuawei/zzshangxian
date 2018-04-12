<?php
return array (
  'name' => 'resource',
  'config' => 
  array (
    'admin_edit_template' => '',
    'member_edit_template' => '',
    'frame_thumb_width' => '',
    'frame_thumb_height' => '',
    'content_thumb_width' => '',
    'content_thumb_height' => '',
    'hidedownurl' => '0',
    'thunderid' => '08311',
    'flashgetid' => '6370',
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
    'course' => 
    array (
      'parent' => '0',
      'name' => 'course',
      'alias' => '学科',
      'type' => 'tinyint',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '3',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
        1 => '语文',
        2 => '数学',
        3 => '英语',
        4 => '物理',
        5 => '化学',
        6 => '政治',
        7 => '音乐',
        8 => '美术',
        9 => '生物',
        10 => '地理',
        11 => '体育与健康',
        12 => '劳动技术',
        13 => '综合实践',
        14 => '公共卫生教育',
        15 => '心理健康教育',
        16 => '健康教育',
        17 => '品德与社会',
      ),
      'config' => 
      array (
      ),
      'widget' => 'radio',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'slevel' => 
    array (
      'parent' => '0',
      'name' => 'slevel',
      'alias' => '学段',
      'type' => 'tinyint',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '3',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
        1 => '小学',
        2 => '初中',
        3 => '高中',
      ),
      'config' => 
      array (
      ),
      'widget' => 'radio',
      'widget_addon_attr' => '',
      'display_order' => '0',
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
    'vision' => 
    array (
      'parent' => '0',
      'name' => 'vision',
      'alias' => '版本',
      'type' => 'tinyint',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '3',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
        1 => '人教2001课标版',
        2 => '长春2001课标版',
        3 => '北师大2001课标版',
        4 => '苏教2001课标版',
        5 => '西南师大2001课标版',
      ),
      'config' => 
      array (
      ),
      'widget' => 'radio',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'year' => 
    array (
      'parent' => '0',
      'name' => 'year',
      'alias' => '年级',
      'type' => 'tinyint',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '3',
      'is_unsigned' => '0',
      'editable' => '1',
      'default_value' => '',
      'data' => 
      array (
        1 => '一年级',
        2 => '二年级',
        3 => '四年级',
        4 => '五年级',
        5 => '六年级',
        6 => '七年级',
        7 => '八年级',
        8 => '九年级',
        9 => '高一年级',
        10 => '高二年级',
        11 => '高三年级',
      ),
      'config' => 
      array (
      ),
      'widget' => 'radio',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
  ),
);