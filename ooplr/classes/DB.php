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
                    echo "connected";
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            public static function getInstance(){
                    if (!isset(self::$instance)){
                        self::$instance = new DB;
                    }
                    else{
                        return self::$instance = new DB();
                    }
            }  

        }
?>