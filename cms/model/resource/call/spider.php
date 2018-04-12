<?php
defined('PHP168_PATH') or die();

/**
* 处理采集的数据,映射字段
**/

$func = '_spider_'. $MODEL;

$FUNC = <<<FUNC
global \$this_model;

\$POST['field#']['content'] = isset(\$POST['data']['content']) ? \$POST['data']['content'] : '';


FUNC;

$$func = create_function('&$POST', $FUNC);