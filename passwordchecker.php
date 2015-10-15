<?php
class PasswordChecker{
  public $errors=array();
  public $rules=array();
  
  public function setRules($rules){
    $this->rules=$rules;
  }
  
  public function getErrors($pass=null){
    if(is_null($pass)){
      return $this->errors;
    }
    return isset($this->errors[$pass])?$this->errors[$pass]:false;
  }

  public function check($password){
    $valid=true;
    if(!empty($this->rules)){
      foreach($this->rules as $rule){
        if(preg_match($rule['regexp'],$password)!==1){
          $valid=false;
          $this->errors[$password][]=$rule['message'];
        }
      }
    }
    return $valid;
  }
}