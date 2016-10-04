<?php 
    
    session_start();
    
    //skrypt zabezpieczający
    if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
        header('Location: interface.php');
        exit();//opuszczanie skryptu
        }
    
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
        
        //sprawdzanie bota
        ////////////////////////////////
       $secret_key = '6Le8iSATAAAAAFDonMOENcCNJK83kftM56mnklEA';
        
        $check_key = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.
                $_POST['g-recaptcha-response']);
        $check_key_decode = json_decode($check_key);
        
        if(!($check_key_decode->success)){
            $valid=false;
            $_SESSION['error_bot'] = "Brak weryfikacji!";
        }
        
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
                        header("Location: welcome.php");
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


<!DOCTYPE html>

<html lang="pl">
    <head>
        <meta charset="UTF-8">
        
        <title>LessFuel - rejestracja</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/slider.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

        
    </head>
    <body onload="change_slide()">
        <div class="container">
            
            <div id="header">
                <h1>LessFuel</h1>
                
                <a href="http://localhost/lessfuel/index.php">Strona główna</a>
            </div>
                <div id="give_your_e-mail">   
                    <div id="left_log">
                    <form method="post">
                    <br/>
                    e-mail:
                    <br/>
                    <input type="text" name="email" id="textfield"/>
                    
                     <?php 
                        if(isset($_SESSION['error_email'])){
                            echo '<div class="error">'.$_SESSION['error_email'].'</div>'; 
                            unset($_SESSION['error_email']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    imię:
                    <br/>
                    <input type="text" name="yourName" id="textfield"/>
                    
                    <?php 
                        if(isset($_SESSION['error_name'])){
                            echo '<div class="error">'.$_SESSION['error_name'].'</div>'; 
                            unset($_SESSION['error_name']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    hasło:
                    <br/>
                    <input type="password" name="pass1" id="textfield"/>
                    
                     <?php 
                        if(isset($_SESSION['error_pass'])){
                            echo '<div class="error">'.$_SESSION['error_pass'].'</div>'; 
                            unset($_SESSION['error_pass']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    powtórz hasło:
                   <br/>
                    <input type="password" name="pass2" id="textfield"/>
                    <br/>
                    <br/>
                    <label>
                    <input type="checkbox" name="reg"/> Akceptuje 
                    </label>
                    <a href="">regulamin</a>
                    
                    <?php 
                        if(isset($_SESSION['error_reg'])){
                            echo '<div class="error">'.$_SESSION['error_reg'].'</div>'; 
                            unset($_SESSION['error_reg']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    <div class="g-recaptcha" data-sitekey="6Le8iSATAAAAACnjxq8O4J7X-JRwTe2zM16aOiwh"></div>
                    <?php 
                        if(isset($_SESSION['error_bot'])){
                            echo '<div class="error">'.$_SESSION['error_bot'].'</div>'; 
                            unset($_SESSION['error_bot']);
                        }
                    ?>
          
                    <input type="submit" value="Załóż konto" id="button"/>
                    
                </form>
                    </div>
                    <div id="right_info2">
                        <div id="photos"></div>
                    </div>    
                    
                </div>
           
            <div id="footer">
               LessFuel &copy; Prawa zastrzeżone
               
               <div id="add">
                   Developed by Patryk Dróżdż
               </div>
               
               <div class="add2">

               </div>
               
               <div class="add2">
                   pdrozdz@onet.eu
               </div>
               
            </div>
            
        </div>
        
    </body>
</html>
