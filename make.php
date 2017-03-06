<?php 

    
        $page = isset($_GET['page']) ? $_GET['page'] : 'main';
        
    if(isset($_POST['email'])){
        
        //walidacja
        $valid = true;
        ////////////////////////////////////////////////////////
        //imię
        $name = $_POST['yourName'];
        
        //spr długości imienie
        if(strlen($name)<3 || strlen($name)>20){
            $valid = false;
            $_SESSION['error_name'] = "Imię może składać się od 3 do 20 znaków!";
        }
        
        //sprawdzanie znaków alfanumerycznych
        if(ctype_alnum($name)==FALSE){
            $valid=FALSE;
            $_SESSION['error_name'] = "Imię może składać się tylko "
                    . "z liter i cyfr (bez polskich zanków)";
        }
        ////////////////////////////////////////////////////////
        //email
        $email = $_POST['email'];
        //email bezpieczny - sanityzowany
        $email_san = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if((filter_var($email_san, FILTER_VALIDATE_EMAIL)==FALSE) || 
                $email_san!=$email){
            $valid = FALSE;
            $_SESSION['error_email'] = "Podaj poprawny adres e-mail";
            }
        ///////////////////////////////////////////////////////////
        //hasła
        $pass1 = $_POST['pass1'];    
        $pass2 = $_POST['pass2'];
        
        if((strlen($pass1)<5) || (strlen($pass1)>15)){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Hasło musi mieć od 5 do 15 znaków";
        }
        
        if($pass1!=$pass2){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Podane hasła są różne";
        }
        
        //hashowanie hasła
        $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
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
        require_once 'connect.php';
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        try{
            $conection = new mysqli($host, $db_user, $db_password, $db_name);
            
            if($conection->connect_errno!=0){
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
            }
            
        }catch(Exception $e){
            echo '<span class="error">Błąd serwera!</span>';
			
            echo'</br>'; //deweloper infor
            echo '<span class="error">developer info: '.$e.'</span>';

        }
        
        
        
    }
?>


