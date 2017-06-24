<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['pass']))){
    header('Location: index.php');
    exit();
	}

require_once 'connect.php';
include 'classes/MySQLiLoging.php';
include 'classes/mathFunctions.php';

    if(isset($_POST['login']) && isset($_POST['pass'])){

        $log = $_POST['login'];
        $pass = $_POST['pass'];
    
        $connection = new MySQLiLoging($host, $db_user, $db_password, $db_name);
        $mathFun = new mathFunctions();

        $log = $connection->injectionSafer($log);
        
        $indexString = $connection->getIndexString();
        
        try{
            
            $query = "SELECT * FROM users WHERE email = '%s'";
            
            $connection->queryLog($connection, $query, $log);
            
            $result = $connection->getResultLog();

            $howManyUsers = $connection->rowCount($result);
            
            //sprawdzanie, czy użytkownik jest w bazie
            if($mathFun->inequality($howManyUsers, 0)==true){
                
                $row = mysqli_fetch_assoc($result);
        
                //sprawdzanie hasła hashowanego
                if($connection->checkPass($pass, $row['password'])==TRUE) {
                    
                    //sprawdzanie, czy użytkownik jest aktywny
                    if($mathFun->equality($row['flag'], 1)==TRUE){
                                                
                        $_SESSION['id_users'] = $row['id_users'];//pobieranie Id użytkownika
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['pass'] = $row['password'];
                        
                        $connection->logInto($result);
                        
                    } else {
                    
                        $connection->logError($connection);
                        
                    }
                        
                } else {

                    $_SESSION['error'] = '<span class="error">Nieprawidłowe '
                            . 'hasło!</span>';
                    header($indexString);

                }
                
                mysqli_free_result($result);

            } else {

                $_SESSION['error'] = '<span class="error">Nieprawidłowy '
                        . 'login!</span>';

                header($indexString);

            }

        } catch(Exception $e) {

            $_SESSION['error'] = '<span class="error">Błąd serwera!</span>';					

            header($indexString);

        }

        mysqli_close($connection);
    
    } else {
        
        $_SESSION['error'] = '<span class="error">Brak loginu lub hasło!</span>';
        
        header($indexString);
        
    }
    
?>