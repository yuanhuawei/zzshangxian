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
      'alias' => '��Դ����',
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
      'alias' => 'ѧ��',
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
        2 => '��ѧ',
        3 => 'Ӣ��',
        4 => '����',
        5 => '��ѧ',
        6 => '����',
        7 => '����',
        8 => '����',
        9 => '����',
        10 => '����',
        11 => '�����뽡��',
        12 => '�Ͷ�����',
        13 => '�ۺ�ʵ��',
        14 => '������������',
        15 => '����������',
        16 => '��������',
        17 => 'Ʒ�������',
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
      'alias' => 'ѧ��',
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
        1 => 'Сѧ',
        2 => '����',
        3 => '����',
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
      'alias' => '��Դ��С',
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
      'alias' => '��Դ��ַ',
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
      'alias' => '��������',
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
      'alias' => '�汾',
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
        1 => '�˽�2001�α��',
        2 => '����2001�α��',
        3 => '��ʦ��2001�α��',
        4 => '�ս�2001�α��',
        5 => '����ʦ��2001�α��',
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
      'alias' => '�꼶',
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
        1 => 'һ�꼶',
        2 => '���꼶',
        3 => '���꼶',
        4 => '���꼶',
        5 => '���꼶',
        6 => '���꼶',
        7 => '���꼶',
        8 => '���꼶',
        9 => '��һ�꼶',
        10 => '�߶��꼶',
        11 => '�����꼶',
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