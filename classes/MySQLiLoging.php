<?php

include 'classes/MySQLiConnect.php';

class MySQLiLoging extends MySQLiConnect{
    
    //sprawdzanie hasła
    public function checkPass($pass, $passFromDB){
        
        if(password_verify($pass, $passFromDB)){
            return true;
        } else {
            return false;
        }
        
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
    
}


?>