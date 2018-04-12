<?php
defined('PHP168_PATH') or die();

md(CACHE_PATH . $SYSTEM .'/modules/'. $MODULE. '/task/', true);
md(CACHE_PATH . 'db_backup/', true);