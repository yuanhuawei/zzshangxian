<?php
defined('PHP168_PATH') or die();

$captcha = $_POST['captcha'];
exit(captcha($captcha,true)==1? 'true' : 'false');
?>