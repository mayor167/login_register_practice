<?php
        class DB{
            private static $instance = null;
            private $pdo, 
            $query, 
            $error = false,
             $results, 
             $count=0;
             private function __construct(){
                try {
                   // var_dump(Config::get('mysql/host'));
                    $this -> pdo = new PDO( 'mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/dbname'),
                    Config::get('mysql/username'),
                    Config::get('mysql/password'));
                    echo "connected!". "<br>";
                } catch (PDOException $e) {
                    die("Database Connection falied".$e->getMessage());
                }
            }
            public static function getInstance(){
                    if (!isset(self::$instance)){
                        self::$instance = new DB;
                        return self::$instance;   
                    }
                    else
                     return self::$instance;      
            }  
        public function query($sql, $params = array()){
                $this-> error = false;
                if($this-> query = $this ->pdo-> prepare($sql)){
                        $x=1;
                        if (count($params)){
                            foreach($params as $param){
                                        $this-> query->bindValue($x, $param);
                                         $x++;
                            }
                        }
                        if($this -> query-> execute()){
                                // echo 'Success';
                                $this -> results = $this -> query->fetchAll(PDO::FETCH_OBJ);
                                $this -> count = $this->query->rowCount();
                        }
                        else{
                            $this -> error =true;
                        }
                }
                return $this; //methods chaining here
        }

        public function action ($action,$table, $where = array()){
                if(count($where) ===3 ){
                    $operators = array('=', '>','<', '>=', '<=');

                    $field     = $where[0];
                    $operator  = $where[1];
                    $value     =  $where[2]; 

                    if(in_array($operator, $operators)){
                        $sql = "{$action} FROM {$table} WHERE {$field}{$operator} ?"; 
                        if (!$this->query($sql, array($value))->error()){
                            return $this; //methods chaining here
                        }

                    }

                }
                return false;
        }
        public function get ($table, $where ){
            return $this->action('SELECT *', $table, $where); 

        }
        public function delete($table, $where){
            return $this->action('DELETE *', $table, $where); 

        }
        public function insert($table ,$fields = array()){
            if (count($fields)){
                    $keys = array_keys($fields);
                    $values = '';
                    $x = 1;

                    foreach($fields as $field){
                        $values.= '?';
                        if($x < count($fields)){
                            $values .= ', ';
                    }
                    $x++;
                }
                    // die($values);
                    $sql = "INSERT INTO users(`". implode('`,`', $keys)."`) VALUES ({$values })";
                    // echo $sql;
                    if(!$this->query($sql,$fields)->error()){
                            return true;
                    }
            }
            return false;
        }
        public function update($table, $id, $fields){
                    $set = '';
                    $x = 1;
                    foreach($fields as $name => $value){
                        $set .="{$name} = ?";
                        if ($x < count($fields)){
                         $set .= ', ';
                        }
                        $x++;

                    }
                    // die($set);
                    $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
                    // echo $sql;
                    if (!$this ->query($sql, $fields)->error()){
                            return true;
                    }
                    else{
                        return false;
                    }
        }
        public function results(){
            return $this -> results;
        }
        public function first(){
            return $this -> results()[0];
        }
        public function error(){
            return $this -> error;
        }
        
        public function count(){
            return $this->count;
        }
       
        
        }
?>