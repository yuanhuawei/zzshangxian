<?php
defined('PHP168_PATH') or die();

/**
* ��ҳ��̬
**/

//������
unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);

//�������ɾ�̬�ĳ���
defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);

$_SERVER['_REQUEST_URI'] = '/index.php/opinion-main';

ob_start();
require PHP168_PATH .'index.php';

$content = ob_get_clean();

write_file(PHP168_PATH .'opinion-main.html', $content);
@chmod(PHP168_PATH .'opinion-main.html', 0644);