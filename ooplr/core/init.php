<?php
session_start();
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
    'session_name' => 'user',
    'token_name' => 'token'
  )
);
spl_autoload_register(function($class){
require_once __DIR__. "/../classes/". $class.".php";
// $file = __DIR__."/../classes/". $class.".php";
// echo $file;
});
require_once 'ooplr/functions/sanitize.php';

//algorithm to keep user logged if they have logged in before and thier pc got shutdown and thier session haven't expired

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
  // echo 'User has to be remembered';
   $hash = Cookie::get(Config::get('remember/cookie_name'));
  $hashCheck = DB::getInstance() -> get('users_session',array('hash', '=', $hash));
  if($hashCheck -> count()){
        // echo 'Hash matches, log user in';
        $user = new User($hashCheck -> first() -> user_id);
        $user -> login();
  }
}
  
?>
