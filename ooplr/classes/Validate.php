<?php
        class Validate{
            private $passed = false,
                    $errors = array(),
                    $db = null;
            public function __construct(){
                $this -> db = DB::getInstance();
            }

            public function check($source, $item =array()){
                foreach($item as $item => $rules){
                    foreach($rules as $rule =>$rule_value){
                        // echo"{$item} {$rule} must be {$rule_value} </br>";
                        $value = trim($source[$item]) ;
                        // echo $value;
                        if ($rule === 'required' && empty($value)){
                            $this -> addError("{$item} is required");

                        } 
                        else{
                            switch ($rule) {
                                case 'min':
                                    if(strlen($value) < $rule_value){
                                        $this ->addError("{$item} must be a minimum of {$rule_value} characters.");
                                    }
                                    break;
                                case 'max':
                                    if(strlen($value) > $rule_value){
                                        $this ->addError("{$item} must be a maximum of {$rule_value} characters.");}
                                    break;
                                 case 'matches':
                                    if($value !=$source[$rule_value]){
                                        $this -> addError("{$rule_value} must be match {$item}");
                                    }
                                    break;
                                case 'unique':
                                   $check = $this->db->get($rule_value, array($item, '=', $value));
                                   if($check->count()){
                                    $this -> addError("{$item} already exists.");
                                   }
                                    break;
                                // default:
                                //     # code...
                                //     break;
                            }

                        }

                    }
                }
                if (empty($this -> errors)){
                    $this -> passed = true;
                }
                return $this;
            } 
            private function addError($error){
                    $this->errors[] = $error;
            }
            public function errors(){
                return $this -> errors;
            }
            public function passed(){
                return $this-> passed;
            }
        }

?>