<?php
require_once 'ooplr/core/init.php';
// var_dump(Token::check(Input::get('token')));
if (Input::exists()){
//     echo "Form submitted". "</br>";
//    echo Input::get('username');
if(Token::check(Input::get('token'))){
    // echo "I have run";
$validate = new Validate();
$validation = $validate->check($_POST, array(
            'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'

            ),
            'password' => array(
                    'required' => true,
                    'min' => 6

            ),
            'password_again' => array(
                    'required' => true,
                    'matches' => 'password'

            ),
            'name' => array(
                   'required' => true,
                   'min' => 2,
                   'max' => 50
            ),

));

if ($validation -> passed()){
    // Session::flash('success', 'You registered successfully');
    // header('Location:index.php');
//    echo "Passed";

//registering users
    $user = new User(); 

     $salt= Hash::salt(32);
    try {
        $user->create(array(
                'username' => Input::get('username'),
                'password' => Hash::make(Input::get('password'),$salt),
                'salt' => $salt,
                'name' => Input::get('name'),
                'joined' => date('Y-m-d H:i:s'),
                'group' => 1
        ));
        Session::flash('home', 'You have been registered and can now log in');
        Redirect::to('index.php');
        // Redirect::to(404);
       
        // header('Location:index.php');
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

else{
    // print_r($validation ->errors());
    foreach($validation->errors() as $error){
            // echo $error, '<br>';
            echo "{$error} <br>";
    }
}
}

 }
?>
<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Enter your Password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Enter your Password Again</label>
        <input type="password" name="password_again" id="password_again">
    </div>
    <div class="field">
        <label for="name">Enter your Name</label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name'));?>" id="name">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">

</form>