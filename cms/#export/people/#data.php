<?php
return array (
  'name' => 'people',
  'config' => 
  array (
    'prev&next_item' => '1',
    'admin_edit_template' => 'edit_people',
    'member_edit_template' => 'edit_people',
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
      'alias' => '人物介绍',
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
      'display_order' => '2',
      'units' => '',
      'description' => '',
    ),
    'department' => 
    array (
      'parent' => '0',
      'name' => 'department',
      'alias' => '部门',
      'type' => 'varchar',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '1',
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
      'display_order' => '5',
      'units' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'parent' => '0',
      'name' => 'email',
      'alias' => '领导信箱',
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
    'huodong' => 
    array (
      'parent' => '0',
      'name' => 'huodong',
      'alias' => '领导活动',
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
    'name' => 
    array (
      'parent' => '0',
      'name' => 'name',
      'alias' => '姓名',
      'type' => 'varchar',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '1',
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
      'display_order' => '9',
      'units' => '',
      'description' => '',
    ),
    'speak' => 
    array (
      'parent' => '0',
      'name' => 'speak',
      'alias' => '领导讲话',
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
    'zhiwu' => 
    array (
      'parent' => '0',
      'name' => 'zhiwu',
      'alias' => '职务',
      'type' => 'varchar',
      'list_table' => '1',
      'filterable' => '1',
      'orderby' => '1',
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
      'display_order' => '7',
      'units' => '',
      'description' => '',
    ),
  ),
);