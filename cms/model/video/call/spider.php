<?php
defined('PHP168_PATH') or die();

/**
* ����ɼ�������,ӳ���ֶ�
**/

$func = '_spider_'. $MODEL;

$FUNC = <<<FUNC
\$POST['field#']['content'] = isset(\$POST['data']['content']) ? \$POST['data']['content'] : '';

\$POST['field#']['video_url'] = isset(\$POST['data']['video_url']) ? \$POST['data']['video_url'] : '';

FUNC;

$$func = create_function('&$POST', $FUNC);