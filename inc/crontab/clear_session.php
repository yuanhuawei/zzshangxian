<?php
defined('PHP168_PATH') or die();

delete_session('lastview < \''. (P8_TIME - 86400) .'\'');
delete_session('uid=0 AND lastview < \''. (P8_TIME - 1200) .'\'');