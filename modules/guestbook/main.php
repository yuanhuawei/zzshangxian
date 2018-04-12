<?php
defined('PHP168_PATH') or die();
if($this_module->CONFIG['ifCloseGuestBook'] && !$IS_FOUNDER)message('guestbook is closed');
require $this_module->path .'/list.php';
?>