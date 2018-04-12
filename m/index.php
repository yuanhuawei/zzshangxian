<?php
$_GET['ismobile']=1;
defined('ISMOBILE') || define('ISMOBILE',true);
defined('FROM_MOBILE') || define('FROM_MOBILE',true);
require dirname(__FILE__).'/../index.php';