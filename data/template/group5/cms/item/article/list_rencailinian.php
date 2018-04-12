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
$__label['group01_top_2'] = $LABEL->display('group01_top_2');
$__label['zhuzhan-banner'] = $LABEL->display('zhuzhan-banner');
$__label['list_idea_tt1'] = $LABEL->display('list_idea_tt1');
$__label['list_idea_pic'] = $LABEL->display('list_idea_pic');
$__label['list_idea_con1'] = $LABEL->display('list_idea_con1');
$__label['list_idea_con2'] = $LABEL->display('list_idea_con2');
$__label['list_idea_btn1'] = $LABEL->display('list_idea_btn1');
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
<script type="text/javascript" src="{$RESOURCE}/js/jquery.SuperSlide.2.1.1.js" ></script>
<script type="text/javascript" src="{$SKIN}../core/js/tabs.js"></script>
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
<ul>
<li class="toplogin" id="header_t">
<span id="header_login" class="user-login"><script type="text/javascript" src="{$core->U_controller}/member-login?style=com&id=header_login"></script></span>   
</li>
<li class="share">
<a href="javascript:void(0)" class="each_item wechat"></a>
<a href="#" class="each_item blog"></a>
</li>
</ul>
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
<div id="content">

<!--中间内容部分-->
<link rel="stylesheet" type="text/css" href="{$SKIN}style.css" />
<div class="breadbanner">
{$__label['zhuzhan-banner']}
</div>
<div class="gp-container">
<div class="container">
<div class="breadcrumbbox">
<ol class="breadcrumb">
<li><a href="{$this_system->controller}"><i class="fa fa-home"></i>首页</a></li>
EOT;
$__t_foreach = @$parent_cats;
if(!empty($__t_foreach)){
foreach($__t_foreach as $v){
print <<<EOT

<li><a href="$v[url]"><i class="fa fa-caret-right"></i>$v[name]</a></li>
EOT;
}
}

print <<<EOT

<li class="active"><i class="fa fa-caret-right"></i>$CAT[name]</li>
</ol>
<div class="row-page-tabs">
EOT;
$i = sizeof($CAT['parents']);
$j = $i>1? $i-2 : 0;
if($CAT['parents'])
$stepcat = $category->categories[$CAT['parents'][$j]]['categories'];
else
$stepcat = $category->categories[$cid]['categories'];
print <<<EOT

<ul class="list-tabs" id="list-tabs">
EOT;
$__t_foreach = @$stepcat;
if(!empty($__t_foreach)){
foreach($__t_foreach as $v){
print <<<EOT

<li class="cid_{$v['id']} 
EOT;
if($cid == $v['id']){
print <<<EOT
active
EOT;
}
print <<<EOT
">
<a href="$v[url]">$v[name]<span class="line"></span></a>
<span class="ge">|</span>
</li>
EOT;
}
}

print <<<EOT

</ul>
<script type="text/javascript">
(function(){ $('#left_nav_url dt').click(function(){ $(this).parent().parent().find('dl').hide('normal'); if($(this).nextAll('dl').css('display') == 'none') $(this).nextAll('dl').slideDown("normal"); else $(this).nextAll('dl').slideUp("normal");});
EOT;
if(!$CAT['parent']){
print <<<EOT
$('#left_nav_url').find('dl :first').parent().show()
EOT;
}
print <<<EOT

})()
</script>
</div>
</div>
</div>
<div class="container">
<div class="idea">
<div class="idea-header text-center">
<h2>{$__label['list_idea_tt1']}</h2>
</div>
<div class="row-ad">{$__label['list_idea_pic']}</div>
<div class="idea-plane">
{$__label['list_idea_con1']}
</div>
<div class="idea-plane idea-icon">
{$__label['list_idea_con2']}
</div>
<div class="text-center">
{$__label['list_idea_btn1']}
</div>
</div>
</div>
</div></div>
<div class="foot_fl mtop">
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