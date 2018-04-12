<?php

return array(
	
	'add_office_category' => '添加栏目',
	'add_office_sub_category' => '添加子栏目',
	'update_office_category' => '栏目设置',
	
	'office_category_model' => '模型',
	'office_category_list' => '栏目列表',
	'office_parent_category' => '所属栏目',
	'office_parent_category_error' => '父栏目有误',
	'office_category_order' => '排序',
	'office_category_addible' => '是否可以发布内容',
	'office_category_list_template' => '栏目列表页模板',
	'office_category_view_template' => '栏目内容页模板',
	'office_category_list_pages_template' => '栏目列表页分页模板',
	'office_category_view_pages_template' => '栏目内容页分页模板',
	'office_category_pages_template_note' => '对应语言包中的键值，在语言包中做好分页模板之后把键值填入。',
	'office_category_item_template' => '栏目列表显示样式',
	'office_category_item_count' => '内容数',
	'office_category_merge' => '合并栏目',
	'office_category_fix' => '重新统计栏目内容数',
	'office_category_frame' => '封面图片',

	'office_category_type_1' => '大分类(不可发内容)',
	'office_category_type_1_s' => '大分类',
	'office_category_type_2' => '栏目',
	'office_category_type_2_s' => '栏目',
	'office_category_type_3' => '外链(可建立一个链接并指向任意网址)',
	'office_category_type_3_s' => '外链',
	'office_category_outlink' => '外链地址',
	'office_category_outlink_can_not_be_empty' =>'链接地址不能为空',
	'office_category_outlink_note' => '前面要加上http://',
	'office_category_domain_note' => '域名格式: http://news.168.com 后面不带/。绑定后去你的DNS那里绑定二级域名到分类的目录，目录即是“静态页存放路径”一栏{$DOCUMENT_ROOT}的后面那段，URL规则一定要使用{$category_url}才行。如果本分类中有子分类的话，子分类将自动继承域名设置。',
	
	'office_category_content_orderby' => '列表页排序',
	'office_category_sun_orderby' => '子栏目排序方式',
	'office_category_order_by_default' => '默认',
	'office_category_order_by_views' => '点击率',
	'office_category_order_by_comments' => '评论次数',
	'office_category_no_item_yet' => '本栏目还没添加内容',
	'office_category_type_1_no_item_label' => '大分类不可编辑内容标签',
	
	'office_categort_sun_show_num' => '每个子栏目显示多少条内容',
	'office_categort_sun_show_item' =>'条',
	
	'office_category_Commentable' => '启用评论',
	'office_category_Comments_open' => '启用评论',
	'office_category_Comments_close' => '禁止评论',
	
	'office_category_name_can_not_be_empty' => '栏目名称不能为空',
	'office_category_model_can_not_be_empty' => '栏目所属模型必须选择',
	'top_office_category' => '顶级栏目',
	
	'office_category_update_order' => '修改栏目排序',
	'office_category_apply_to_sub_categories' => '应用到子分类',
	
	'top_office_notes_2'=>'注:要想一次批量创建多个栏目,每个栏目名称换一行.',
	'top_office_notes_3'=>'(不选择将成为一级栏目) ',
	
	'office_category_type'=>'类型',
	'office_category_view_page_label' => '内容页标签',
	'office_category_label_postfix' => '独立标签后缀',
	'office_category_label_postfix_note' => '可以使当前分类的标签不同于其它分类,也可以与其中几个相同后缀(如都是category_xx)的共用',
	
	'office_category_html_path' => '静态页存放路径',
	'office_category_html_path_note' => '如果静态列表、内容页规则不使用{$category_url}的话将不起作用，如果你要将分类绑定域名，并且让子分类继承域名，一定要把HTML URL规则设置成{$category_url}的路径',
	'office_category_html_path_exists' => '静态页路径重复',
	'office_category_html_list_rule_note' => '<br />
		{$core_url}: 核心URL<br />
		{$system_url}: 当前系统的URL<br />
		{$category_url}: 当前分类的URL<br />
		{$id}: 当前分类的ID<br />
		{$page}: 页码<br />
		##包围部分表示页码大于1才会使用',
	
	'office_category_html_view_rule_note' => '<br />
		{$core_url}: 核心URL<br />
		{$system_url}: 当前系统的URL<br />
		{$category_url}: 内容所属分类的URL<br />
		{$id}: 当前内容的ID<br />
		{$Y}: 年份,如2010<br />
		{$m}: 月份,如01,11<br />
		{$d}: 天,如01,11<br />
		{$H}: 小时,如01,11<br />
		{$page}: 页码<br />
		##包围部分表示页码大于1才会使用',
	
	'office_category_confirm_to_delete' => '删除分类会连所属分类的内容一起删除,确认删除吗?',
	
	'office_config'=>'基本设置',
	'office_config_style'=>'风格设置',
	'office_config_material'=>'材料設置',
	'office_config_office'=>'办事設置',
	'office_exten_filed'=>'扩展字段',
	'office_config_other'=>'其它设置',
	'office_config_work'=>'工作设置',
	'htmlstatus'=>'静态化',
	'if_material'=>'是否需上交材料',
	'materials'=>'材料設定',
);