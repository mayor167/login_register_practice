<?php
class Config {
    public static function get ($path = null){
            if ($path){
                $config = $GLOBALS['config'];
               // print_r($config);
                $path = explode('/', $path);
                // print_r($path);
                foreach($path as $bit){
                // echo $bit. '<br>';
                if (isset($config[$bit])){
                    // echo 'set'.'<br>';
                    // print_r($config[$bit]);
                    // echo '<br>';
                    $config = $config[$bit];
                }
                }
                return $config;
            }
    }
 
}
?>