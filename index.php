<?php
require_once "ooplr/core/init.php";
// echo "<h1>I'm dev </h1>";
// echo Config::get('mysql/host');
// $user = DB::getInstance()->query("SELECT username FROM users WHERE username=?", array('alex')); //connect to db here
// $user = DB::getInstance()->get('users', array('username', '=', 'alex'));
// $user = DB::getInstance()->query("SELECT * FROM users");

// if(!$user -> count()){
//     echo 'No User';

// }
// else {
//     echo $user -> first()->username;
//     // echo $user->results()[0]->username;
//     // foreach($user->results() as $user){   
//     //     // echo $user->username, '<br>';
       
//     // }
// }
// $user = DB::getInstance() -> insert('users', array(
//     'username' => 'Dale',
//      'password' => 'password',
//       'salt' => 'salt' )); 
$userInsert = DB::getInstance()->update('users', 3, array(
                'password' => 'userpassword',
                'name'     =>  'Dale Mayorsky'
                
));
 ?>
