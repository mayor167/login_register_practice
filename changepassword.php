<?php
require_once 'ooplr/core/init.php';
$user = new User();

if (!$user -> isLoggedIn()){
    Redirect::to('index.php');
}

if (Input::exists()){ //check if user supplies inputs
if(Token::check(Input::get('token'))){//check if actaully the inputs are supplied from this form(trying to avaoid XSS)
// echo 'OK!';
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
                    'password_current' => array(
                        'required' => true,
                        'min' => 6
                    ),
                    'password_new' => array(
                        'required' => true,
                        'min' => 6

                    ),
                    'password_new_again' => array(
                        'required' => true,
                        'min' => 6,
                        'matches' => 'password_new'

                    )
                 ));
                 if($validation -> passed()){
                    //change password

                    if(Hash::make(Input::get('password_current'), $user->data()->salt) !==$user->data()->password){
                        echo 'Your current passowrd is wrong';
                    }
                    else{
                        // echo 'Ok!';
                        $salt = Hash::salt(32); //create another salt
                        $user -> update(array(
                              'password' => Hash::make(Input::get('password_new'),$salt),
                                'salt' => $salt
                        ));
                        Session::flash('home', 'Your password hass been changed');
                        Redirect::to('index.php');

                    }
                 }
                 else{
                    foreach($validation -> errors() as $error){
                               echo $error, '<br>'; 
                    }
                 }
}
}

?>

<form action="" method="POST">
<div class="field">
    <label for="password_current">Current Password</label>
    <input type="password" name="password_current" id="password_current" autocomplete="off">
</div>
<div class="field">
    <label for="password_new">New Password</label>
    <input type="password" name="password_new" id="password_new" autocomplete="off">
</div>
<div class="field">
    <label for="password_new_again">New Password again</label>
    <input type="password" name="password_new_again" id="password_new_again" autocomplete="off">
</div>
<input type="submit" value="Change ">
<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">


</form>