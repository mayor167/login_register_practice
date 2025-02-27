<?php
$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
     'dbname' => 'login_register_test'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user'
  )
);
spl_autoload_register(function($class){
require_once __DIR__. "/../classes/". $class.".php";
// $file = __DIR__."/../classes/". $class.".php";
// echo $file;
});
require_once 'ooplr/functions/sanitize.php';
?>