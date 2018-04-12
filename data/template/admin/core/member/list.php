<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理  powerby www.php168.net</title>
<meta http-equiv="Content-Type" content="text/html; charset={$core->CONFIG['page_charset']}">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" href="{$RESOURCE}/skin/admin/style.css" type="text/css">
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/jq_validator.js"></script>

<script type="text/javascript" src="{$RESOURCE}/js/admin.js"></script>

<script type="text/javascript" src="{$RESOURCE}/js/lang/core/{$core->CONFIG['lang']}.js"></script>
EOT;
if($SYSTEM != 'core'){
print <<<EOT

<script type="text/javascript" src="{$RESOURCE}/js/lang/$SYSTEM/{$core->CONFIG['lang']}.js"></script>
EOT;
}
print <<<EOT


<script type="text/javascript">
P8CONFIG.admin_controller = '{$core->admin_controller}';
var P8_ROOT = '$P8_ROOT';

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
$(document).ready(function(){
$('.headerbtn_list li a').each(function(){  
if($($(this))[0].href==String(window.location)){  
$(this).parent().addClass('active');  
}     
}); 
}); 
</script>
</head>
<body><div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table class="formtable">
<tr>
<td class="title">{$P8LANG['operation']}</td>
</tr>
<tr><td class="headerbtn_list">
<ul>
<li><a href="{$core->admin_controller}/core/member-add">添加会员/管理员</a></li>
<li><a href="{$core->admin_controller}/core/member-list">会员管理</a></li>
<li><a href="{$core->admin_controller}/core/role-list">角色/权限设置</a></li>
<li><a href="{$core->admin_controller}/core/role-list_group">角色组管理</a></li>
</ul>
</td>
</tr>
</table>

</td></tr>
</table>
</div>
</div><form action="$this_url" method="get" id="request" onsubmit="request_item(1);return false;">
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table class="formtable columntable">
<tr class="title">
<td>用户搜索</td>
</tr>

<tr>
<td>
<strong>用户搜索</strong>

<select name="role_gid" id="role_gid" onchange="if(this.value) change_role_group(this.value);">
<option value="0">全部角色组</option>
</select>&nbsp;

<select name="role_id" id="role_id" onchange="if(this.value) request_item(1);">
<option value="0">全部角色</option>
</select>&nbsp;

<select onchange="$('#cond').attr('name', this.value)">
<option value="keyword">按关键字</option>
<option value="id"
EOT;
if(!empty($id)){
print <<<EOT
 selected
EOT;
}
print <<<EOT
>按ID</option>
</select>&nbsp;

<input type="text" class="txt" id="cond" size="15" 
EOT;
if(strlen($keyword)){
print <<<EOT
 name="keyword" value="$keyword"
EOT;
}elseif(!empty($id)){
print <<<EOT
 name="id" value="
EOT;
echo implode(',', $id);
print <<<EOT
"
EOT;
}else{
print <<<EOT
 name="keyword"
EOT;
}
print <<<EOT
 />&nbsp;
<input type="checkbox" name="is_admin" id="is_admin" value="1" /><label for="is_admin">管理员</label>

<select name="order">
<option value="desc">降序</option>
<option value="asc">升序</option>
</select>


<input type="submit" value="搜索" class="submit_btn" onclick="$('input[name=where]', $('#send')).val($('#request').serialize());" />

<a class="submit_btn" style="color:#fff;" href="{$core->admin_controller}/core/member-add">添加会员</a>

</td>
</tr>
</table>
</td></tr>
</table>
</div>
</div>
</form>

<form id="form" action="$this_url" method="post" >
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table class="formtable columntable hover_table click_changeable">
<tr class="title fix_head">
<td width="2%" class="title"><input type="checkbox" name="check_all" onclick="m_check_all(this)" /></td>
<td width="3%" class="title">ID</td>
<td width="8%" class="title">{$P8LANG['username']}</td>
EOT;
if(empty($_GET['_dialog'])){
print <<<EOT

<td width="8%" class="title">最后登录时间</td>
<td width="6%" class="title">最后登录IP</td>
<td width="8%" class="title">注册时间</td>
EOT;
}
print <<<EOT


<td width="5%" class="title">电子邮箱</td>
<td width="5%" class="title">手机号码</td>
<td width="5%" class="title">用户权限</td>
<td width="3%" class="title">状态</td>
<td width="3%" class="title">排序</td>
EOT;
if(empty($_GET['_dialog'])){
print <<<EOT

<td width="10%" class="title">操作</td>
EOT;
}
print <<<EOT


</tr>

<tbody id="list">

</tbody>

</table>

</td></tr>
</table>
</div>
</div>
</form>

<div id="pages" align="center" class="pages">

</div>

<form action="$this_router-batch_send" method="get" id="send" target="_blank">
<input type="hidden" name="where" />
</form>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="foot_btn">
<tr>
<td width="19%">
<div align="center">
<a href="javascript:void(0)" onclick="m_check_all(true)">全选</a>/<a href="javascript:void(0)" onclick="m_check_all(false);">反选</a>
<input type="checkbox" onclick="check_all('noall', 'id[]')" id="ca" /><label for="ca">全选所有</label>
</div>
</td>

<td width="81%" id="button_bar">
EOT;
if(empty($_GET['_dialog'])){
if($allow_delete){
print <<<EOT

<input type="submit" value="批量删除" class="edit_btn" onclick="delete_member(checked_values('id[]'))" />
EOT;
}
if($allow_send){
print <<<EOT

<input type="submit" value="发送邮件" class="edit_btn" onclick="batch_send()" />
EOT;
}
print <<<EOT

<input type="submit" value="设置排序" class="edit_btn" onclick="javascript:$('#form').submit()" />
EOT;
}
print <<<EOT

</td>
</tr>
</table>


<script type="text/javascript">

var ROLE_GROUP_JSON = $role_group_json,
ROLE_JSON = $role_json,
status_json = $status_json,
checked_ids = {};


function batch_send(){
var ids = checked_values('id[]');
if(ids.length){
$('input[name=where]', $('#send')).val('id='+ ids.join(','));
}else{
//$('input[name=where]', $('#send')).val($('#request').serialize());
}

$('#send').attr('action', '$this_router-batch_send').submit();
}

function request_item(page){
$.ajax({
url: '$this_url',
data: $('#request').serialize() +'&page='+ (page === undefined ? 1 : page),
dataType: 'json',
cache: false,
beforeSend: function(){
ajaxing({});
},
success: function(json){
PAGE = page;

$('#list').empty();
for(var i in json.list){
_list_item(json.list[i]);
}

$('#pages').html(json.pages);

ajaxing({action: 'hide'});

window.scrollTo(0,0);

$('#form input[name=check_all]').prop('checked', false);
EOT;
if(!empty($_GET['_dialog'])){
print <<<EOT

$('#form input[name="id[]"]').click(function(){
var _this = this;
var tr = $(this).parent().parent();

var json = {id: this.value, username: tr.find('td:eq(2) a').html(), role: tr.find('td:eq(5)').html()};

setTimeout(function(){ parent.member_single_select_callback(_this.checked, json); }, 1);
});
EOT;
}
print <<<EOT


init_tr($('#form'));

var keywords = $.trim($('#request input[name=keyword]').val());
if(!keywords.length) return;

var keywords = keywords.replace(/[\\+\\-\\*\\|\\!]/g, '').split(/\\s+/);

$('.list_item').each(function(){
for(var i = 0; i < keywords.length; i++){
var html = $(this).find('.item_title').get(0).innerHTML;
$(this).find('.item_title').get(0).innerHTML = html.replace(keywords[i], '<font color="red">'+ keywords[i] +'</font>', 'ig');
}
});

}
});
}

function _list_item(json){

var update_link = '
EOT;
if($allow_update){
print <<<EOT
<a href="$this_router-update?id='+ json.id +'&role_gid='+ json.role_gid +'" target="_blank">{$P8LANG['edit']}</a> 
EOT;
}
print <<<EOT
';
var delete_link = '
EOT;
if($allow_delete){
print <<<EOT
<a href="###" id="delete_'+ json.id +'" onclick="return delete_member([this.id]);">{$P8LANG['delete']}</a> 
EOT;
}
print <<<EOT
';
var setacl_link = '
EOT;
if($allow_set_acl){
print <<<EOT
<a href="{$core->admin_controller}/core-set_member_acl?user_id='+ json.id +'" target="_blank">{$P8LANG['set_acl']}</a> 
EOT;
}
print <<<EOT
';

var tr = 
'<tr>'+
'<td><input type="checkbox" name="id[]" value="'+ json.id +'"'+ (checked_ids[json.id] ? ' checked' : '') +' /></td>'+
'<td>'+ json.id +'</td>'+
'<td><a href="{$core->admin_controller}/core/member-view?id='+ json.id +'&role_gid='+ json.role_gid +'" target="_blank">'+ json.username +'</a></td>'+
EOT;
if(empty($_GET['_dialog'])){
print <<<EOT

'<td>'+ (json.last_login != 0 ? date('Y-m-d H:i:s', json.last_login) : '') +'</td>'+
'<td>'+ json.last_login_ip +'</td>'+
'<td>'+ date('Y-m-d H:i:s', json.register_time) +'</td>'+
EOT;
}
print <<<EOT


'<td>'+ json.email +'</td>'+
'<td>'+ json.cell_phone +'</td>'+
'<td>'+ (ROLE_JSON[json.role_id] ? ROLE_JSON[json.role_id].name : '') +'</td>'+
'<td>'+ status_json[json.status] +'</td>'+
'<td><input type="text" class="txt" name="display_order['+ json.id +']" value="'+ json.display_order +'" onchange="change_order(this)" size="4" /></td>'+
EOT;
if(empty($_GET['_dialog'])){
print <<<EOT

'<td class="cleartd">'+ update_link  + delete_link + setacl_link +'</td>'+
EOT;
}
print <<<EOT

'</tr>';

$('#list').append($(tr));
}

function m_check_all(checked){

check_all(checked, 'id[]', $('#form')); init_tr($('#form'));
EOT;
if(!empty($_GET['_dialog'])){
print <<<EOT

$('#form input[name="id[]"]').click();
EOT;
}
print <<<EOT

}
function change_order(obj){

obj.value = obj.value.replace(/[^0-9]/g, '') || 0;
if(obj.value > 255) obj.value = 255;
if(obj.value < 0) obj.value = 0;
$('#form').append('<input type="hidden" name="_display_order['+ obj.name.replace(/[^0-9]/g, '') +']" value="'+ obj.value +'" />');
$(obj).css({border: '1px solid #ff0000'});

}

$(function(){

for(var i in ROLE_GROUP_JSON){
$('#role_gid').append($('<option value="'+ ROLE_GROUP_JSON[i].id +'">'+ ROLE_GROUP_JSON[i].name +'</option>'));
}
EOT;
if($role_gid && $role_id){
print <<<EOT

change_role_group({$role_gid});
$('#role_id').val({$role_id});
EOT;
}
print <<<EOT

setTimeout(request_item(1),1000);


if(\$_GET['checked_ids']) checked_ids = \$_GET['checked_ids'];

if(window.opener){
$('#opener_hide').hide();

$('#button_bar').append($('<input type="button" value="确定选择" class="edit_btn" />').click(function(){

var ids = checked_values('id[]');
if(ids.length){
window.opener.member_select_callback(ids);
}else{
window.opener.member_select_callback($('input[name=where]', $('#send')).val());
}

window.close();
}));
}


});

function change_role_group(gid){
$('#role_id').attr('length', 1);
for(var i in ROLE_JSON){
if(ROLE_JSON[i].gid != gid) continue;

$('#role_id').append($('<option value="'+ ROLE_JSON[i].id +'">'+ ROLE_JSON[i].name +'</option>'));
}

request_item(1);
}

function delete_member(obj){

var id = [];
$.each(obj, function(k, v){
id.push(v.replace(/[^0-9]/g, ''));
});
if(!id.length) return;

if(confirm('{$P8LANG['confirm_to_delete_member']}')){
$.ajax({
url: '$this_router-delete',
type: 'POST',
dataType: 'json',
data: ajax_parameters({id: id}),
cache: false,
beforeSend: function(){
ajaxing({});
},
success: function(json){
ajaxing({action: 'hide'});
if(json.length == 0) return false;

for(var i in json){
$('#delete_'+ json[i]).parent().parent().remove();
}
}
});
}

return false;
}
</script><div class="clear"></div>

</body>
</html>
EOT;
?>