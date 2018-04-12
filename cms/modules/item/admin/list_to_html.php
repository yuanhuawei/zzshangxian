<?php
defined('PHP168_PATH') or die();

/**
 * 列表页生成静态
 * *
 */

$this_controller->check_admin_action($ACTION) or message('no_privilege');

// 定义生成静态的常量
define('P8_GENERATE_HTML', true);

require PHP168_PATH . 'inc/html.func.php';

define('THIS_URL', $this_url);

function _poster($task, $msg = '')
{
    global $CACHE, $SYSTEM, $__task_name__, $__task__;
    
    $CACHE->write($SYSTEM, 'html_task', $__task_name__, $__task__, 'serialize');
    
    echo '<html>
<body>
' . $msg . '
<form action="' . THIS_URL . '" id="form" method="post">
<input type="hidden" name="task" value="' . $task . '" />
</form>
<script type="text/javascript">
document.getElementById("form").submit();
</script>
</body>
</html>';
    exit();
}

if (REQUEST_METHOD == 'GET') {
    
    // 搜集未完成的任务
    /*
     * $_tasks = glob(CACHE_PATH . $SYSTEM .'/html_task/list_*.php');
     * $_tasks || $_tasks = array();
     * $tasks = array();
     * foreach($_tasks as $v){
     * $data = include $v;
     * $tasks[] = array(
     * 'time' => date('Y-m-d H:i:s', $data['time']),
     * );
     * }
     * unset($_tasks, $data);
     */
    
    $category = &$this_system->load_module('category');
    $category->get_cache();
    
    include template($this_module, 'list_to_html', 'admin');
} else 
    if (REQUEST_METHOD == 'POST') {
        
        @set_time_limit(0);
        @ignore_user_abort(false);
        
        $category = &$this_system->load_module('category');
        $category->get_cache();
        
        // ## 初始化任务 ## step: 1{
        if (empty($_POST['task'])) {
            $__task_name__ = 'list_' . unique_id(16);
            
            $cids = isset($_POST['cids']) ? array_unique(filter_int($_POST['cids'])) : array();
            $perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
            
            if (empty($cids) || current($cids) == 0) {
                // 所有分类
                $category_count = count($category->categories);
                
                $categories = array();
                foreach ($category->categories as $v) {
                    $categories[] = $v['id'];
                }
            } else {
                $category_count = count($cids);
                
                $categories = $cids;
            }
            
            $threads = isset($_GET['threads']) ? intval($_GET['threads']) : 1;
            $threads = max($threads, 1);
            
            $pages = isset($_POST['pages']) ? intval($_POST['pages']) : 0;
            $pages = max($pages, 0);
            
            $mobile = isset($_POST['mobile']) ? intval($_POST['mobile']) : 0;
            
            /*
             * $threads = ceil($category_count / $threads);
             * $threads = min($threads, 1);
             *
             * for($i = 0; $i < $threads; $i++){
             * $thread = array(
             * 'start_offset' => $i * $threads,
             * 'end_offset' => $i * $threads + $threads
             * );
             *
             * $CACHE->write($SYSTEM, 'html_task', $__task_name__ .'_'. ($i +1), $thread, 'serialize');
             * }
             */
            
            $__task__ = array(
                'category_offset' => 0, // 分类偏移
                'category_count' => $category_count,
                'categories' => $categories,
                'threads' => $threads, // 线程数
                                       // 'times' => $times, //总共要生成次数
                'start_time' => get_timer(), // 开始时间,有毫秒
                'time' => P8_TIME, // 开始时间
                'perpage' => $perpage, // 每页生成的文件数
                'pages' => $pages, // 仅生成几页
                'mobile' => $mobile, // 移动
                'type' => empty($_POST['type']) ? 0 : intval($_POST['type']),
                'thread' => array()
            ) // 己完成的线程
;
            
            _poster($__task_name__, '');
        }
        // ## 初始化任务 ##}
        
        // 不产生日志
        define('NO_ADMIN_LOG', true);

        function _done()
        {
            global $__task__, $__task_name__, $P8LANG, $SYSTEM, $CACHE;
            echo p8lang($P8LANG['cms_item']['htmlize']['done'], array(
                P8_TIME - $__task__['time']
            ));
            $CACHE->delete($SYSTEM, 'html_task', $__task_name__);
            exit();
        }
        
        // 从这里开始,变量尽可能怪异,防止与页面上的变量冲突,用__包围__
        
        $__task_name__ = basename($_POST['task']);
        // 任务数据
        $__task__ = $CACHE->read($SYSTEM, 'html_task', $__task_name__, 'serialize');
        $__task__ or message('access_denied');
        
        // 每页生成的文件数
        $__perpage__ = $__task__['perpage'];
        
        $__count__ = - 1;
        while (true) {
            
            $__category_offset__ = $__task__['category_offset'];
            
            if (! isset($__task__['categories'][$__category_offset__])) {
                message('no_cms_category_to_html');
            }
            
            $id = $__task__['categories'][$__category_offset__];
            
            // 获取分类信息
            $__CAT__ = $this_system->fetch_category($id);
            $__CAT__['is_category'] = true;
            
            // 如果当前分类页码为空,初始化当前分类任务 step: 2{
            if (empty($__task__['current_category_page'])) {
                
                while (true) {
                    
                    // 获取分类信息
                    $__CAT__ = $this_system->fetch_category($id);
                    $__CAT__['is_category'] = true;
                    
                    $model = $this_system->get_model($__CAT__['model']);
                    
                    if (empty($__CAT__['htmlize']) || $__CAT__['htmlize'] == 2 || ($__task__['type'] && $__CAT__['type'] != $__task__['type']) || ($__CAT__['type'] == 2 && ! empty($model['filterable_fields']))) {
                        // 如果分类是不生成静态的,或类型不匹配,或当前模型有可过滤的字段,跳到下一个分类去
                        $__task__['category_offset'] ++;
                        
                        // 没有分类了,完成
                        if ($__task__['category_offset'] >= $__task__['category_count'] - 1)
                            _done();
                        
                        $id = $__task__['categories'][$__task__['category_offset']];
                        
                        continue;
                    }
                    
                    // 分类的页数
                    // 如果是大分类,只生成封面页就可以了,或者仅生成第一页
                    if ($__CAT__['type'] == 1 && ! $__CAT__['list_all_model']) {
                        $pages = 1;
                    } else {
                        $_pages = ceil($__CAT__['item_count'] / $__CAT__['page_size']);
                        $pages = $__task__['pages'] && $__task__['pages'] <= $_pages ? $__task__['pages'] : $_pages;
                    }
                    $pages = max($pages, 1);
                    
                    // 第1页开始
                    $__task__['current_category_page'] = 1;
                    
                    // 分类的页数
                    $__task__['current_category_pages'] = $pages;
                    
                    break;
                }
                
                // _poster($__task_name__);
            }
            // step: 2 end}
            
            // 生成一个分类 step: 3{
            for ($__i__ = 0; $__i__ < $__perpage__; $__i__ ++) {
                
                if (++ $__count__ > $__perpage__)
                    break;
                    
                    // ############## 核心代码 ###############{
                $__page__ = $page = $__task__['current_category_page'] + $__i__;
                
                if ($__task__['mobile']) {
                    $__CAT__['html_list_url_rule'] = $__CAT__['html_list_url_rule_mobile'];
                }
                // 很危险的啦,你懂的啦
                $__CAT__['html_list_url_rule'] = str_replace('"', '', $__CAT__['html_list_url_rule']);
                $__file__ = p8_html_url($this_module, $__CAT__, 'list', false);
                
                if ($__file__) {
                    
                    $this_module->_html['basename'] = basename($__file__);
                    // 取路径
                    $this_module->_html['path'] = str_replace($this_module->_html['basename'], '', $__file__);
                    
                    $page_file = preg_replace('/#([^#]+)#/', '\1', $__file__);
                    $no_page = preg_replace('/#([^#]+)#/', '', $__file__);
                    
                    if ($page == 1) {
                        // 如果是这种情况{$system_url}/#list-{$page}.html#, 第一页使用一个index.$ext来作索引页
                        if (preg_match('/^#.*\.(.*)#$/', $this_module->_html['basename'], $m)) {
                            $this_module->_html['file'] = $this_module->_html['path'] . 'index.' . $m[1];
                        } else {
                            $this_module->_html['file'] = $no_page;
                        }
                    } else {
                        $this_module->_html['file'] = str_replace('?page?', $page, $page_file);
                    }
                    if ($__task__['mobile']) {
                        $__list_uri__ = '/m/index.php/' . $SYSTEM . '/item-list-category-{$id}-page-{$page}';
                        $filename = PHP168_PATH . 'm/index.php';
                    } else {
                        $__list_uri__ = '/index.php/' . $SYSTEM . '/item-list-category-{$id}-page-{$page}';
                        $filename = PHP168_PATH . 'index.php';
                    }
                    eval('$_SERVER[\'_REQUEST_URI\'] = "' . $__list_uri__ . '";');
                    
                    ob_start();
                    require $filename;
                    $__content__ = ob_get_clean();
                    
                    md($this_module->_html['path']);
                    if (! write_file($this_module->_html['file'], $__content__)) {
                        message(p8lang($P8LANG['cms_item_html_unwritable'], array(
                            $this_module->_html['file']
                        )));
                    }
                    @chmod($this_module->_html['file'], 0644);
                }
                // ############## 核心代码 ###############}
                
                if ($__page__ >= $__task__['current_category_pages']) {
                    // 到达分类页数,一个分类生成完毕
                    $__task__['category_offset'] ++;
                    if ($__task__['category_offset'] >= $__task__['category_count']) {
                        // 所有分类生成结束
                        _done();
                    }
                    
                    unset($__task__['current_category_page']);
                    
                    if ($__count__ <= $__perpage__) {
                        // goto: step 2
                        continue 2;
                    }
                }
            }
            // step: 3 end}
            
            // 一次不能生成一个分类的页数,继续生成
            isset($__task__['current_category_page']) && $__task__['current_category_page'] = $__page__ + 1;
            
            /*
             * echo '<pre>';
             * echo print_r($__task__);
             * echo '<hr />';
             * echo $__count__;exit;
             */
            
            break;
        }
        
        _poster($__task_name__, p8lang($P8LANG['cms_item']['htmlize']['list_process'], $__task__['category_offset'], $__task__['category_count'], $__CAT__['name'], $__page__, $__task__['current_category_pages']));
    }