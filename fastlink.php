<?php
require_once 'inc/init.php';
$Shortcut = "[InternetShortcut]

URL={$core->CONFIG['url']}

";

Header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename={$core->CONFIG['site_name']}.url;"); 

echo $Shortcut;

?>