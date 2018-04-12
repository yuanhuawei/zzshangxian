<?php
return array (
  'name' => 'goods',
  'config' => 
  array (
  ),
  '#fields' => 
  array (
    'attrbutes' => 
    array (
      'parent' => '0',
      'name' => 'attrbutes',
      'alias' => '商品参数',
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
      'display_order' => '33',
      'units' => '',
      'description' => '',
    ),
    'brand' => 
    array (
      'parent' => '0',
      'name' => 'brand',
      'alias' => '品牌',
      'type' => 'varchar',
      'list_table' => '0',
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
      'display_order' => '88',
      'units' => '',
      'description' => '',
    ),
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
      'display_order' => '0',
      'units' => '',
      'description' => '',
    ),
    'market_price' => 
    array (
      'parent' => '0',
      'name' => 'market_price',
      'alias' => '市场价',
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
      'display_order' => '55',
      'units' => '',
      'description' => '',
    ),
    'number' => 
    array (
      'parent' => '0',
      'name' => 'number',
      'alias' => '商品编号',
      'type' => 'varchar',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '30',
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
      'display_order' => '99',
      'units' => '',
      'description' => '',
    ),
    'photo' => 
    array (
      'parent' => '0',
      'name' => 'photo',
      'alias' => '图片',
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
      'display_order' => '40',
      'units' => '',
      'description' => '',
    ),
    'price' => 
    array (
      'parent' => '0',
      'name' => 'price',
      'alias' => '价格',
      'type' => 'varchar',
      'list_table' => '1',
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
      'display_order' => '44',
      'units' => '',
      'description' => '',
    ),
    'size' => 
    array (
      'parent' => '0',
      'name' => 'size',
      'alias' => '规格',
      'type' => 'varchar',
      'list_table' => '0',
      'filterable' => '0',
      'orderby' => '0',
      'not_null' => '1',
      'length' => '30',
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
      'display_order' => '77',
      'units' => '',
      'description' => '',
    ),
    'store' => 
    array (
      'parent' => '0',
      'name' => 'store',
      'alias' => '库存',
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
      'display_order' => '66',
      'units' => '',
      'description' => '',
    ),
  ),
);