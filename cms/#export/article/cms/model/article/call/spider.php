<?php
defined('PHP168_PATH') or die();

/**
* ����ɼ�������,ӳ���ֶ�
**/

$func = '_spider_'. $MODEL;

$FUNC = <<<FUNC
\$POST['field#']['content'] = isset(\$POST['data']['content']) ? \$POST['data']['content'] : '';

FUNC;

$$func = create_function('&$POST', $FUNC);