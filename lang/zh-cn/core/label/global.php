<?php

return array(
	'exclude' => '不包含',
	'select_label_type' => '选择标签类型',
	'list_label' => '标签列表',
	'list_label_all' => '所有标签(带后缀)',
	'cache_label' => '更新标签缓存',
	'cache_label_data' => '更新标签数据缓存',
	'add_label' => '添加标签',
	'update_label' => '修改标签',
	'copy_label' => '复制标签',
	'label_hover_hint' => '点击鼠标可以缩放大小, 双击编辑标签, 右击创建新标签(有独立标签后缀的页面才有效)',
	
	'new_label' => '新标签',
	'label_search' => '标签搜索',
	'label_name' => '标签名称',
	'label_invoke' => '标签调用',
	'label_type' => array(
		'' => '标签类型',
		'sql' => '自定义SQL标签',
		'html' => '自定义HTML标签',
		'flash' => 'FLASH标签',
		'slide' => '幻灯片标签',
		'image' => '图片标签',
		'module_data' => '模块数据标签',
	),
	'label_content' => '标签内容',
	'label_order_by' => '排序',
	'label_limit' => '记录数',
	'label_desc' => '降序排序',
	'label_asc' => '升序排序',
	'label_cache' => '缓存时间',
	'label_last_update' => '上次更新',
	'label_template' => '标签模板',
	'label_template_dir' => '标签模板目录',
	'label_scope' => '标签显示域',
	'label_hide' => '隐藏标签',
	'label_submit_fail_note' => '如果提交不了，请检查是否填写了标签名称，或者标签的模板语法有误。标签模板里不要再放标签，但可以放变量标签，标签引用自身会造成死循环。',
	
	'label_scope_note' => '如选择了"CMS系统",不选模块,那么此标签可以在CMS系统下任何页面,包括其所有模块页面调用<br />
	如选择了"CMS系统","内容模块",那么此标签只能在 "CMS系统的内容模块" 下的模板调用<br />
	如果选择"核心",不选模块,那么全站模板都可以调用这条标签<br />
	如果设置有后缀,可以针对如某个分类ID为99,后缀为category_99,那么就可以针对这个后缀来设置独立的标签,仅在后缀为category_99的模板页面调用',
	
	'label_postfix' => '标签后缀',
	'label_postfix_note' => '标签后缀为了标签显示域的命名空间，能使同一显示域有更多的命名空间，此值最好不懂不要修改',
	
	'create_label_template_backup' => '创建标签模板备份',
	'edit_label_template' => '编辑标签模板',
	'copy_label_template_hint' => '请输入复制新的标签模板名称,不能与已存在的模板同名。',
	'no_such_label_template' => '此模板不存在',
	'label_template' => '标签模板',
	'label_ttl' => '标签缓存时间',
	'label_ttl_note' => '单位 秒, 缓存周期内将不会读取数据库,设置0为永不更新, -1为即时更新',
	'label_allowed_roles' => '允许查看此标签内容的角色',
	'label_allowed_roles_note' => '不选为全部都有权限',
	'label_data_source_module' => '标签数据源模块',
	'label_duplicate' => '标签重复',
	'label_name_invalid' => '标签名非法',
	'label_add_order_by' => '添加排序条件',
	'label_module_ids' => '指定特定ID',
	'label_module_ids_note' => '以半角 , 分隔，最后不要加, 如1,2,3',
	'label_module_uids' => '指定用户ID',
	'label_module_uids_note' => '以半角 , 分隔，最后不要加, 如1,2,3,可以引用页面上的变量，如$uid, $data[\'uid\']',
	
	'label_not_available_on_this_module' => '这个模块没有标签可调用',
	
	'label_name_can_not_be_empty' => '标签名不能为空',
	'label_template_can_not_be_empty' => '标签模板不能为空',
	
	'explain_sql' => '解析SQL语句',
	'explain_sql_possible_key' => '可能用到的索引',
	'explain_sql_key' => '实际用到的索引',
	'explain_sql_ref' => '引用',
	'explain_sql_rows' => '检索的行数',
	'explain_sql_extra' => '额外',
	
	'explain_sql_note' => '查看“<font color="blue">实际用到的索引</font>”项查看SQL查询是否用到了索引，如果没有用到索引尽量优化语句<br />
	“<font color="blue">检索的行数</font>”项说明查询需要检索多少行才能得出结果，如果“<font color="blue">类型</font>”项为ALL，那么用到了整表扫描，需要优化<br />
	如果“<font color="blue">额外</font>”项出现了<font color="red">Using temporary</font>或<font color="red">Using filesort</font>字样，那么说明这个SQL是有问题的<br />
	<font color="red">Using temporary</font>需要一个额外的临时表，<font color="red">Using filesort</font>需要一次额外的排序，而不是索引排序，当然不是所有查询都能避免额外排序(Using filesort)，但是临时表(Using temporary)能避免尽量避免',
	
	'label_op_eq' => '等于',
	'label_op_set' => '范围',
	'label_op_gt' => '大于',
	'label_op_lt' => '小于',
	'label_op_search' => '搜索',
	
	'label_pageable' => '是否可分页',
	
	'var_label' => '变量标签',
	'gotoview' => '点击浏览效果',
	'gotoedit' => '继续修改',
	'gotolabel' => '返回专题',
	'label_bgcolor' => '半透膜颜色',
	'label_ssi' => 'SSI调用',
	'label_env' => '显示平台',
	'label_mobile' => '移动端',
	'label_ssi_note' => 'SSI(服务端包含)，一般用于已经生成HTML内容页，其中标签改动了，使用SSI，可以不必重新生成内容页',
	
	'no_label_scope_privilege' => '你没有编辑当前显示域标签的权限',
	
	'label_template_syntax_error' => '标签模板语法有误'
	
);