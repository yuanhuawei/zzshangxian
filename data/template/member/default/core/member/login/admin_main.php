<?php
defined('PHP168_PATH') or die();
?>
<?php
if($UID && $IS_ADMIN){
print <<<EOT
<a href="{$core->admin_controller}" target="_blank">管理入口</a>  | <a href="{$core->admin_controller}/core-cache" target="_blank">系统缓存</a>  |  <a href="{$core->admin_controller}/cms/category-list" target="_blank">栏目管理</a> | <a href="{$core->admin_controller}/core-navigation_menu_list" target="_blank">菜单管理</a>
EOT;
}
?>