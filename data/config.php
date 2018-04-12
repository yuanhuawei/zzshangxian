<?php
return array (
  'DB_master' => 
  array (
    'host' => 'localhost',
    'port' => '3306',
    'user' => 'root',
    'password' => 'root',
    'db' => 'jt',
    'pconnect' => 0,
  ),
  'memcache' => 
  array (
    'enabled' => 0,
    'host' => 'localhost',
    'port' => '11211',
    'pconnect' => 1,
    'prefix' => 'EOIE_',
    'server' => 
    array (
      'localhost:11211' => 
      array (
        'host' => 'localhost',
        'port' => 11211,
      ),
    ),
  ),
  'table_prefix' => 'p8_',
);