<?php 
        
    require_once 'connect.php';
    include 'classes/MySQLiMake.php';
    include 'classes/mathFunctions.php';
    
    $connection = new MySQLiMake($host, $db_user, $db_password, $db_name);
    $mathFun = new mathFunctions();
    
    if(isset($_POST['email'])){
        
        //walidacja
        $valid = true;
        ////////////////////////////////////////////////////////
        //imię
        $name = $_POST['yourName'];
        
        //spr długości imienie
        
        $nameLength = $mathFun->wordLength($name);
        
        if($mathFun->inequality(3, $nameLength)==true || 
                $mathFun->inequality($nameLength, 20)==true) {
            $valid = false;
            $_SESSION['error_name'] = "Imię może składać się od 3 do 20 znaków!";
        }
        
        //sprawdzanie znaków alfanumerycznych
        if($connection->alphaNumericCheck($name) == FALSE){
            $valid=FALSE;
            $_SESSION['error_name'] = "Imię może składać się tylko "
                    . "z liter i cyfr (bez polskich zanków)";
        }
        ////////////////////////////////////////////////////////
        //email
        $email = $_POST['email'];
        //email bezpieczny - sanityzowany
        $email_san = $connection->emailSan($email);
        
        if($connection->filterVar($email_san) || 
                $email_san!=$email){
            $valid = FALSE;
            $_SESSION['error_email'] = "Podaj poprawny adres e-mail";
        }
        ///////////////////////////////////////////////////////////
        //hasła
        $pass1 = $_POST['pass1'];    
        $pass2 = $_POST['pass2'];
        
        $passLength = $mathFun->wordLength($pass1);
        
        if($mathFun->inequality(5, $passLength)==true || 
                $mathFun->inequality($passLength, 15)==true){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Hasło musi mieć od 5 do 15 znaków";
        }
        
        if($mathFun->equality($pass1, $pass2)==FALSE){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Podane hasła są różne";
        }
        
        //hashowanie hasła
        $pass_hash = $connection->passwordHash($pass1);
        //echo $pass_hash; exit(); //sprawdzanie hashu
        
        //regulamin - checkbox
        //echo $_POST['reg'];exit(); //sprawdzanie checkbox'a
        ///////////////////////////////////////
        if(!isset($_POST['reg'])){
            $valid=FALSE;
            $_SESSION['error_reg'] = "Nie zaakceptowano regulaminu!";
        }
        ////////////////////////////////////////

        
        //sprawdzanie, czy nie ma już zarejesrtowanego danego e-maila

        
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        try{
            
            $safer = $connection->injectionSafer($email);
            
            $queryCheck = sprintf("SELECT * FROM users WHERE email='%s'", 
                    mysqli_real_escape_string($connection, $safer));
            
            $result = $connection->queryExecuter($connection, $queryCheck);
            
            $howManyEmails = $connection->rowCount($result);
            
            if($mathFun->inequality(0, $howManyEmails)==FALSE){
                $valid = FALSE;
                $_SESSION['error_email'] = "E-mail o podanym adresie jest już w bazie!";
            }
            
            /*if($conection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }else{
				
                //czy istnieje e-mail
                $result = $conection->query("SELECT * FROM users WHERE email='$email'");

                if(!$result) {
                    throw new Exception ($conection->errno);
                }
                $howManyEmails = $result->num_rows;

                if($howManyEmails>0){
                    $valid=false;
                    $_SESSION['error_email'] = "E-mail o podanym adresie jest już w bazie!";
                }
             //wpisywanie co bazy danych
             /////////////////////////////////////////////
			 
			 $valid=true;
			 
                if($valid==true){
				
                    //testy azliczone, użytkownik wpisany do bazy
                    //echo"udana walidacja ".$_POST['yourName'];
                    //exit();
                    
                    //(id, name, e_mail, password) 
					
                    $flag = 1;
					
                    if($conection->query("INSERT INTO users (id_users, name, email, password, flag) "
                            . "VALUES (NULL, '$name', '$email', '$pass_hash', '$flag')")){
                        $_SESSION['registered']=true;
                        //$page = 'welcome';
                        header("Location: index.php?page=welcome");
                    }else {
                        throw new Exception($conection->errno);
                    }
                }
                ///////////////////////////////////////////
                $conection->close();
            }*/
            
        }catch(Exception $e){
            
            $_SESSION['error'] = '<span class="error">Błąd serwera!</span> </br> '
                    . '<span class="error">developer info: '.$e.'</span>';
			
        }
        
        
        
    } else {
        //$_SESSION['error_email'] = "Nie podano e-mail'a";
    }
?>


