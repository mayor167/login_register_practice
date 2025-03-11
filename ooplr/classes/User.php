<?php
    class User{
        private $db,
                $data,
                $sessionName,
                $cookieName,
                 $isLoggedIn;
        public function __construct($user =null)
        {
            $this -> db = DB::getInstance();
            $this -> sessionName = Config::get('session/session_name');
            $this -> cookieName = Config::get('remember/cookie_name');
            if(!$user){
                if(Session::exists($this -> sessionName)){
                    $user = Session::get($this -> sessionName);
                    if($this -> find($user)){
                            $this -> isLoggedIn = true;
                    }
                    else{
                        //process logout
                        // $this->logout();
                    }
                }
            }
            else{
                $this -> find($user);
            }
        }

        public function update($fields =array(), $id=null){
            if (!$id && $this -> isLoggedIn()){
                    $id = $this -> data() -> id;
            }

            
            if(!$this -> db -> update('users', $id, $fields)){
                    throw new Exception('There was a problem updating'); 

                }
        }

        public function create($fields =array()){
            if(!$this -> db -> insert('users', $fields)){
                throw new Exception('There was a problem creating an account.');

            }
        }
        public function find($user = null){
                if($user){
                        $field = (is_numeric($user)) ? 'id' : 'username';
                        $data = $this->db->get('users', array($field, '=', $user));
                        if ($data -> count()){
                                $this -> data = $data->first();
                                return true;
                        }
                }
                return false;
        }
        Public function login( $username = null, $password = null,$remember = false ){
        

                if(!$username && !$password && $this -> exists()){
                    //log user in
                    Session::put($this -> sessionName, $this -> data() -> id);
                }else{
                    $user = $this->find($username);
            if($user){
                if($this -> data() -> password === Hash::make($password, $this -> data() -> salt)){
                    // echo "OK!";
                    Session::put($this -> sessionName, $this->data()->id);
                    if($remember){
                        $hash = Hash::unique();
                        $hashCheck = $this -> db->get('users_session', array('user_id', '=', $this -> data() ->id)); //check if hash has been stored in db
                        if(!$hashCheck -> count()){
                            $this -> db -> insert('users_session',array(
                                'user_id' => $this -> data()->id,
                                'hash' => $hash
                            ));
                        }
                        else{
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put($this->cookieName,$hash, Config::get('remember/cookie_expiry'));

                    }
                    return true;
                    
                }
            }
                }
        //   print_r($this -> data);
          return false;      
        }
        public function hasPermission($key){
           $group = $this -> db -> get('groups', array('id', '=', $this->data()->group)); 
        //    print_r($group->first());
        if ($group -> count()){
             $permissions = json_decode($group -> first()->permissions, true);
            // print_r( $permissions);
            if($permissions[$key] ==true){
                return true;
            }
        }
        return false;
        }

        public function exists(){
            return (!empty($this -> data)) ? true : false;
        }
        public function logout(){
            $this -> db -> delete('users_session', array('user_id', '=', $this -> data() -> id)); // delete user hash in users_session table as well        
            Session::delete($this -> sessionName);
            Cookie::delete($this ->cookieName );
        }
        public function data(){
            return $this -> data;
        }
        public function isLoggedIn(){
            return $this -> isLoggedIn;
        }
    }
   

?>