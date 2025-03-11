<?php
require_once "ooplr/core/init.php";
if(Session::exists('home')){
    $message = Session::flash('home');
   echo '<p>'.$message.'</p>';
}
// echo Session::get(Config::get('session/session_name'));
$user = new User(); //current user
if ($user->isLoggedIn()){
//  echo "Logged in";
?>
<p>Hello <a href = "profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username);?></a>!</p>
<ul>
    <li><a href="logout.php">Log out</a></li>
    <li><a href="update.php">Update details</a></li>
    <li><a href="changepassword.php">Change your password</a></li>
</ul>
<?php
//adding permission
if($user->hasPermission('admin')){
 echo '<p>You are an administrator</p>';
}


}else{
    echo '<p>You need to <a href = "login.php">log in</a> or <a href ="register.php">register</a></p>';
}
// echo $user -> data()->username
// $anotheruser = new User(6) //another user

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
// $userInsert = DB::getInstance()->update('users', 3, array(
//                 'password' => 'userpassword',
//                 'name'     =>  'Dale Mayorsky'
                
// ));
 ?>
