<?php
        class Input{
            public static function exists($type='POST' ){
                    switch($type){
                        case 'POST':
                            // var_dump($_POST);
                            return (!empty($_POST))? true : false;
                            break;
                            case 'GET':
                                return(!empty($_GET))? true :false;
                                break;
                                default:
                                return false;
                                break;
                    }
            }
            public static function get($item){
                if (isset($_POST[$item])){
                        return $_POST[$item];
                }
                else if(isset($_GET[$item])){
                        return $_GET[$item];
                }
                else
                return '';
            }
        }
 
?>