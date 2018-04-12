<?php
return array (
  'name' => 'govopen',
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
    'content' => 
    array (
      'parent' => '0',
      'name' => 'content',
      'alias' => '内容',
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
    'duixiang' => 
    array (
      'parent' => '0',
      'name' => 'duixiang',
      'alias' => '对象',
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
        1 => '公共',
        2 => '企业',
        3 => '投资者',
        4 => '旅游者',
        5 => '外籍人士',
        6 => '三农',
        7 => '妇女儿童',
        8 => '残疾人',
        9 => '其它',
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'geshi' => 
    array (
      'parent' => '0',
      'name' => 'geshi',
      'alias' => '格式',
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
        1 => 'DOC',
        2 => 'TXT',
        3 => 'JPG',
        4 => 'PDF',
        5 => 'MP3',
        6 => 'MPEG',
        7 => '其它',
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'jigou' => 
    array (
      'parent' => '0',
      'name' => 'jigou',
      'alias' => '机构分类',
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
        1 => '广州市天河区政府',
        2 => '广州市越秀区政府',
        3 => '广州市东山区政府',
        4 => '广州市白云区政府',
        5 => '广州市黄埔区政府',
        6 => '广州市花都区政府',
        7 => '广州市海珠区政府',
        8 => '广州市南沙区政府',
        9 => '广州市荔湾区政府',
        10 => '广州市番禺区政府',
        11 => '广州市萝岗区政府',
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '100',
      'units' => '',
      'description' => '',
    ),
    'shengming' => 
    array (
      'parent' => '0',
      'name' => 'shengming',
      'alias' => '生命周期',
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
        1 => '婴幼儿',
        2 => '青少年',
        3 => '中年',
        4 => '老年',
        5 => '其它',
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '70',
      'units' => '',
      'description' => '',
    ),
    'suoyin' => 
    array (
      'parent' => '0',
      'name' => 'suoyin',
      'alias' => '索引号',
      'type' => 'varchar',
      'list_table' => '1',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
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
      'widget' => 'text',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'ticai' => 
    array (
      'parent' => '0',
      'name' => 'ticai',
      'alias' => '体裁',
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
        1 => '命令',
        2 => '决定',
        3 => '通告',
        4 => '通知',
        5 => '公告',
        6 => '通报',
        7 => '议案',
        8 => '报告',
        9 => '请示',
        10 => '批复',
        11 => '意见',
        12 => '函',
        13 => '会议纪要',
        14 => '其它',
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'wenhao' => 
    array (
      'parent' => '0',
      'name' => 'wenhao',
      'alias' => '文号',
      'type' => 'varchar',
      'list_table' => '1',
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
      'widget' => 'text',
      'widget_addon_attr' => '',
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'xinxifenlei' => 
    array (
      'parent' => '0',
      'name' => 'xinxifenlei',
      'alias' => '信息分类',
      'type' => 'varchar',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '50',
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
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
  ),
);