<?php
defined('PHP168_PATH') or die();
/**
* 列表页静态
*使用方法 sites_list_to_html.php?site=default&cid=1,2,3
**/
unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);
$cid = isset($cid)?trim($cid):0;	
$page = isset($page)?intval($page):1;	
if($cid){
$sites = $core->load_system('sites');
$this_module = $sites->load_module('item');
include_once PHP168_PATH .'inc/html.func.php';
$cids = explode(',',$cid);
foreach($cids as $id){
$__CAT__ = $sites->fetch_category($id);
$__CAT__['html_list_url_rule'] = str_replace('"', '', $__CAT__['html_list_url_rule']);
$__CAT__['is_category'] = 1;
$_system_path = $this_module->system->path;
$this_module->system->path = $_system_path. 'html/'.$this_module->system->SITE.'/';
$__file__ = p8_html_url($this_module, $__CAT__, 'list', false);
$this_module->system->path = $_system_path;
if($__file__){
$this_module->_html['basename'] = basename($__file__);
$this_module->_html['path'] = str_replace($this_module->_html['basename'], '', $__file__);
$page_file = preg_replace('/#([^#]+)#/', '\1', $__file__);
$no_page = preg_replace('/#([^#]+)#/', '', $__file__);
if($page == 1)
if(preg_match('/^#.*\.(.*)#$/', $this_module->_html['basename'], $m))
$this_module->_html['file'] = $this_module->_html['path'] .'index.'. $m[1];
else
$this_module->_html['file'] = $no_page;
else
$this_module->_html['file'] = str_replace('?page?', $page, $page_file);
$__list_uri__ = '/s.php/'. $this_module->system->SITE .'/item-list-category-{$id}-page-{$page}';
eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__list_uri__ .'";');
ob_start();
require PHP168_PATH .'s.php';
$__content__ = ob_get_clean();
md($this_module->_html['path']);
if(!write_file($this_module->_html['file'], $__content__))
message(p8lang($P8LANG['sites_item_html_unwritable'], array($this_module->_html['file'])));
@chmod($this_module->_html['file'], 0644);
}}}