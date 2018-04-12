<?php
defined('PHP168_PATH') or die();

$LABEL = &$core->load_module('label');
global $__label;
if(!isset($LABEL_POSTFIX))global $LABEL_POSTFIX;
 global $SYSTEM, $MODULE,$SITENAME, $ENV, $LABEL_PAGE; $LABEL->init($SYSTEM, $MODULE, $LABEL_PAGE, $SITENAME, $ENV);
$LABEL->postfix(isset($LABEL_POSTFIX) ? $LABEL_POSTFIX : array());
$LABEL->get_data_cache();
$__label = array();
$__label['group01_top_1'] = $LABEL->display('group01_top_1');
$__label['group01_top_pic01'] = $LABEL->display('group01_top_pic01');
$__label['group01_top_pic02'] = $LABEL->display('group01_top_pic02');
$__label['group01_top_2'] = $LABEL->display('group01_top_2');
$__label['group01_banner'] = $LABEL->display('group01_banner');
$__label['group01_n1'] = $LABEL->display('group01_n1');
$__label['group01_n2'] = $LABEL->display('group01_n2');
$__label['group01_n3'] = $LABEL->display('group01_n3');
$__label['group01_focusNews'] = $LABEL->display('group01_focusNews');
$__label['group01_flashnews'] = $LABEL->display('group01_flashnews');
$__label['group01_focusNews2'] = $LABEL->display('group01_focusNews2');
$__label['group01_flashnews2'] = $LABEL->display('group01_flashnews2');
$__label['group01_focusNews3'] = $LABEL->display('group01_focusNews3');
$__label['group01_flashnews3'] = $LABEL->display('group01_flashnews3');
$__label['group01_shbox1'] = $LABEL->display('group01_shbox1');
$__label['group01_shbox2'] = $LABEL->display('group01_shbox2');
$__label['group01_shbox4'] = $LABEL->display('group01_shbox4');
$__label['group01_btn'] = $LABEL->display('group01_btn');
$__label['group01_n6'] = $LABEL->display('group01_n6');
$__label['group01_foot_1'] = $LABEL->display('group01_foot_1');
$__label['group01_foot_2'] = $LABEL->display('group01_foot_2');
$__label['group01_foot_pic'] = $LABEL->display('group01_foot_pic');
$__label['group01_foot_tit'] = $LABEL->display('group01_foot_tit');
$LABEL->refresh_labels();
?>
<?php
if(empty($TITLE)){
$TITLE = (empty($data['title']) ? '' : $data['title'] .'_').
(empty($CAT['name']) ? $core->CONFIG['site_name'] : $CAT['name']);
}

if(empty($SEO_KEYWORDS)){
if(!empty($data['seo_keywords'])){
$SEO_KEYWORDS = $data['seo_keywords'];
}else if(!empty($CAT['seo_keywords'])){
$SEO_KEYWORDS = $CAT['seo_keywords'];
}else{
$SEO_KEYWORDS = $core->CONFIG['site_key_word'];
}
}

if(empty($SEO_DESCRIPTION)){
if(!empty($data['seo_description'])){
$SEO_DESCRIPTION = $data['seo_description'];
}else if(!empty($CAT['seo_description'])){
$SEO_DESCRIPTION = $CAT['seo_description'];
}else{
$SEO_DESCRIPTION = $core->CONFIG['site_description'];
}
}
print <<<EOT
 <!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta name ="renderer" content="webkit">
<meta http-equiv="Content-Type" content="charset={$core->CONFIG['page_charset']}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>$TITLE</title>
<meta name="keywords" content="$SEO_KEYWORDS" />
<meta name="description" content="$SEO_DESCRIPTION" />
<link rel="stylesheet" type="text/css" href="{$SKIN}../core/common.css" />
<link rel="stylesheet" type="text/css" href="{$SKIN}../core/head_foot/style.css" />
<link rel="stylesheet" type="text/css" href="{$RESOURCE}/skin/label/label.css" />
<link rel="Shortcut Icon" href="favicon.ico">
<!--[if lt IE 9]>
<script src="{$RESOURCE}/js/html5shiv.min.js"></script>
<script src="{$RESOURCE}/js/respond.min.js"></script>
<![endif]-->
<script src="//cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
<script type="text/javascript" src="{$RESOURCE}/plus/layer/layer.js"></script>
<script src='//player.polyv.net/script/polyvplayer.min.js'></script>
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/lang/core/{$core->CONFIG['lang']}.js"></script>
EOT;
if($SYSTEM != 'core'){
print <<<EOT

<script type="text/javascript" src="{$RESOURCE}/js/lang/$SYSTEM/{$core->CONFIG['lang']}.js"></script>
EOT;
}
print <<<EOT

<script type="text/javascript">
P8CONFIG.RESOURCE = '$RESOURCE';
var SYSTEM = '$SYSTEM',
MODULE = '$MODULE',
ACTION = '$ACTION',
LABEL_URL = '$LABEL_URL',
\$this_router = P8CONFIG.URI[SYSTEM][MODULE].controller,
\$this_url = \$this_router +'-'+ ACTION,
SKIN = '$SKIN',
TEMPLATE = '$TEMPLATE';
mobile_status= '{$core->CONFIG['enable_mobile']}',
mobile_auto_jump='{$core->CONFIG['mobile_auto_jump']}',
mobile_url = '{$core->CONFIG['murl']}';
if(mobile_status=='1' && SYSTEM!='sites'){
if(browser.versions.android || browser.versions.iPhone || browser.versions.iPad){
if(mobile_auto_jump=='1' && mobile_url!=P8CONFIG.RESOURCE){
var this_url = location.href,_pul=P8CONFIG.RESOURCE;
if(this_url.indexOf(mobile_url)==-1 && this_url.indexOf('s.php')==-1 && this_url.indexOf('u.php')==-1 && this_url.indexOf('admin.php')==-1 && SYSTEM!='sites'){
if(this_url.indexOf(P8CONFIG.RESOURCE+'/html')!=-1)_pul+='/html';
this_url = this_url.replace(_pul, mobile_url);
location.href = this_url;
}
}
}
}
EOT;
if(!empty($this_module->CONFIG['base_domain'])){
$_domain = $this_module->CONFIG['base_domain'];
}else if(!empty($this_system->CONFIG['base_domain'])){
$_domain = $this_system->CONFIG['base_domain'];
}else{
$_domain = $core->CONFIG['base_domain'];
}
echo empty($_domain) ? '' : 'document.domain = \''. $_domain .'\';';
echo 'document.base_domain = \''. $_domain .'\';';
print <<<EOT

</script>
<script type="text/javascript">
jQuery(document).ready(function(){
var qcloud={};
$('[_t_nav]').hover(function(){
var _nav = $(this).attr('_t_nav');
clearTimeout( qcloud[ _nav + '_timer' ] );
qcloud[ _nav + '_timer' ] = setTimeout(function(){
$('[_t_nav]').each(function(){
$(this)[ _nav == $(this).attr('_t_nav') ? 'addClass':'removeClass' ]('nav-up-selected');
});
$('#'+_nav).stop(true,true).slideDown(200);
}, 150);
},function(){
var _nav = $(this).attr('_t_nav');
clearTimeout( qcloud[ _nav + '_timer' ] );
qcloud[ _nav + '_timer' ] = setTimeout(function(){
$('[_t_nav]').removeClass('nav-up-selected');
$('#'+_nav).stop(true,true).slideUp(200);
}, 150);
});
});
</script>
</head>
<body>
<div class="header">
<div class="topbox">
<div class="top">
<div class="zuo">{$__label['group01_top_1']}</div>
<div class="you">
<div class="toplogin">
<div id="header_t">
<span id="header_login" class="user-login"><script type="text/javascript" src="{$core->U_controller}/member-login?style=com&id=header_login"></script></span>   
</div>
</div>
<div class="topscan">
<ul>
<li class="toggleCode">
<span class="phone" href="javascript:void(0)">手机版</span>
<div class="codeDiv" style="display: none;">{$__label['group01_top_pic01']}</div>
</li>
<li class="toggleCode">
<span class="wechat" href="javascript:void(0)">微信</span>
<div class="codeDiv" style="display: none;">{$__label['group01_top_pic02']}</div>
</li>
</ul>
</div>
</div>  
<div class="fir">
<div class="dropdown">
{$__label['group01_top_2']}
</div>
</div>
</div>
</div>
<div class="head-v3">
<div class="navigation-up">
<div class="navigation-inner">
<div class="navigation-v3">
<div class="logo_fl"><a href="{$core->controller}"><img src="{$SKIN}../core/head_foot/logo.png" /></a></div>
<ul>
<li class="nav-up-selected-inpage" _t_nav="home">
<h2> <a href="{$core->controller}">首页</a> </h2>
</li>
EOT;
$loadsystem = ($SYSTEM == $core->CONFIG['index_system'] || $core->CONFIG['CoreMenu'])? 'core' : $this_system->name;
$navigation_menu = $CACHE->read('', $loadsystem, 'navigation');
$i = 0;
$__t_foreach = @$navigation_menu['menus'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
$i++;
print <<<EOT

<li class="" _t_nav="tab$i">
<h2> <a href="$v[url]">$v[name]</a> </h2>
</li>
EOT;
}
}

print <<<EOT
 
</ul>
</div>
</div>
</div>
<div class="navigation-down" style="z-index:1111">
EOT;
$loadsystem = ($SYSTEM == $core->CONFIG['index_system'] || $core->CONFIG['CoreMenu'])? 'core' : $this_system->name;
$navigation_menu = $CACHE->read('', $loadsystem, 'navigation');
$i = 0;
$__t_foreach = @$navigation_menu['menus'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
$i++;
if(!empty($v['menus']) && $core->CONFIG['ShowMenu']){
print <<<EOT

<div id="tab$i" class="nav-down-menu menu-3 menu-1" style="display: none;" _t_nav="tab$i">
<div class="navigation-down-inner">
<div class="xiala">
<div class="mklist">
<ul>
EOT;
$__t_foreach = @$v['menus'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $k2 => $v2){
print <<<EOT

<li class="ahover"><a href="$v2[url]">$v2[name]</a></li>
EOT;
}
}

print <<<EOT

</ul>   
</div>
<div  class="gaikuang"> <img src="{$SKIN}../core/head_foot/11_03.jpg"/> </div>
<div class="ggk">
<p>国微科技集团公司是经党中央、国务院批准，由中国电力投资集团公司与国家核电技术公司合并重新组建的大型国有企业，注册资本金450亿元，资产总额7223亿元。</p>
</div>
</div>
</div>
</div>
EOT;
}
}
}

print <<<EOT
 
</div>
</div>
</div>
<script type="text/javascript">
var USERNAME = get_username();
$(document).ready(function(){
//**show_edit**//					   
init_labelshows('header_t');
$('.fir .dropdown').hover(function(){
$(this).addClass('s'); 
$(this).find('ul.list').slideDown(180);
},function(){
$(this).removeClass('s');
$(this).find('ul.list').slideUp(80);
})
})
</script>
<script type="text/javascript">
$(".toggleCode").each(function(){
var code = $(this).find('.codeDiv');
$(this).hover(function() {
code.show();
}, function() {
code.hide();
});
})
</script>
<div id="content">
<link href="{$SKIN}index/index.css" type="text/css" rel="stylesheet">
<div class="banner">{$__label['group01_banner']}</div>
<div class="content_1">
<div class="tab_new" id="tab_1">
<div class="head">
<span class="over">{$__label['group01_n1']}</span>
<span>{$__label['group01_n2']}</span>
<span>{$__label['group01_n3']}</span>
</div>
<div class="main">
<div class="content" style="display:block;">
<div class="focusNews">{$__label['group01_focusNews']}</div>
<div class="flashnews">{$__label['group01_flashnews']}</div>
</div>
<div class="content" style="display:none;">
<div class="focusNews">{$__label['group01_focusNews2']}</div>
<div class="flashnews">{$__label['group01_flashnews2']}</div>
</div>
<div class="content" style="display:none;">
<div class="focusNews">{$__label['group01_focusNews3']}</div>
<div class="flashnews">{$__label['group01_flashnews3']}</div>
</div>
</div>
</div>
<div class="show">
<div class="sh_top">
<div class="shbox">{$__label['group01_shbox1']}</div>
<div class="shbox">{$__label['group01_shbox2']}</div>
<div class="shbox"><a href="javascript:video();"><img width="150" height="130" border="none" alt="" src="http://jt.php168.net/attachment/core/label/2016_03/12_14/24ca3a799593c79d.jpg"></a></div>
<div class="shbox">{$__label['group01_shbox4']}</div>
</div>
<div class="sh_down mtop">
{$__label['group01_btn']}
</div>
</div>
</div>
<div class="content_2">
<div class="main">
{$__label['group01_n6']}
</div>
</div>
<script type="text/javascript">
function video() {
layer.open({
type: 1,
title: false,
closeBtn: 1,
area: ['800px', '400px'],
shadeClose: true,
content: '<div id=\\'plv_5ebeaeac266d928f4c1ce7da3d07c090_5\\' style=\\'width:800px;height:400px;overflow:hidden;\\'></div>'
});
var player = polyvObject('#plv_5ebeaeac266d928f4c1ce7da3d07c090_5').videoPlayer({
'width':'800',
'height':'400',
'vid' : '5ebeaeac266d928f4c1ce7da3d07c090_5',
});

} 
</script>
<script language="javascript">
$(document).ready(function(){
MoveTabs('tab_1',0,'mouseover');
MoveTabs('tab_2',0,'mouseover');
MoveTabs('tab_3',0,'mouseover');
MoveTabs('tab_4',0,'mouseover');
MoveTabs('tab_5',0,'mouseover');
MoveTabs('tab_6',0,'mouseover');
});
</script>
</div>
<div class="foot_fl">
<div class="con">
<div class="zuo">
{$__label['group01_foot_1']}
</div>
<div class="zhong">
{$__label['group01_foot_2']}
<div id="footer_login"><script type="text/javascript" src="{$core->U_controller}/member-login?style=admin_main&id=footer_login"></script></div>			
</div>
<div class="you">
<div class="tp">
{$__label['group01_foot_pic']}
</div>
<span>{$__label['group01_foot_tit']}</span>
</div> 
</div> 
<div class="xia">
<div class="wd">
{$core->CONFIG['copyright']}
</div>
</div>       
</div>
</body>
</html>
EOT;
?>
<?php
if(P8_EDIT_LABEL && !defined('P8_GENERATE_HTML')) echo "<script type=\"text/javascript\">\$(document).ready(function(){\$('.label').each(function(){\$(this).hover(function(){\$(this).css({'opacity':'0.8','filter':'alpha(opacity=80)'});}, function(){\$(this).css({'opacity':'0.4','filter':'alpha(opacity=40)'});}).resizable().dblclick(function(){window.open('{$core->admin_controller}/core/label-update?system=$SYSTEM&module=$MODULE&site=$SITENAME&env=$ENV&place_holder_width='+ \$(this).width() +'&place_holder_height='+ \$(this).height() +'&id='+ this.id.replace(/[^0-9]/g, '') +'&postfix=". (empty($_GET['postfix']) ? (empty($LABEL->last_postfix) ? '' : $LABEL->last_postfix) : $_GET['postfix']) ."&name='+ encodeURIComponent($('span', this).html()) +'&from_js=1&page=". $LABEL_PAGE ."&_referer='+ encodeURIComponent(window.location.href));}).bind('contextmenu', function(){window.open('{$core->admin_controller}/core/label-add?system=$SYSTEM&module=$MODULE&site=$SITENAME&env=$ENV&place_holder_width='+ \$(this).width() +'&place_holder_height='+ \$(this).height() +'&postfix=". (empty($_GET['postfix']) ? (empty($LABEL->last_postfix) ? '' : $LABEL->last_postfix) : $_GET['postfix']) ."&name='+ encodeURIComponent($('span', this).html()) +'&from_js=1&_referer='+ encodeURIComponent(window.location.href));return false;});});});</script>";
?>