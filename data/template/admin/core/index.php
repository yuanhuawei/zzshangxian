<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理 powerby www.php168.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<link rel="stylesheet" href="{$RESOURCE}/skin/admin/style.css" type="text/css">
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/admin.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/lang/core/{$core->CONFIG['lang']}.js"></script>
<script type="text/javascript">
P8CONFIG.admin_controller = '{$core->admin_controller}';
var MENU_JSON = $json[json];
var MENU_JSON2 = $json[json2];
var MENU_PATH = $json[path];
var MENU_DENIED = $denied;
var system_menu_hide_timeout;

function get_menu_by_id(id){
var path = clone(MENU_PATH[id]);
var root = path.shift();

var search = get_menu_byid(MENU_JSON2,root);

if(path.length == 0){
return search;
}

for(var i in path){
search = get_menu_byid(search.menus,path[i]);
}

return search;
}
function get_menu_byid(json,need){
for(var i in json){
if(json[i].id==need){
return json[i];
}
}
return {};
}
P8CONFIG.RESOURCE = '$RESOURCE';
var SYSTEM = '$SYSTEM',
MODULE = '$MODULE',
ACTION = '$ACTION',
LABEL_URL = '$LABEL_URL',
\$this_router = '{$this_router}',
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

</script>
<script type="text/javascript">
var cache_action = "{$core->admin_controller}/core-cache";
var index_html_action = "{$core->admin_controller}/cms-index_to_html";
var index_html_m_action = "{$core->admin_controller}/cms-index_to_html";
var item_view_action = "{$core->admin_controller}/cms/item-view_to_html";
var item_list_action = "{$core->admin_controller}/cms/item-list_to_html";
var label_action = "{$core->admin_controller}/core/label-cache";
var category_action = "{$core->admin_controller}/cms/category-cache";
var special_html = "{$core->admin_controller}/core/special-view_to_html";
var _obj = new Date(
EOT;
echo P8_TIME;
print <<<EOT
000);
var _Y = _obj.getFullYear();
var _m = _obj.getMonth() +1;
var _d = _obj.getDate();
var _H = _obj.getHours();
var _j = _obj.getDay();
</script>
</head>
<body scroll="no" style="overflow:hidden;">
<div id="header">
<div class="topbar">
<div class="logo"><a href="http://www.php168.net" target="_blank"><img src="{$RESOURCE}/skin/admin/logo.png" /></a></div>
<div class="menu">
<ul id="core_menu">
<li class="current"><a href="{$core->admin_controller}">我的面板</a></li>
EOT;
$__t_foreach = @$admin_menu->top_menus;
if(!empty($__t_foreach)){
foreach($__t_foreach as $v){
if($v['url']){
if($v['target'] == '_blank'){
print <<<EOT

<li><a href="{$core->admin_controller}{$v['url']}" target="_blank">{$v['name']}</a></li>
EOT;
}else{
print <<<EOT

<li><a href="{$core->admin_controller}/{$v['url']}" target="main" onclick="javascript:get_menu({$v['id']})">{$v['name']}</a></li>
EOT;
}
}else{
print <<<EOT

<li onclick="javascript:get_menu({$v['id']})"><span>{$v['name']}</span></li>
EOT;
}
}
}

print <<<EOT

</ul>
</div>
<div class="topinfo fright">
<ul class="topclik fright">
<li class="topimg"><a href="{$core->controller}?edit_label=1" target="_blank" ><img src="{$RESOURCE}/skin/admin/topimg.png" />首页标签</a></li>
<li><a href="{$core->admin_controller}" class="on1">后台首页</a></li>
<li><a href="{$core->controller}" target="_blank" class="on2">网站首页</a></li>	
</ul>
</div>
</div>
<div class="headbar">
<div id="version"><b>国微CMS商业版</b><span><a href="http://www.php168.net" target="_blank">详情>></a></span></div>
<div class="smallmenu smlt fleft">
<ul>	
<li class="li1"><a href="http://www.php168.net/html/ys.shtml" target="_blank">在线模板</a></li>
<li class="li2"><a href="http://www.php168.net/html/1357/" target="_blank">在线教程</a></li>
<li class="li3"><a href="http://www.php168.net/index.php/forms-post?mid=2" target="_blank">模板下载</a></li>
</ul>
</div>
<div class="cachebox fright">
<form name="cacheform" id= "cacheform" method="post">
<select name="type">
<option value="template">模板缓存</option>
<option value="index">首页缓存</option>
<option value="language">语言包缓存</option>
<option value="system_module">模块缓存</option>
<option value="all">所有缓存</option>
<option value="category-cache">栏目缓存</option>
<option value="label-cache" selected>标签缓存</option>
</select>
<input type="button" value="执行" class="cachebtn" onclick="cache_update()"/>
</form>
</div>
<div class="cachebox fright">
<form method="post" target="_blank">
<select name="type">
<option value="index_to_html">静态首页</option>
EOT;
if($core->CONFIG['enable_mobile']){
print <<<EOT
<option value="index_to_m_html">静态移动首页</option>
EOT;
}
print <<<EOT

<option value="all_item">静态所有内容</option>
<option value="all_item_time">静态所有内容*24小时</option>
<option value="all_list">静态所有栏目</option>
<option value="all_special">静态所有专题</option>
</select>
<input type="button" value="执行" class="cachebtn" onclick="html_update(this.form);"/> <input id="timer_begin" type="hidden" name="time_range[]"/> <input id="timer_end" type="hidden" name="time_range[]"/>
</form>
</div>
<div class="smallmenuTwo fright">
<ul>
<li class="li1"><a href="{$core->admin_controller}/core-base_config" target="main">系统设置</a></li>
<li class="li2"><a href="{$core->admin_controller}/core/dbm-manage" target="main">数据备份</a></li>
</ul>
</div>
</div>
</div>
<div id="container">
<div id="admin_left">
<div id="tree_box">
<div id="tree_menu">
<div class="memberinfo center">
<div class="memberpic"><a href="{$core->U_controller}" target="_blank"><img src="{$RESOURCE}/skin/admin/member.png" /></a></div>
<h3><a href="{$core->U_controller}" target="_blank">$USERNAME  {$core->roles[$core->ROLE]['name']}</a></h3>
<p><a href="{$core->admin_controller}/core-logout">安全退出</a></p>
</div>
<div class="sidemenu" id="sidemenu">
<ul class="menulist">
<li><a href="{$core->admin_controller}/cms/item-add" target="main" >发布内容</a></li>
<li><a href="{$core->admin_controller}/cms/item-list" target="main">内容管理</a></li>
<li><a href="{$core->admin_controller}/cms/category-list" target="main">栏目管理</a></li>
<li><a href="{$core->admin_controller}/cms/statistic-statistic_member" target="main">统计管理</a></li>
<li><a href="{$core->admin_controller}/core/forms-model" target="main">表单管理</a></li>
<li><a href="{$core->admin_controller}/core/role-list" target="main">会员/权限</a></li>
<li><a href="{$core->admin_controller}/core/uploader-config" target="main">上传设置</a></li>
<li><a href="{$core->admin_controller}/core-template_system" target="main">网站模板</a></li>
<li><a href="{$core->admin_controller}/core-cache" target="main">一键缓存</a></li>
<li><a href="{$core->admin_controller}/cms-html_all" target="main">一键静态</a></li>
</ul>
<ul id="submenu"></ul>
</div>
<div class="brand">
<h1>十年著名品牌商</h1>
<ul class="version">
<li>今天日期：
EOT;
echo date('Y-m-d', $timestamp);
print <<<EOT
</li>
<li>版本号：{$core->CONFIG['build']}</li>
<li>开发商：<a href="http://www.php168.net/" target="_blank">广州国微软件 >></a></li>
<li>电话：400-601-5217</li>
</ul>
</div>
</div>
</div>
</div>
<div id="admin_right">
<iframe src="{$core->admin_controller}/core-main" name="main" id="main" frameborder="0" scrolling="auto" style="width: 100%; height: 100%; visibility: inherit;  z-index: 1;overflow-x: hidden;"></iframe>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$('#system li').mouseover(function(){
clearTimeout(system_menu_hide_timeout);
$('#system li dl').show();
});
$('#system li').mouseout(function(){
system_menu_hide_timeout = setTimeout(function(){ $('#system li dl').hide();}, 200);
});
$('#system_list').
mouseover(function(){
clearTimeout(system_menu_hide_timeout);
});
$(".menulist li").each(function (index) {
$(this).click(function(){
$('.menulist li').removeClass('active');
$(this).addClass('active');
});
});
window.onresize();
$("#admin_left").niceScroll({  
cursorcolor:"#CAD3D5",  
cursoropacitymax:1,  
touchbehavior:false,  
cursorwidth:"2px",  
cursorborder:"0",  
cursorborderradius:"5px"  
}); 
if(self != top){
parent.window.location.href = '{$core->admin_controller}';
}
});

//一级菜单变换CSS
core_menu_change_css();

//窗口调整
window.onresize = function(){
var userAgent = navigator.userAgent; 
var isOpera = userAgent.indexOf("Opera") > -1; 
var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera;
var widths = document.body.scrollWidth;
var heights = document.documentElement.clientHeight-109;
var userAgent = navigator.userAgent;
var isOpera = userAgent.indexOf("Opera") > -1;
$("#admin_left").height(heights);
$("#tree_box").height(1228);
var main_w = $('#container').width()-$("#admin_left").width();
var header_top = document.getElementById("main").offsetTop;	
if(isIE) heights = heights-50;
$('#main').height(heights);	
if(header_top>110){
if(isIE)
$('#main').height(heights-header_top+109);
else
$('#main').height(heights-header_top+84);
}
};
</script>
<script type="text/javascript">
function cache_update(){
obj = $('#cacheform');
var selected = obj.children("select");
switch(selected.val()){

case 'template':
obj.attr('action',cache_action);
obj.find('type').attr('type','template');
obj.submit();
break;

case 'index': 
obj.attr('action',cache_action);
obj.find('type').attr('type','index');
obj.submit();
break;

case 'language':
obj.attr('action',cache_action);
obj.find('type').attr('type','language');
obj.submit();
break;

case 'system_module':
obj.attr('action',cache_action);
obj.find('type').attr('type','system_module');
obj.submit();
break;

case 'all':
obj.attr('action',cache_action);
obj.find('type').attr('type','');
obj.submit();
break;

case 'category-cache':
obj.attr('action',category_action);;
obj.find('type').attr('type','');
obj.submit();
break;

case 'label-cache':
obj.attr('action',label_action);;
obj.find('type').attr('type','');
obj.submit();
break;
}
}

function html_update(obj){
var selected = $(obj).children("select");
switch(selected.val()){

case 'index_to_html':
obj.action = index_html_action;
obj.type.value = 'index_to_html';
obj.submit();
break;

case 'index_to_m_html':
obj.action = index_html_m_action;
obj.type.value = 'index_to_m_html';
obj.submit();
break;

case 'all_item':
obj.action = item_view_action;
obj.type.value = '';
obj.submit();
break;

case 'all_item_time':
obj.action = item_view_action;
obj.type.value = '';
$(obj).children("#timer_begin").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d, _Y)));
$(obj).children("#timer_end").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d+1, _Y)));
obj.submit();
break;

case 'all_list':
obj.action = item_list_action;
obj.type.value = '';
obj.submit();
break;

case 'all_list_time':
obj.action = item_list_action;
obj.type.value = '';
$(obj).children("#timer_begin").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d, _Y)));
$(obj).children("#timer_end").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d+1, _Y)));
obj.submit();
break;

case 'all_special':
obj.action = special_html;
obj.type.value = 'all';
obj.submit();
break;
}
}
</script>
</body>
</html>
EOT;
?>