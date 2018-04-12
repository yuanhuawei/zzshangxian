<?php

return array(
	
	//CMS��ҳͷ��
	array (
	  'system' => $this_system->name,
	  'module' => '',
	  'source_system' => $this_system->name,
	  'source_module' => 'item',
	  'name' => 'CMS��ҳͷ��',
	  'type' => 'module_data',
	  'option' => 
	  array (
		'order_by' => 
		array (
		),
		'pageable' => 0,
		'ids' => '',
		'limit' => 10,
		'title_length' => 40,
		'template' => 'cms/index_top',
		'unset_options' => 
		array (
		),
		'uids' => '',
		'category' => 
		array (
		),
		'attribute' => '2',
		'timestamp' => 
		array (
		  0 => null,
		  1 => null,
		  'exclude' => false,
		),
		'sphinx' => '0',
		'var_fields' => 
		array (
		),
		'model' => 'article',
		'#field' => 
		array (
		),
		'order_by_string' => 'a.timestamp DESC',
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
	  ),
	  'content' => '',
	  'ttl' => '300',
	  'postfix' => 'index',
	),
	
	//��ҳ�õ�
	array (
	  'system' => $this_system->name,
	  'module' => '',
	  'source_system' => $this_system->name,
	  'source_module' => 'item',
	  'name' => 'CMS��ҳ�õ�',
	  'type' => 'module_data',
	  'option' => 
	  array (
		'order_by' => 
		array (
		),
		'pageable' => 0,
		'ids' => '',
		'limit' => 10,
		'title_length' => 40,
		'template' => 'cms/index_flash',
		'unset_options' => 
		array (
		),
		'uids' => '',
		'category' => 
		array (
		),
		'attribute' => '1',
		'timestamp' => 
		array (
		  0 => null,
		  1 => null,
		  'exclude' => false,
		),
		'sphinx' => '0',
		'var_fields' => 
		array (
		),
		'model' => 'article',
		'#field' => 
		array (
		),
		'order_by_string' => 'a.timestamp DESC',
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
	  ),
	  'content' => '',
	  'ttl' => '300',
	  'postfix' => 'index',
	),
	
	
	//��ҳ�Ƽ�
	array (
	  'system' => $this_system->name,
	  'module' => '',
	  'source_system' => $this_system->name,
	  'source_module' => 'item',
	  'name' => 'CMS��ҳ�Ƽ�',
	  'type' => 'module_data',
	  'option' => 
	  array (
		'order_by' => 
		array (
		),
		'pageable' => 0,
		'ids' => '',
		'limit' => 10,
		'title_length' => 40,
		'template' => 'cms/index_recommend',
		'unset_options' => 
		array (
		),
		'uids' => '',
		'category' => 
		array (
		),
		'attribute' => '5',
		'timestamp' => 
		array (
		  0 => null,
		  1 => null,
		  'exclude' => false,
		),
		'sphinx' => '0',
		'var_fields' => 
		array (
		),
		'model' => 'article',
		'#field' => 
		array (
		),
		'order_by_string' => 'a.timestamp DESC',
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
	  ),
	  'content' => '',
	  'ttl' => '300',
	  'postfix' => 'index',
	),
	
	
	//��ҳ����
	array (
	  'system' => $this_system->name,
	  'module' => '',
	  'source_system' => $this_system->name,
	  'source_module' => 'item',
	  'name' => 'CMS��ҳ����',
	  'type' => 'module_data',
	  'option' => 
	  array (
		'order_by' => 
		array (
		  'i.timestamp' => 1,
		),
		'pageable' => 0,
		'ids' => '',
		'limit' => 10,
		'title_length' => 40,
		'template' => 'cms/index_announcement',
		'unset_options' => 
		array (
		),
		'uids' => '',
		'category' => '1',
		'attribute' => '0',
		'timestamp' => 
		array (
		  0 => null,
		  1 => null,
		  'exclude' => false,
		),
		'sphinx' => '0',
		'var_fields' => 
		array (
		),
		'model' => 'article',
		'#field' => 
		array (
		),
		'order_by_string' => 'i.timestamp DESC',
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
	  ),
	  'content' => '',
	  'ttl' => '300',
	  'postfix' => 'index',
	),
	array (
  'id' => '24',
  'system' => 'cms',
  'module' => 'item',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => 'CMS���ݷ�ҳ�б�',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
    ),
    'pageable' => 1,
    'ids' => '',
    'limit' => 10,
    'template' => 'cms/list/article_imghead_summary',
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '60',
    'var_fields' => 
    array (
      'i.cid' => 
      array (
        'operator' => 'in',
        'var' => '$CATEGORY',
      ),
    ),
    'model' => 'article',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 111,
  ),
  'content' => '',
  'variable' => '1',
  'ttl' => '0',
  'postfix' => '',
),
	array (
  'id' => '7',
  'system' => 'cms',
  'module' => 'item',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => 'CMS�ӷ��������б�',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
      'i.timestamp' => 1,
    ),
    'pageable' => 1,
    'ids' => '',
    'limit' => 5,
    'template' => 'cms/list/article_imghead_summary',
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '30',
    'var_fields' => 
    array (
      'i.cid' => 
      array (
        'operator' => 'in',
        'var' => '$subcat',
      ),
    ),
    'model' => '',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'order_by_string' => 'i.timestamp DESC',
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '',
  'variable' => '1',
  'ttl' => '-1',
  'postfix' => '',
),
array (
  'id' => '10',
  'system' => 'cms',
  'module' => 'item',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => '��Ʒ���б�',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
    ),
    'pageable' => 0,
    'ids' => '',
    'limit' => 10,
    'template' => 'cms/list/pic_title_summary',
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '20',
    'var_fields' => 
    array (
      'i.cid' => 
      array (
        'operator' => 'in',
        'var' => '$subcat',
      ),
    ),
    'model' => 'product',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '',
  'variable' => '1',
  'ttl' => '0',
  'postfix' => '',
),
array (
  'id' => '9',
  'system' => 'cms',
  'module' => 'item',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => '��Ʒ��ҳ�б�',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
    ),
    'pageable' => 1,
    'ids' => '',
    'limit' => 10,
    'template' => 'cms/list/prudect_pic_title_summary',
    'category' => 
    array (
    ),
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '20',
    'var_fields' => 
    array (
      'i.cid' => 
      array (
        'operator' => 'in',
        'var' => '$category',
      ),
    ),
    'model' => 'product',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
	//��ҵ����ҳ�����ſ�ʼ
	
	array (
	  'id' => '24',
	  'system' => 'cms',
	  'module' => '',
	  'source_system' => '',
	  'source_module' => '',
	  'name' => 'tab_menu_title_1',
	  'type' => 'html',
	  'option' => 
	  array (
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
		'sphinx' => '0',
	  ),
	  'content' => '<strong>��������</strong>',
	  'variable' => '0',
	  'ttl' => '0', 
	  'postfix' => '',
	),
	
	
	array (
	  'id' => '25',
	  'system' => 'cms',
	  'module' => '',
	  'source_system' => '',
	  'source_module' => '',
	  'name' => 'tab_menu_title_2',
	  'type' => 'html',
	  'option' => 
	  array (
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
		'sphinx' => '0',
	  ),
	  'content' => '<strong>��Ʒ����</strong>',
	  'variable' => '0',
	  'ttl' => '0',
	  'postfix' => '',
	),
	
	
	array (
	  'id' => '13',
	  'system' => 'cms',
	  'module' => '',
	  'source_system' => '',
	  'source_module' => '',
	  'name' => 'tab_menu_title_5',
	  'type' => 'html',
	  'option' => 
	  array (
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
		'sphinx' => '0',
	  ),
	  'content' => '��˾����',
	  'variable' => '0',
	  'ttl' => '0',
	  'postfix' => '',
	),
	
	
	array (
	  'id' => '12',
	  'system' => 'cms',
	  'module' => '',
	  'source_system' => '',
	  'source_module' => '',
	  'name' => 'tab_menu_title_4',
	  'type' => 'html',
	  'option' => 
	  array (
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
		'sphinx' => '0',
	  ),
	  'content' => '��������',
	  'variable' => '0',
	  'ttl' => '0',
	  'postfix' => '',
	),
	
	
	array (
	  'id' => '11',
	  'system' => 'cms',
	  'module' => '',
	  'source_system' => '',
	  'source_module' => '',
	  'name' => 'tab_menu_title_3',
	  'type' => 'html',
	  'option' => 
	  array (
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
		'sphinx' => '0',
	  ),
	  'content' => '�����̴���',
	  'variable' => '0',
	  'ttl' => '0',
	  'postfix' => 'index',
	),
	array (
  'id' => '14',
  'system' => 'cms',
  'module' => '',
  'source_system' => '',
  'source_module' => '',
  'name' => 'index_tab_content_1_1',
  'type' => 'html',
  'option' => 
  array (
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '<span style="font-size: 14px;"><span style="color: rgb(153, 0, 0);"><strong>���Ŷ�̬</strong></span></span>',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
array (
  'id' => '25',
  'system' => 'core',
  'module' => '',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => 'index_tab_content_1_2',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
    ),
    'pageable' => 0,
    'ids' => '',
    'limit' => 8,
    'template' => 'cms/list/head_pic',
    'category' => '3',
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '36',
    'var_fields' => 
    array (
    ),
    'model' => 'article',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
array (
  'id' => '8',
  'system' => 'cms',
  'module' => '',
  'source_system' => '',
  'source_module' => '',
  'name' => 'index_tab_content_2_1',
  'type' => 'html',
  'option' => 
  array (
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '<span style="color: rgb(153, 0, 0);font-size: 14px;font-weight:bold">��Ʒչʾ</span>',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
array (
  'id' => '11',
  'system' => 'core',
  'module' => '',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => 'index_tab_content_2_2',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
    ),
    'pageable' => 1,
    'ids' => '',
    'limit' => 3,
    'template' => 'cms/list/pic_title_summary',
    'category' => '3,4,5,6',
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '20',
    'var_fields' => 
    array (
    ),
    'model' => 'article',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
array (
  'id' => '12',
  'system' => 'cms',
  'module' => '',
  'source_system' => '',
  'source_module' => '',
  'name' => 'index_tab_content_3_1',
  'type' => 'html',
  'option' => 
  array (
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '<span style="color: rgb(153, 0, 0);font-size: 14px;font-weight:bold">�ɹ�����</span>',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
array (
  'id' => '13',
  'system' => 'core',
  'module' => '',
  'source_system' => 'cms',
  'source_module' => 'item',
  'name' => 'index_tab_content_3_2',
  'type' => 'module_data',
  'option' => 
  array (
    'order_by' => 
    array (
    ),
    'pageable' => 0,
    'ids' => '',
    'limit' => 6,
    'template' => 'cms/list/pic_title_3',
    'category' => 
    array (
    ),
    'attribute' => '0',
    'sphinx' => '0',
    'title_length' => '26',
    'var_fields' => 
    array (
    ),
    'model' => 'article',
    'uids' => '',
    'timestamp' => 
    array (
      0 => NULL,
      1 => NULL,
      'exclude' => false,
    ),
    '#field' => 
    array (
    ),
    'allowed_roles' => 
    array (
    ),
    'place_holder_width' => 100,
    'place_holder_height' => 30,
  ),
  'content' => '',
  'variable' => '0',
  'ttl' => '0',
  'postfix' => '',
),
//��ҵ����ҳ�����Ž���
	
	array (
	  'id' => '17',
	  'system' => 'cms',
	  'module' => 'item',
	  'source_system' => '',
	  'source_module' => '',
	  'name' => 'company_top_ad',
	  'type' => 'html',
	  'option' => 
	  array (
		'allowed_roles' => 
		array (
		),
		'place_holder_width' => 100,
		'place_holder_height' => 30,
	  ),
	  'content' => '<img alt="" src="http://sale.php168.com/upload_files/label/1_20090528150556_7r4ad.jpg" style="width: 960px; height: 190px;" /><br />
	',
	  'variable' => '0',
	  'ttl' => '0',
	  'postfix' => '',
	)
);