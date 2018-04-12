<?php

return array(
	
	'sites_item' => array(
		'add' => '添加内容',
		'update' => '修改内容',
		'addon' => '追加内容',
		'update_addon' => '修改追加内容',
		'move' => '移动内容',
		'clone' => '签发到多个栏目',
		'filter_by_category' => '按分类筛选',
		'no_category_privilege' => '你没进行对当前分类操作的权限',
		'search_by_keyword' => '按关键字',
		'search_by_id' => '按ID',
		'all' => '所有内容',
		'my_item' => '我的内容',
		
		'author' => '作者',
		'pages' => '页数',
		'page' => '页码',
		'list' => '内容列表',
		'title_color' => '颜色',
		'title_bold' => '加粗',
		
		'title_required' => '内容标题必须填写',
		'title_oversize' => '内容标题不得超过80',
		
		'title' => '内容标题',
		'category' => '内容栏目',
		'category_work' => '办事类别',
		'program' => '办事项目',
		'category_required' => '分类必须填写',
		'assistant_category' => '副栏目',
		
		'fee' => '内容收费',
		'no_fee' => '不收费',
		'count' => '数量',
		'html_at_once' => '马上生成HTML',
		
		'unverified' => '未审核',
		'all_unverified' => '所有未审核',
		'verified' => '已审核',
		'verify' => array(
			'' => '审核',
			'wait' => '内容已提交,请耐心等待审核',
			'wait_again' => '修改已提交,请耐心等待重新审核',
			'changed' => '你发布的内容审核状态有改动',
			'changed_message' => '你发布的内容%s通过 %s。理由如下:<br />%s',
			'reason' => '审核理由',
			
			1 => '终审',
			0 => '取消审核',
			-99 => '退稿',
		),
		
		
		'frame' => '封面图片',
		'summary' => '内容摘要',
		'summary_oversize' => '内容摘要只能写100字',
		'sub_title' => '副标题',
		'sub_title_hint' => '副标题|超链接',
		'source' => '内容出处',
		'author' => '作者',
		'editer' => '编辑',
		'create_time' => '发布时间',
		'source_hint' => '来源名称|来源URL',
		'addon_title' => '追加标题',
		'addon_summary' => '追加摘要',
		'url' => '跳转地址',
		'url_note' => '跳转地址,设置之后不会跳到内容页,可以写变量如{$core.url}或{$core.controller}等',
		
		'attribute_hint' => '',
		'set_attribute' => '设置内容属性',
		'delete_attribute' => '删除内容属性',
		'attribute_timestamp' => '内容属性设置时间',
		'attribute_last_setter' => '属性设置人',
		'keyword_hint' => '作为相关内容的索引,如多个用 , 隔开,不要用 - 符号,可以用 _ 代替',
		
		'list_page_cache_ttl' => '列表页页面缓存时间',
		'view_page_cache_ttl' => '内容页页面缓存时间',
		
		'member_collected' => '此内容已经被收藏',
		'member_success' => '内容收藏成功',
		'member_fail' => '内容收藏失败',
		
		//'comment_quote_1st' => $a1 . $a2 .'引用{$1}的原帖'. $a3 .'{$2}'. $a4,
		//'comment_quote' => $a1 .'{$1}'. $a2 .'引用{$2}的原帖'. $a3 .'{$3}'. $a4,
		'comment_success' => '评论成功',
		'comment_denied' => '评论功能已经禁用',
		'comment_e-friend' => '网友',
		'forbidden_comment' => '禁止评论',
		
		'attribute' => array(
			'' => '内容属性',
			'hint' => '内容属性没有意义，仅仅是标记，关键在于你在标签里面如何读取，以及在模板上的表现',
			
			1 => '首页幻灯',
			2 => '首页头条',
			3 => '列表页幻灯',
			4 => '列表页头条',
			5 => '推荐',
			6 => '图片',
			7 => '频道页幻灯',
			8 => '频道页头条',
		),
		
		'cluster_setting_missing' => '站群配置没有设置好',
		'cluster_push' => '推送数据',
		
		'field_required' => '此字段必须填写',
		
		'html_view_url_rule' => '内容页URL规则',
		'html_view_url_rule_oversize' => '规则只能在80字符以内',
		'navigation' => '栏目导航样式',
		
		'push_back_title' => '你发的内容被退稿了',
		'push_back_message' => '你发的内容:{$1}被退稿了。理由如下:<br />{$2}',
		
		'ip' => '内容发布IP',
		'last_update_ip' => '最后修改IP',
		
		'htmlize' => array(
			'list' => '列表页静态',
			'view' => '内容页静态',
			'thread' => '线程{$1}',
			'done' => '生成完成，耗时 {$1} 秒',
			'view_process' => '正在生成{$1}/{$2}页',
			'list_process' => '{$1}/{$2}个分类, “{$3}” {$4}/{$5}页',
			'list_skip' => '{$1}/{$2}分类 不生成--跳过',
		),
		
		'list_order' => array(
			'' => '排序',
			'up' => '置顶',
			'up_to' => ' 置顶到 {$1}',
			'up_to_1d' => '置顶1天',
			'up_to_1w' => '置顶1周',
			'up_to_1m' => '置顶1月',
			'down' => '下沉',
			'down_to' => ' 下沉到 {$1}',
			'down_to_1d' => '下沉1天',
			'down_to_1w' => '下沉1周',
			'down_to_1m' => '下沉1月',
			'note' => '列表页排序条件, 你可以设置未来的时间实现内容置顶, 也可以设置以前的时间实现内容下沉, 设置为空则为还原',
		),
		
		'view_url_rule_note' => '<br />
			{$core_url}: 核心URL<br />
			{$system_url}: 当前系统的URL<br />
			{$category_url}: 内容所属分类的URL<br />
			{$id}: 当前内容的ID<br />
			{$cid}: 当前内容所属分类的ID<br />
			{$Y}: 年份,如2010<br />
			{$m}: 月份,如01,11<br />
			{$d}: 天,如01,11<br />
			{$H}: 小时,如01,11<br />
			{$page}: 页码<br />
			##包围部分表示页码大于1才会使用',
	),
	
	'sites_item_list_of_somebody' => '{$1}的内容',
	
	//分页模板
	'sites_item_page' => '{prev_page:<a href="$link">上一页</a>|default:<a href="###">上一页</a>}
{prev_layout:<a href="$link">&lt;&lt;</a>|default:<a href="###">&lt;&lt;</a>}
{pages: <a href="$link">$page</a> |default: <span>$page</span> }
{next_layout:<a href="$link">&gt;&gt;</a>|default:<a href="###">&gt;&gt;</a>}
{next_page:<a href="$link">下一页</a>|default:<a href="###">下一页</a>}',
	
);