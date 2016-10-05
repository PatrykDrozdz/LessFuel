<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['pass']))){
    header('Location: index.php');
    exit();
	}

require_once 'connect.php';

    $conection = new mysqli($host, $db_user, $db_password, $db_name);
    
    if($conection->connect_errno!=0){
        echo"Error: ".$conection->connect_errno;
    }else {

        $log = $_POST['login'];
        $pass = $_POST['pass'];
        ///////////////////////////////////////////
        //zabezpiecznie przed sql injection
        $log = htmlentities($log, ENT_QUOTES, "UTF-8");
        
     
     
        if($result = $conection->query(
                sprintf("SELECT * FROM users WHERE "
                . "email = '%s'",
                mysqli_real_escape_string($conection, $log))))
        {
        ////////////////////// ////////////////////////////   
            $howManyUsers = $result->num_rows;
            
            if($howManyUsers>0){
                
                $row = $result->fetch_assoc();
                
                if(password_verify($pass, $row['password'])){
                
                    $_SESSION['loged'] = true;//
                
                    $_SESSION['id_users'] = $row['id_users'];//pobieranie Id użytkownika
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['pass'] = $row['password'];
                    $flag = $row['flag'];
                
                    unset($_SESSION['error']);
                
                    $result->free();
                    
                    if($flag==1){
                        //echo $flag;
                        header('Location: interface.php');
                    } else if($flag==0){
                       // echo $flag;
                       $_SESSION['error'] = '<span class="error>konto '
                               . 'zostało usunięte!</span>';		
                            header('Location: index.php'); 
                    }
                } else {
					$_SESSION['error'] = '<span class="error">Nieprawidłowy '
                        . 'e-mail lub hasło!</span>';
						
					header('Location: index.php');
                }
                
            }else{
                $_SESSION['error'] = '<span class="errorSpan">Nieprawidłowy '
                        . 'e-mail lub hasło!</span>';
						
                header('Location: index.php');
                }
            }
        
        $conection->close();
    }       
?>