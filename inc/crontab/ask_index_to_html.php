<?php
defined('PHP168_PATH') or die();

/**
* ��ҳ��̬
**/

$system = &$core->load_system('ask');
//������
unset($this_module, $CAT, $data, $TITLE, $SEO_KEYWORDS, $SEO_DESCRIPTION);

//�������ɾ�̬�ĳ���
defined('P8_GENERATE_HTML') or define('P8_GENERATE_HTML', true);

$_SERVER['_REQUEST_URI'] = '/index.php/ask';

ob_start();
require PHP168_PATH .'index.php';

$content = ob_get_clean();
if($core->CONFIG['index_system'] == $system->name){
	write_file(PHP168_PATH .'index.html', $content);
	@chmod(PHP168_PATH .'index.html', 0644);
}

write_file($system->path .'index.html', $content);
@chmod($system->path .'index.html', 0644);