<?php
return array (
  'name' => 'zlku',
  'config' => 
  array (
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
    'copyright' => 
    array (
      'parent' => '0',
      'name' => 'copyright',
      'alias' => '�����꼶',
      'type' => 'tinyint',
      'list_table' => '0',
      'filterable' => '0',
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
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '77',
      'units' => '',
      'description' => '',
    ),
    'softlanguage' => 
    array (
      'parent' => '0',
      'name' => 'softlanguage',
      'alias' => '������Ŀ',
      'type' => 'tinyint',
      'list_table' => '0',
      'filterable' => '0',
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
        8 => '�ۺ�',
        9 => '������Ŀ',
      ),
      'config' => 
      array (
      ),
      'widget' => 'select',
      'widget_addon_attr' => '',
      'display_order' => '66',
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
  ),
);