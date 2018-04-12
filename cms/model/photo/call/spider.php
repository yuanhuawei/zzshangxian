<?php
defined('PHP168_PATH') or die();

/**
* 处理采集的数据,映射字段
**/

$func = '_spider_'. $MODEL;

$FUNC = <<<FUNC
\$POST['field#']['content'] = isset(\$POST['data']['content']) ? \$POST['data']['content'] : '';

\$POST['field#']['photourl']['title'] = isset(\$POST['data']['name']) ? \$POST['data']['name'] : array();
\$POST['field#']['photourl']['url'] = isset(\$POST['data']['image']) ? \$POST['data']['image'] : array();
\$POST['field#']['photourl']['thumb'] = isset(\$POST['data']['thumb']) ? \$POST['data']['thumb'] : array();
FUNC;

$$func = create_function('&$POST', $FUNC);