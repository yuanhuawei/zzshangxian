<?php
defined('PHP168_PATH') or die();

/**
* 列表页静态
*使用方法 cms_list_to_html.php?cid=1,2,3
**/

//抗干扰
unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);

$cid = isset($cid)?trim($cid):0;	
$page = isset($page)?intval($page):1;	
$mobile = isset($mobile)?intval($mobile):0;	

if($cid){
    //获取分类信息
    $cms = $core->load_system('cms');
    $this_module = $cms->load_module('item');

    include_once PHP168_PATH .'inc/html.func.php';

    $cids = explode(',',$cid);

    foreach($cids as $id){
        $__CAT__ = $cms->fetch_category($id);
        //很危险的啦,你懂的啦
        $__CAT__['html_list_url_rule'] = str_replace('"', '', $__CAT__['html_list_url_rule']);
        $__file__ = p8_html_url($this_module, $__CAT__, 'list', false);

        if($__file__){
            
            $this_module->_html['basename'] = basename($__file__);
            //取路径
            $this_module->_html['path'] = str_replace($this_module->_html['basename'], '', $__file__);
            
            $page_file = preg_replace('/#([^#]+)#/', '\1', $__file__);
            $no_page = preg_replace('/#([^#]+)#/', '', $__file__);
            
            if($page == 1){
                if(preg_match('/^#.*\.(.*)#$/', $this_module->_html['basename'], $m)){
                    $this_module->_html['file'] = $this_module->_html['path'] .'index.'. $m[1];
                }else{
                    $this_module->_html['file'] = $no_page;
                }
            }else{
                $this_module->_html['file'] = str_replace('?page?', $page, $page_file);
            }
            if($mobile){
                $__list_uri__ = '/m/index.php/cms/item-list-category-{$id}-page-{$page}';
                $filename = PHP168_PATH .'m/index.php';
            }else{
                $__list_uri__ = '/index.php/cms/item-list-category-{$id}-page-{$page}';
                $filename = PHP168_PATH .'index.php';
            }
            eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__list_uri__ .'";');

            ob_start();
            require $filename;
            $__content__ = ob_get_clean();
            
            md($this_module->_html['path']);
            if(!write_file($this_module->_html['file'], $__content__)){
                message(p8lang($P8LANG['cms_item_html_unwritable'], array($this_module->_html['file'])));
            }
            @chmod($this_module->_html['file'], 0644);
        }
    }
}