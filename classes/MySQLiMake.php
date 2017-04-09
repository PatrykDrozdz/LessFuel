<?php

include 'classes/MySQLiConnect.php';

class MySQLiMake extends MySQLiConnect {
    
    public function alphaNumericCheck($value){
        
        if(ctype_alnum($value)==FALSE){
            return FALSE;
        } else {
            return TRUE;
        }
        
    }
    
    public function emailSan($value){
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
    
    public function filterVar($value){
        if(filter_var($value, FILTER_VALIDATE_EMAIL)==FALSE){
            return false;
        } else {
            return true;
        }
    }
    
    public function passwordHash($value){
        return password_hash($value, PASSWORD_DEFAULT);
    }
    
}

?>