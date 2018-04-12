<?php
/**
*js調用標簽數據
**/
$name = isset($_GET['n'])?trim($_GET['n']):'';
$id = isset($_GET['id'])?intval($_GET['id']):0;
$page = isset($_GET['p'])?intval($_GET['p']):0;
$page = max(1, $page);
if(!$id && !$name)exit("document.write('label name is need!!');");


require dirname(__FILE__) .'/../inc/init.php';
$name = html_entities($name);
defined('PHP168_PATH') or die();
$LABEL = &$core->load_module('label');
global $__label;
global $SYSTEM, $MODULE, $LABEL_POSTFIX, $LABEL_PAGE; 
$name = from_utf8($name);

$LABEL->init('core', 'label', $LABEL_PAGE);

$LABEL->get_data_cache();
$data = $LABEL->display($name);
$LABEL->refresh_labels();	
$label = str_replace(array("'","\r\n","\r"),array("\'",' ',' '),$data);
echo "document.write('".$label."');";
exit;

