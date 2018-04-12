<?php
defined('PHP168_PATH') or die();

/**
* 生成模板缓存
* @param string $template 所选的模板
* @param string $path 模板所在的路径
* @param string $name 模板的文件名
**/
function template_cache($template, $path, $name){
	
	$file = real_path(TEMPLATE_PATH. $template . $path . $name .'.html');
	if(!is_file($file)){
		if(defined('P8_SITES')){ 
			$file = real_path(TEMPLATE_PATH . 'sites/default/' . $path . $name .'.html'); //不存在则尝试用默认模板
		}else{
			if(defined('ISMOBILE') && ISMOBILE==true && !defined('P8_MEMBER') && !defined('P8_HOMEPAGE')){
                $file = TEMPLATE_PATH . 'mobile/default/' . $path . $name .'.html'; //不存在则尝试用默认模板	
            }else{
                $file = TEMPLATE_PATH . 'default/' . $path . $name .'.html'; //不存在则尝试用默认模板	
            }
		}
	}
	
	if(stristr($file, TEMPLATE_PATH) != $file) $file = '';	//TEMPLATE_PATH 以外的文件不允许编译
	
	//提示模板编译错误,如果在生成静态则不提示
	if(!is_file($file)){
		global $P8LANG;
		$str ='<br /><b>'. $P8LANG['no_such_template'] .'01</b><br />{$TEMPLATE_PATH}/'. $template . $path . $name .'.html';
	}else{
		$str = template_compile(file_get_contents($file), $file);
		
		if(count($p = array_filter(explode('/', $name))) >= 2){
			//无限级目录,如 include template($this_module, 'path/1/2/3/.../file');
			array_pop($p);//弹出最后一个,文件来的
			$p = implode('/', $p);
			md(CACHE_PATH .'template/'. $template . $path . $p);
		}else{
			md(CACHE_PATH .'template/'. $template . $path);
		}
		
		write_file(CACHE_PATH .'template/'. $template . $path . $name .'.php', $str);
		return CACHE_PATH .'template/'. $template . $path . $name .'.php';
	}
}

/**
* 编译模板,并返回编译好的内容
* @param string $str 要编译的内容
* @param string $file 要编译的文件,如果为空,就是临时编译的模板
* @return string 编译内容
**/
function template_compile($str, $file = ''){
	$rn = "\r\n";
	$print_EOT = "{$rn}print <<<EOT{$rn}";
	$EOT = "{$rn}EOT;{$rn}";
	$head = "<?php{$rn}defined('PHP168_PATH') or die();$rn";
	
	//可以编译3层子模板,把子模板的内容读取到主模板一起编译
	for($i = 0; $i < 3; $i++){
		$str = preg_replace_callback(
			"/[{$rn}]*(?:<!--)*\{template\s+(\S+)\s+(\S+?)\}(?:-->)*[{$rn}]*/",
			'sub_template',
			$str
		);//### template($obj, $name) ###
		
		$str = preg_replace_callback(
			"/[{$rn}]*(?:<!--)*\{template\s+(\S+)\s+([^\}]+?)\s+([^\}]+?)\}(?:-->)*[{$rn}]*/",
			'sub_template',
			$str
		);//### template($obj, $name, $template) ###
	}
	
	$str = str_replace('<!--{template_init_js}-->', template_init_js(), $str);
	
	//把<!--{if $a > $b}-->转换成{$a > $b}之类, php标签内不能转换
	$str = preg_replace("/<!--\{(?!php)(.*?)\}-->/s", "{\\1}", $str);
	
	//匹配{###}{/###}部分,这部分不参与模板的编译,把匹配的部分存到$template_no_compile
	global $template_no_compile, $template_no_compile_offset;
	preg_match_all("/[{$rn}]*\{###\}([\s\S]*?)\{\/###\}[{$rn}]*/", $str, $template_no_compile);
	$str = preg_replace("/[{$rn}]*\{###\}([\s\S]*?)\{\/###\}[{$rn}]*/", '###php168_template_no_compile###', $str);
	$template_no_compile_offset = 0;
	
	//
	/*$str = str_replace(
		array('<?php', '<?xml ', '<?', '?>', '<!?xml '),
		array('', '<!?xml', '', '', '<?xml '),
		$str
	);*/
	
	//模板的开头和结尾,去掉注释
	$str = preg_replace(
		array(
			"/[$rn]*?{php168}[$rn]{0,2}/",
			"/[$rn]{0,2}{\/php168}[$rn]*/",
			"/([$rn]+)[\t ]+/",
			'/<!--\s*<\?php/s', '/\?>\s*-->/'
		),
		array(
			"{$rn}<?php{$rn}print <<<EOT{$rn}",
			"{$rn}EOT;{$rn}?>",
			"\\1",
			'<?php', '?>'
		),
		$str
	);
	
	//将{$a.b.c} 替换成 (<!--){$a->b->c}(-->), 把.换成->,防止模板中的->被编辑器转义
	$str = preg_replace_callback('/(?:\{|\[)\$\w+?(?:\.)+?.*?(?:\}|\])/', 'replace_template_object', $str);
	
	/*
	语言包为 '语言包{$1}, {$2}, {$3}'
	{$P8LANG['语言包'] $a, 1, 'bbb'}, 后面的参数对应3个{$n}
	转化为echo p8lang($P8LANG['语言包'], array($a, 1, 'bbb'));
	*/
	$str = preg_replace(
		array(
			"/\{\\\$P8LANG\['([^\]]+?)'\]\s+([^\}+?]+)\}/",		//P8LANG
			"/[{$rn}]*?\{if\s+(.+?)\}[{$rn}]*?/",				//if
			"/[{$rn}]*?\\{else\}[{$rn}]*?/",					//else
			"/[{$rn}]*?\{elseif\s+(.+?)\}[{$rn}]*?/",			//elseif
			"/[{$rn}]*?\{\/if\}[{$rn}]*?/",						//endif
		),
		array(
			"{$EOT}echo p8lang(\$P8LANG['\\1'], \\2);{$print_EOT}",
			"{$EOT}if(\\1){{$print_EOT}",
			"$EOT}else{{$print_EOT}",
			"$EOT}elseif(\\1){{$print_EOT}",
			"$EOT}{$print_EOT}",
		),
		$str
	);//### 语言 ###
	
	
	
	/** 处理标签{ **/
	$labels = array();
	$_labels = '';
	if(preg_match_all("/\\\$label\[([^\]]+?)\]\{([^\}]+?)\}/", $str, $m)){
		foreach($m[0] as $k => $v){
			$labels[$m[1][$k]] = $m[2][$k];
		}
		
		$str = preg_replace(
			"/\\\$label\[([^\]]+?)\]\{([^\}]+?)\}/",
			"{$EOT}echo \\\$LABEL->display('\\1', array(\\2));{$print_EOT}",
			$str
		);//### 标签(可以识别页面变量的) ###
	}
	
	
	if(preg_match_all("/\\\$label\[([^\]']+?)\]/", $str, $m)){
		foreach($m[0] as $k => $v){
			$labels[$m[1][$k]] = '';
		}
		
		$str = preg_replace(
			"/\\\$label\[([^\]']+?)\]/s",
			"{\$__label['\\1']}",
			$str
		);//### 标签 ###
	}
	
	$d = debug_backtrace();
	//foreach($d as $k => $v){unset($d[$k]['object'], $d[$k]['args']);}print_r($d);
	$sub_compile_template = 
		stristr(str_replace(array('\\', '\\\\'), '/', $d[2]['file']), CACHE_PATH .'template/') ||
		stristr(str_replace(array('\\', '\\\\'), '/', $d[3]['file']), PHP168_PATH .'modules/label/module.php');
	unset($d);
	
	//初始化标签模块,主模板初始化标签,include 子模板及即时编译的不初始化
	if(!empty($labels)){
		$head .= "{$rn}\$LABEL = &\$core->load_module('label');{$rn}global \$__label;{$rn}".
			($sub_compile_template || !$file ? '' : 'if(!isset($LABEL_POSTFIX))global $LABEL_POSTFIX;'.$rn.' global $SYSTEM, $MODULE,$SITENAME, $ENV, $LABEL_PAGE; $LABEL->init($SYSTEM, $MODULE, $LABEL_PAGE, $SITENAME, $ENV);'. $rn.
			"\$LABEL->postfix(isset(\$LABEL_POSTFIX) ? \$LABEL_POSTFIX : array());".
			"{$rn}\$LABEL->get_data_cache();{$rn}\$__label = array();{$rn}");
	}
	
	$pages = array();
	foreach($labels as $label => $v){
		if(empty($v)){
			if(preg_match('/.*_pages$/', $label)){
				$pages[] = "\$__label['$label'] = '';{$rn}";
			}else{
				$_labels .= "\$__label['$label'] = \$LABEL->display('$label');{$rn}";
			}
		}
	}
	if(!empty($labels) && !$sub_compile_template) $_labels .= "\$LABEL->refresh_labels();{$rn}";
	$head .= implode('', $pages) . $_labels;
	/** 处理标签} **/
	
	
	
	/** 处理插件{ **/
	$plugins = array();
	$_plugins = '';
	if(preg_match_all("/\\\$plugin\[([^\]]+?)\]\{([^\}]+?)\}/", $str, $m)){
		foreach($m[0] as $k => $v){
			$plugins[$m[1][$k]] = $m[2][$k];
		}
		
		$str = preg_replace(
			"/\\\$plugin\[([^\]]+?)\]\{([^\}]+?)\}/",
			"{$EOT}echo empty(\\\$PLUGIN['\\1']) ? '' : \\\$PLUGIN['\\1']->display(array(\\2));{$print_EOT}",
			$str
		);//### 插件(可以识别页面变量的) ###
	}
	
	if(preg_match_all("/\\\$plugin\[([^\]']+?)\]/", $str, $m)){
		foreach($m[0] as $k => $v){
			$plugins[$m[1][$k]] = '';
		}
		
		$str = preg_replace(
			"/\\\$plugin\[([^\]']+?)\]/s",
			"{\$__plugin['\\1']}",
			$str
		);//### 插件 ###
	}
	
	foreach($plugins as $plugin => $v){
		//安装过并且启用的插件才能使用
		$head .= "!empty(\$core->plugins['$plugin']['installed']) && !empty(\$core->plugins['$plugin']['enabled']) && \$PLUGIN['$plugin'] = &\$core->load_plugin('$plugin');{$rn}";
		if(empty($v)){
			$_plugins .= "\$__plugin['$plugin'] = empty(\$PLUGIN['$plugin']) ? '' : \$PLUGIN['$plugin']->display();{$rn}";
		}
	}
	$head .= $_plugins;
	/** 处理插件} **/
	
	
	
	
	$str = preg_replace(
		array(
			"/[{$rn}]*?\{foreach\s+(\S+)\s+(\S+?)\}[{$rn}]*?/",					//foreach $p $k $v
			"/[{$rn}]*?\{foreach\s+(\S+)\s+(\S+)\s+(\S+?)\}[{$rn}]*?/",			//foreach $p $v
			"/[{$rn}]*?\{foreachelse\}[{$rn}]*?/",								//foreachelse
			"/[{$rn}]*?\{\/foreachelse\}[{$rn}]*?/",							//foreachelse
			"/[{$rn}]*?\{\/foreach\}[{$rn}]*?/",								//end foreach
			"/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\([^\{\}]*\))\}/",	//function
			"/[{$rn}]*?\<!--{php\s+([\s\S]+?)\s*\}-->[{$rn}]*?/",				//eval
			"/<!--\s*EOT;\s*/s",												//注释
			"/print\s*<<<EOT\s*-->\s*/",
		),
		array(
			"{$EOT}\$__t_foreach = @\\1;{$rn}if(!empty(\$__t_foreach)){{$rn}".
				"foreach(\$__t_foreach as \\2){{$print_EOT}",
			"{$EOT}\$__t_foreach = @\\1;{$rn}if(!empty(\$__t_foreach)){{$rn}".
				"foreach(\$__t_foreach as \\2 => \\3){{$print_EOT}",
			"{$EOT}else{$rn}{{$print_EOT}",
			"$EOT}{$print_EOT}",
			"$EOT}{$rn}}{$rn}{$print_EOT}",
			"{$EOT}echo \\1;{$print_EOT}",
			"$EOT\\1{$print_EOT}",
			"$EOT",
			"print <<<EOT{$rn}",
		),
		$str
	);//### foreach($l as $v) ###
	
	
	//还原{###}{/###}不编译的部分
	$str = preg_replace_callback('/[\r\n]*###php168_template_no_compile###[\r\n]*/', 'template_no_compile', $str);
	
	//去掉多余的无内容的EOT
	$str = preg_replace(
		array(
			"/\s*print <<<EOT\s*EOT;/",
			"/[$rn]*<\?php\s*\?>[$rn]*/"
		),
		array(
			"",
			""
		),
		$str
	);
	
	$head .= "?>\r\n";
	
	//$str = preg_replace_callback('#<<<(?<EOT>EOT)(.*?)\k<EOT>;#is', '_template_slash', $str);
	$str = preg_replace_callback('#<<<(EOT)(.*?)EOT;#is', '_template_slash', $str);
	
	//检查模板的安全
	template_compile_safe($str, $file);
	
	$str = $head . $str;
	//增加编辑标签的JS, 临时编译的,在模板中用 include template()加载的子模板不管
	if(!empty($labels) && $file && !$sub_compile_template){
		$str .= $rn.
		"<?php{$rn}if(P8_EDIT_LABEL && !defined('P8_GENERATE_HTML')) ".
		'echo "<script type=\"text/javascript\">'.
		'\$(document).ready(function(){'.
			'\$(\'.label\').each(function(){'.
			'\$(this).hover(function(){\$(this).css({\'opacity\':\'0.8\',\'filter\':\'alpha(opacity=80)\'});}, function(){\$(this).css({\'opacity\':\'0.4\',\'filter\':\'alpha(opacity=40)\'});}).'.
				'jqResize($(\'div\', this)).dblclick(function(){'.
					'window.open(\'{$core->admin_controller}/core/label-update?system=$SYSTEM&module=$MODULE&site=$SITENAME&env=$ENV'.
					'&place_holder_width=\'+ \$(this).width() +\'&place_holder_height=\'+ \$(this).height() +\''.
					'&id=\'+ this.id.replace(/[^0-9]/g, \'\') +\''.
					'&postfix=". (empty($_GET[\'postfix\']) ? (empty($LABEL->last_postfix) ? \'\' : $LABEL->last_postfix) : $_GET[\'postfix\']) ."'.
					'&name=\'+ encodeURIComponent($(\'span\', this).html()) +\'&from_js=1'.
					'&page=". $LABEL_PAGE ."'.
					'&_referer=\'+ encodeURIComponent(window.location.href));'.
				'}).bind(\'contextmenu\', function(){'.
					'window.open(\'{$core->admin_controller}/core/label-add?system=$SYSTEM&module=$MODULE&site=$SITENAME&env=$ENV'.
					'&place_holder_width=\'+ \$(this).width() +\'&place_holder_height=\'+ \$(this).height() +\''.
					'&postfix=". (empty($_GET[\'postfix\']) ? (empty($LABEL->last_postfix) ? \'\' : $LABEL->last_postfix) : $_GET[\'postfix\']) ."'.
					'&name=\'+ encodeURIComponent($(\'span\', this).html()) +\'&from_js=1'.
					'&_referer=\'+ encodeURIComponent(window.location.href));'.
					'return false;'.
				'});'.
			'});'.
		'});'.
		'</script>";'.
		"{$rn}?>";
	}
	unset($labels, $_labels, $pages, $head, $plugins, $_plugins);
	
	return $str;
}

/**
* 编译子模板
* @param string $obj 需要提取$obj中的变量来global的对象, 
  如core, this_system, this_module, 假如$obj 为 'core'; 即 $$obj 为 $core;
* @param string $name 模板名称, 可以传变量, a/b/c或 $a/b/$c, 不能传数组,对象
* @param string $template 所选的模板
* @return string 编译好的模板
**/
function sub_template($m){
	
	$obj = substr($m[1], 1);
	global $$obj;
	
	$split = explode('/', $m[2]);
	$name = $comma = '';
	foreach($split as $v){
		if(strlen($v = trim($v)) == 0) continue;
		
		if($v{0} == '$'){
			$var = substr($v, 1);
			global $$var;
			$name .= $comma . $$var;
		}else{
			$name .= $comma . $v;
		}
		
		$comma = '/';
	}
	
	switch($$obj->type){
	
	case 'core':
	case 'system':
		$path = $$obj->name .'/';
	break;
	
	case 'module':
		$path = $$obj->system->name .'/'. $$obj->name .'/';
	break;
	
	default:
		$path = '';
		//子模板编译错误
		global $P8LANG;
		defined('P8_GENERATE_HTML') or exit('<b>'. $P8LANG['sub_template_compile_error'] . $m[0] .'</b>');
	}
	
	global $this_system, $this_module;
	$is_module = is_object($this_module);
	$is_system = $this_system->type == 'system';
    $is_mobile = false;
	//子模板使用优先顺序 module > system > core
	
	if(empty($m[3])){
		
        if(defined('P8_SITES')){
            $template = 'sites/'.(empty($this_system->site['template']) ? 'default' : $this_system->site['template'] ).'/';
            global $SKIN, $RESOURCE;
            $SKIN = $RESOURCE .'/skin/'. $template;
            
        }
        elseif(defined('P8_MEMBER')){
			//会员中心模板
			$template = empty($$obj->CONFIG['member_template']) ? 'member/default/' : $$obj->CONFIG['member_template'] .'/';
		}else if(defined('P8_HOMEPAGE')){
			//个人主页模板
			$template = empty($$obj->CONFIG['homepage_template']) ? 'homepage/default/' : $$obj->CONFIG['homepage_template'] .'/';
		}else{
			//前台模板
			if($is_module){
				if($this_module->core->ismobile){
                    $is_mobile = true;
					$template = empty($this_module->CONFIG['mobile_template']) 
					? (empty($this_system->CONFIG['mobile_template']) ? 'mobile/default' : $this_system->CONFIG['mobile_template'])
					: $this_module->CONFIG['mobile_template'];
				}else{
					$template = empty($this_module->CONFIG['template']) 
					? (empty($this_system->CONFIG['template']) ? 'default' : $this_system->CONFIG['template'])
					: $this_module->CONFIG['template'];
				}
			}else if($is_system){
				if($this_system->core->ismobile){
                    $is_mobile = true;
					$template = empty($this_system->CONFIG['mobile_template']) ? 'mobile/default' : $this_system->CONFIG['mobile_template'];
				}else{	
					$template = empty($this_system->CONFIG['template']) ? 'default' : $this_system->CONFIG['template'];
				}
			}else{
				if($$obj->ismobile){
                    $is_mobile = true;
					$template = empty($$obj->CONFIG['mobile_template']) ? 'mobile/default' : $$obj->CONFIG['mobile_template'];
				}else{	
					$template = empty($$obj->CONFIG['template']) ? 'default' : $$obj->CONFIG['template'];
				}
			}
			$template .= '/';
		}
		
	}else{
		//强制使用的模板
		$template = $m[3] .'/';
		 if(ISMOBILE===true){
           if(strpos($template, 'mobile')===false){
                $template = 'mobile/'.$template;
           }           
        }
	}
	
	$file = real_path(TEMPLATE_PATH . $template . $path . $name .'.html');
	
	//不存在则尝试用默认模板
	if(!is_file($file)){ 
		if(defined('P8_SITES')){
			$file = real_path(TEMPLATE_PATH . 'sites/default/' . $path . $name .'.html');
		}else{
			if($is_mobile){
				$file = real_path(TEMPLATE_PATH .'mobile/default/' . $path . $name .'.html');
			}else{
				$file = real_path(TEMPLATE_PATH .'default/' . $path . $name .'.html');
			}
		}
	}	
	if(stristr($file, TEMPLATE_PATH) != $file) $file = '';	//TEMPLATE_PATH 以外的文件不允许编译
	
	//提示模板编译错误
	if(!is_file($file) && !defined('P8_GENERATE_HTML')){
		global $P8LANG;
		return '<br /><b>'. $P8LANG['no_such_template'] .'02</b><br />{$TEMPLATE_PATH}/'. $template . $path . $name .'.html';
	}
	$str = file_get_contents($file);
	
	unset($template, $file);
	
	//将头部尾部去掉
	$str = preg_replace(
		array("/<!--\s*<\?php\s+print\s*?<<<EOT\s+-->/s", "/<!--\s+EOT;\s+\?>\s*-->/s", "/[\r\n]*?(?:<!--)\{php168\}(?:-->)[\r\n]{0,2}/s", "/[\r\n]{0,2}(?:<!--)\{\/php168\}(?:-->)[\r\n]*?/s"),
		array('', '', '', ''),
		$str
	);
	
	return $str;
}

/**
* preg_replace_callback调用
* 将模板中的$a.b.c换成$a->b->c
**/
function replace_template_object($m){
	return str_replace('.', '->', $m[0]);
}

/**
* preg_replace_callback调用
* 还原模板不编译的部分
**/
function template_no_compile($m){
	global $template_no_compile, $template_no_compile_offset;
	
	return "\r\nEOT;\r\n?>\r\n".
		$template_no_compile[1][$template_no_compile_offset++] .
		"\r\n<?php\r\nprint <<<EOT\r\n";
}

/**
* 模板初始化JS
**/
function template_init_js(){
	$js = <<<EOT
<!--{php
if(!empty(\$this_module->CONFIG['base_domain'])){
	\$_domain = \$this_module->CONFIG['base_domain'];
}else if(!empty(\$this_system->CONFIG['base_domain'])){
	\$_domain = \$this_system->CONFIG['base_domain'];
}else{
	\$_domain = \$core->CONFIG['base_domain'];
}
echo empty(\$_domain) ? '' : 'document.domain = \''. \$_domain .'\';';
echo 'document.base_domain = \''. \$_domain .'\';';
}-->
EOT;
	
	if(defined('P8_ADMIN')){
		$router = '\'{$this_router}\'';
		

		$js = '';
	}else if(defined('P8_MEMBER')){
		$router = 'P8CONFIG.URI[SYSTEM][MODULE].U_controller';
		$js = '';
	}else{
		$router = 'P8CONFIG.URI[SYSTEM][MODULE].controller';
	}
	
	return <<<EOT
P8CONFIG.RESOURCE = '\$RESOURCE';
var SYSTEM = '\$SYSTEM',
	MODULE = '\$MODULE',
	ACTION = '\$ACTION',
	LABEL_URL = '\$LABEL_URL',
	\\\$this_router = $router,
	\\\$this_url = \\\$this_router +'-'+ ACTION,
	SKIN = '\$SKIN',
	TEMPLATE = '\$TEMPLATE';
	mobile_status= '{\$core->CONFIG['enable_mobile']}',
	mobile_auto_jump='{\$core->CONFIG['mobile_auto_jump']}',
	mobile_url = '{\$core->CONFIG['murl']}';
	if(mobile_status=='1'){
        if(browser.versions.android || browser.versions.iPhone || browser.versions.iPad){
			if(mobile_auto_jump=='1' && mobile_url!=P8CONFIG.RESOURCE){
				var this_url = location.href;
				if(this_url.indexOf(mobile_url)==-1 && this_url.indexOf('s.php')==-1 && this_url.indexOf('u.php')==-1 && this_url.indexOf('admin.php')==-1){
					this_url = this_url.replace(P8CONFIG.RESOURCE, mobile_url);
					location.href = this_url;
				}
			}
		}
    }
	$js
EOT;
	
}

//处理斜杠,HEREDOC 中的\x会被转义成x,除\$以外,转换成\\x
function _template_slash($m){
	$m[2] = preg_replace_callback('#\\\\([^\$]{1,1})#', '_template_slash_callback', $m[2]);
	
	return "<<<EOT". $m[2] .'EOT;';
}

function _template_slash_callback($m){
	return $m[1] == '\\' ? '\\\\\\'. $m[1] : '\\\\'. $m[1];
}

/**
* 检查危险的模板代码
**/
function template_compile_safe(&$str, $file = ''){
	
	static $allow_func;
	
	if($allow_func === null){
		//函数白名单
		$allow_func = include PHP168_PATH .'inc/template.allow_func.php';
	}
	
	$var = '[a-zA-Z_\x7f-\xff][0-9a-zA-Z_\x7f-\xff]*';
	
	$d_func = 
		//变量函数不允许使用,如$eval = 'eval'; $eval('code'); $a = 'eval'; $$a(); $a->a();
		'\$[^\(\)\{\}\|\?\.\/\*\s<;=,&!%]+|'.
		
		//危险函数也不允许使用
		'eval|create_function|exec|system|passthru|pcntl_exec|phpinfo|define|dl|'.
		//call_user_func(array(&$core, 'delete')); call_user_func('eval', 'code');
		'call_user_func|call_user_func_array|call_user_method|call_user_method_array|'.
		'register_shutdown_function|register_tick_function|debug_backtrace|debug_print_backtrace|'.
		'show_source|highlight_file|init_session|set_session|delete_session|header|debug_zval_dump|'.
		
		//mysql,ftp相关函数
		'mysql\w+|ftp_\w+|'.
		
		//preg函数, preg_replace('/xx/e', 'file_put'.'_contents("\$1")'); 这样你懂的
		'preg_replace|preg_replace_callback|preg_filter|'.
		
		//文件函数不允许调用
		'opendir|readdir|rmdir|file_get_contents|file_put_contents|file|touch|tmpfile|chown|chgrp|chmod|rename|tempnam|'.
		'fopen|fsockopen|fread|fgets|fclose|fputs|fwrite|unlink|rm|write_file|read_file|readfile';
	
	//$t = preg_replace('/echo|print\s*<<<\s*(?<EOT>\S+)[\s\S]*?\k<EOT>;/i', '', $str);
	$t = preg_replace(
		array(
			//把所有的 print <<<EOT EOT; 去掉剩余的就是PHP代码,检查
			'/echo|print\s*<<<\s*(EOT)[\s\S]*?EOT;/i',
			//去注释
			'!//[^\r\n]*|#[^\r\n]*|/\*[\s\S]*\*/!',
			//
			'/\s+->\s+/i'
		),
		array(
			'',
			'',
			'->'
		),
		$str
	);
	
	$d = array(
		//不允许直接操作数据库
		'db' => '/(DB_master|DB_slave)/i',
		
		//禁止引用赋值 $a = &$this_module->var; , function xx(&$var, &$var2){$var = xxx;}
		'ref' => '/(=|\(|,)\s*&\s*\$/i',
		
		//不允许改session
		'session' => '/(P8SESSION|_P8SESSION)/i',
		
		//多重变量 ${$a} = 'P8SESSION'; $$a $ $a;
		'vvar' => '/\$[\s\{\$]/i',
		
		//危险函数
		'function' => '/('. $d_func .')\s*\([\s\S]*?\)/i',
		
		//不允许创建新对象, $aa = new P8_mysql; $aa = clone $DB_master; $$$aa = new $$bb; ${$a}
		'obj' => '/(?:new|clone)\s+\$*'. $var .'/i',
		
		//禁止给对象赋值
		'assign' => '/\$[a-zA-Z_\x7f-\xff][^-\$]*?->[^=;\(\)\{\}]+?=/i',
		
		//禁止include template()之外的include
		'include' => '/(include_once|require_once|include|require)(?![a-zA-Z0-9_]+|\s+template\()/i'
	);
	//echo $t;
	foreach($d as $k => $v){
		$flag = false;
		$s = '';
		if($k == 'function'){
			if(preg_match_all($v, $t, $m)){
				foreach($m[1] as $i => $func){
					if(empty($allow_func[$func])){
						$s = $m[0][$i];
						$flag = true;
						break;
					}
				}
			}
		}else if(preg_match($v, $t, $m)){
			$s = $m[0];
			$flag = true;
		}
		
		if($flag){
			if(!$file){
				foreach(array_reverse(debug_backtrace()) as $v){
					$file .= str_replace(PHP168_PATH , '', $v['file']) .': '. $v['line'] .'<br />';
				}
			}
			global $P8LANG;
			exit(
				p8lang($P8LANG['template_safe'][''], str_replace(TEMPLATE_PATH, '', $file)) .
				p8lang($P8LANG['template_safe'][$k], nl2br($s))
			);
		}
	}
}