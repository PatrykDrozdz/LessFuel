<?php

include 'classes/MySQLiConnect.php';

class MySQLiLoging extends MySQLiConnect{
    
    private $result;
    
    //sprawdzanie hasła
    public function checkPass($pass, $passFromDB){
        
        if(password_verify($pass, $passFromDB)){
            return true;
        } else {
            return false;
        }
        
    }
    
    public function queryLog($connection, $query, $log){

        if($this->result=mysqli_query($connection,
                    sprintf($query,
                    mysqli_real_escape_string($connection, $log)))){
            return true;
        } else {
            return false;
        }

    }
    
    public function getResultLog() {
        return $this->result;
    }

    public function logInto($result){

        $_SESSION['loged'] = true;
        
        unset($_SESSION['error']);

        header('Location: interface.php');
        
    }
    
    public function logError($connection){
        
        unset($_SESSION['registered']);
        unset($_SESSION['login']);
        unset($_SESSION['pass']);

        session_unset();

        $_SESSION['error'] = '<span class="error">konto '
            . 'zostało usunięte!</span>';		
        header($connection->getIndexString());
        
    }
    
}


?>