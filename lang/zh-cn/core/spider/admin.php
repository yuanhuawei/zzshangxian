<?php
//后台管理语言包

return array(
	
	'spider' => array(
		'rule' => array(
			'' => '采集规则',
			'add' => '添加采集规则',
			'update' => '修改采集规则',
			'timeout' => '连接时长',
			'timeout_hint' => '连接以及下载附件的处理时长,单位为“秒”,0为不限时',
			'name' => '规则名称',
		),
		'hook_delete' => '删内容时需要同时删除采集的附件吗？如果你的内容已经入库，那么不要删除。如果没入库的内容，建议删除。点击“确定”为保存，“取消”为删除。',
		'run' => '采集',
		'clear_stat' => '清空重复统计',
		'category' => '规则分类',
		'item' => '采集内容',
		'x_items_found' => '检索到{$1}条内容，准备采集',
		'capture_list' => '正在采集，剩余{$1}条内容',
		'capture_item_page' => '正在采集“{$1}”内容分页，{$2}条剩余',
		'done' => '完成，耗时{$1}秒',
		'refresh' => '如果长时间没有反应,请按<input type="submit" value="刷新" />',
		'task_running' => '
		<form id="run" method="post" action="">
			<input type="hidden" name="start" value="1" />
			<input type="hidden" name="id" value="{$1}" />
		</form>
		当前规则任务正在执行中, 任务已锁定<br />
			如果你是上次中断的任务, 你可以重新<input type="button" value="执行" onclick="document.getElementById(\'run\').submit();" /><br />
			如果你想重新运行, 你可以手动解锁',
		'unlock' => '解除锁定',
		
		'rule_hint' => '
			首先，抽几分钟了解一下正则匹配符。因为规则语法基于正则表达式。
			<ul>
				<li><font color="red">.</font> 可以匹配任意字符</li>
				<li><font color="red">\s</font> 任意空格，换行符。 <font color="red">\S</font> 与 <font color="red">\s</font> 恰好相反。非空格、换行符的任意字符。下同。</li>
				<li><font color="red">\d</font> 任意数字。 <font color="red">\D</font> 与 <font color="red">\d</font> 恰好相反。</li>
				<li><font color="red">\w</font> 任意字母。 <font color="red">\W</font> 与 <font color="red">\w</font> 恰好相反。</li>
				<li><font color="red">[^abc\s]</font> 空格，字母a,b,c以外的任意字符。</li>
				<li><font color="red">r(o|u|a)ck</font> 匹配rock, ruck, rack其中一个。</li>
				<li><font color="blue">*</font> 出现0或任意次。<font color="blue">+</font> 出现1次以上。<font color="blue">?</font> 出现0或1次。</li>
				<li><font color="blue">.*</font> 匹配任意字符，包括空字符。</li>
				<li><font color="blue">.+</font> 必须匹配字符，非空字符。</li>
				<li><font color="blue">.?</font> 字符出现0次或1次。</li>
				<li><font color="blue">.*?</font> 字符出现任意次，但尽可能少。</li>
				<li><font color="blue">.+?</font> 字符出现1次以上，但尽可能少。</li>
				<li><font color="blue">[\s]+?</font> 1个以上的空格，但尽可能少。</li>
				<li><font color="blue">[^a-z0-9A-Z\s]+?</font> 1个以上的非数字,非字母,非空格字符，但尽可能少。</li>
			</ul>
			<a href="http://deerchao.net/tutorials/regex/regex.htm" target="_blank"><b>点击了解更多正则相关语法</b></a><br />
			
			<br />
			自定义匹配规则可以让你自己定义要捕获的数据。<br />
			<font color="red">{#规则名称,英文如some#正则}</font>,提取之后的数据的数组中，有键名为some的匹配项，对应正则<font color="blue">(?&lt;some&gt;正则)</font>
			<font color="red">{#title#提取标题}</font><br />
			<font color="red">&lt;div class="content"&gt;内容{#content#(*)}&lt;/div&gt</font><br />
			<font color="red">{#author#提取正则}</font><br />
			<font color="red">{#some|all#提取正则}</font>匹配所有，将结果返回数组<br />
			<font color="red">{#some|capture_image#提取正则}</font>把内容中的图片保存到本地。<br />
			<font color="red">{#some|capture#提取正则}</font>匹配并把远程文件上传到本服务器<br />
			<font color="red">{#some|forward:1#提取正则}</font>匹配并向前跳转，forward:n，n代表最多向前跳转的次数，避免死循环。通常写1就可以了。<br />
			<font color="red">{#some|all|capture#提取正则}</font>可以共用<br />
			(*)匹配所有字符，对应正则(.*)<br />
			(*?)匹配所有字符，但匹配尽可能少，对应正则(.*?)<br />
			<font color="blue">{#pages#}是特殊规则。代表分页，如果你不使用分页提取的话，可以用这个来提取下一页。从而达到提取所有分页的效果。如&lt;a href="{#pages#[^"]+?}" target="_self" class="s1"&gt;下一页&lt;/a&gt;</font><br /><br />
			当匹配符匹配的太广泛时，这时使用截取上下文可以缩小搜索范围，结果更精准，截取上下文不支持正则，注意！<br />
			<font color="red">特殊字符（*,^,$,.,#,?,{,},(,),+,|），要用\转义，即 \特殊字符，如\.，\*</font><br /><br />
			生成的正则均有is修饰符，即不区分大小写、可以匹配换行符。正则的分隔符为 #正则#is。注意运用(*?)<br /><br />
			替换支持正则，以&lt;###&gt;分隔，如果替换成空字符时分隔符可以不写。左边是要替换的正则，右边是要替换的字符，如：&lt;/?(iframe|script)([^&gt;]*)&gt;可以把iframe和script标签去除，替换字符中可以使用$1代表第一处匹配的正则，$2代表第二处，依此类推。<br />
			例子：<font color="red">&lt;(/?p)&gt;&lt;###&gt;&lt;div&gt;</font><br />
			如果替换字符为[#NOT#]，可以忽略匹配到的数据不采集。
			<br /><br />
			尽量保证没有换行，换行可以用(*?)表示。有换行符有可能匹配不到。',
		'input_tag_name' => '输入要过滤的标签名称',
		'reg_rule' => array(
			'指定标签以及标签内容' => 'tag_all',
			'指定标签' => 'tag',
			'超链接' => '</?a[^>]*?>',
			'HTML注释' => '<!--.*?-->',
			'iframe' => '</?iframe[^>]*?>',
			'脚本' => '</?script[^>]*?>',
		)
	),
	
	'_module_category_admin_log' => '采集规则分类管理',
	
	'_module_rule_admin_log' => '采集规则管理',
	'_module_item_admin_log' => '采集内容管理',
	
	'_module_add_rule_admin_log' => '添加采集规则',
	'_module_update_rule_admin_log' => '修改采集规则',
	'_module_delete_rule_admin_log' => '删除采集规则',
	
	'_module_delete_item_admin_log' => '删除采集内容',
	'_module_walk_admin_log' => '采集内容',
	
);