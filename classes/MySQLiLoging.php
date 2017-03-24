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
        
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['loged'] = true;
        $_SESSION['id_users'] = $row['id_users'];//pobieranie Id użytkownika
        $_SESSION['name'] = $row['name'];
        $_SESSION['pass'] = $row['password'];
        
        unset($_SESSION['error']);

        header('Location: interface.php');
        
        mysqli_free_result($result);
            
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