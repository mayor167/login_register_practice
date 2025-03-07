<?php
    class User{
        private $db,
                $data,
                $sessionName;
        public function __construct($user =null)
        {
            $this -> db = DB::getInstance();
            $this -> sessionName = Config::get('session/session_name');

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
        Public function login($username = null, $password = null){
          $user = $this->find($username);
            if($user){
                if($this -> data() -> password === Hash::make($password, $this -> data() -> salt)){
                    // echo "OK!";
                    Session::put($this -> sessionName, $this->data()->id);
                    return true;
                }
            }
        //   print_r($this -> data);
          return false;      
        }
        private function data(){
            return $this -> data;
        }
    }
   

?>