<?php 
require_once 'ooplr/core/init.php';

$user = new User();
if(!$user -> isLoggedIn()){
        Redirect::to('index.php');
}
if (Input::exists()){//check if user supply inputs and token is correct
    if(Token::check(Input::get('token'))){
            // echo 'Ok!';
            $validate = new Validate();
            $validation = $validate -> check($_POST, array(
                'name' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                )
            ));
            if($validation -> passed()){
                try {
                    $user -> update(array(
                                'name' => Input::get('name')
                    ));
                    Session:: flash('home', 'Your details are successfully updated');
                    Redirect::to('index.php');
                } catch (Exception $e) {
                    die($e -> getMessage());
                }
                
            }
            else{
                foreach($validation -> errors() as $error){ //loop thru available errors
                    echo $error, '<br>';
                }
    }
}
}
?>
<form action="" method="POST">
    <div class="field">
    <label for="name">Name</label>
    <input type="text" name ="name" value="<?php echo escape($user -> data() -> name);?>">
    <input type="submit" value="Update">
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    </div>

</form>