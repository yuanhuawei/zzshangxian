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
    'duixiang' => 
    array (
      'parent' => '0',
      'name' => 'duixiang',
      'alias' => '����',
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
        1 => '����',
        2 => '��ҵ',
        3 => 'Ͷ����',
        4 => '������',
        5 => '�⼮��ʿ',
        6 => '��ũ',
        7 => '��Ů��ͯ',
        8 => '�м���',
        9 => '����',
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
      'alias' => '��ʽ',
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
        7 => '����',
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
      'alias' => '��������',
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
        1 => '���������������',
        2 => '������Խ��������',
        3 => '�����ж�ɽ������',
        4 => '�����а���������',
        5 => '�����л���������',
        6 => '�����л���������',
        7 => '�����к���������',
        8 => '��������ɳ������',
        9 => '����������������',
        10 => '�����з�خ������',
        11 => '�������ܸ�������',
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
      'alias' => '��������',
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
        1 => 'Ӥ�׶�',
        2 => '������',
        3 => '����',
        4 => '����',
        5 => '����',
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
      'alias' => '������',
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
      'alias' => '���',
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
        1 => '����',
        2 => '����',
        3 => 'ͨ��',
        4 => '֪ͨ',
        5 => '����',
        6 => 'ͨ��',
        7 => '�鰸',
        8 => '����',
        9 => '��ʾ',
        10 => '����',
        11 => '���',
        12 => '��',
        13 => '�����Ҫ',
        14 => '����',
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
      'alias' => '�ĺ�',
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
      'alias' => '��Ϣ����',
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