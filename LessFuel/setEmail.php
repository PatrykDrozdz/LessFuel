<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
    if(isset($_POST['email'])){
        //walidacja
        $valid=true;
        
        $email = $_POST['email'];

        
        
        //email sprawdzanie
        //sanityzacja
        $email_san = filter_var($email, FILTER_SANITIZE_EMAIL); 
    
        
       
        
        if((filter_var($email_san, FILTER_VALIDATE_EMAIL)==FALSE) || 
                $email_san!=$email){
            $valid = FALSE;
            $_SESSION['error_email'] = "Podaj poprawny adres e-mail";
        }  else {
            
            require_once 'connect.php';
                
            mysqli_report(MYSQLI_REPORT_STRICT);
            
            try{
                $conection = new mysqli($host, $db_user, $db_password, $db_name);
                
                if($conection->errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                        
                    $id = $_SESSION['id'];
                    if($valid==true){
                        
                        if($conection->query("UPDATE  users SET e_mail = '$email' WHERE id='$id'")){
                            $_SESSION['email_change']="E-mail został zmieniony";
                        } else {
                            throw new Exception($conection->errno);
                        }
                }
                ///////////////////////////////////////////
                $conection->close();

            }
                
                
            }catch(Exceptione $e){
                 echo '<span class="error">Błąd serwera!</span>';
                 echo'</br>'; //deweloper infor
                 echo 'developer info: '.$e;
            }
                 
        }
        ///////////////////////////////////////////////////////////
        
    }
    
?>


<!DOCTYPE html>
        
<html lang="pl">
    <head>
        
        
        <meta charset="UTF-8">
        
        <title>Aplikacja pozwalająca zapisać oraz sprawdzić ilość zużytego paliwa</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>

        
    </head>
    <body>
        <div class="container">
            
            <div id="header">
                <h1>LessFuel</h1>
                
                <div class="logingout">
                    <a href="interface.php">Strona główna</a>
                    <a href="addCar.php">Dodaj auto</a>
                    <a href="addCours.php">Dodaj kurs</a>
                    <a href="logout.php">Wyloguj się</a>
                </div>
                
            </div>
            
            <div id="main_wall">
                <div id="left_log">
                    Ustawienia Twojego konta
                    <br/>
                    <br/>
                    <?php//zmiana e-maila ?>
                    <form method="post">
                    nowy e-mail:
                    <br/>
                    <input type="text" name="email" id="textfield"/>
                    <br/>
                     <?php 
                        if(isset($_SESSION['error_email'])){
                            echo '<div class="error">'.$_SESSION['error_email'].'</div>'; 
                            unset($_SESSION['error_email']);
                        }
                        
                        if(isset($_SESSION['email_change'])){
                            echo '<div class="change">'.$_SESSION['email_change'].'</div>';
                            unset($_SESSION['email_change']);
                        }
                    ?>
                    <br/>
                    <br/> 
                    <input type="submit" value="zmien e-mail" id="button"/>
                    <br/>
                    <br/>
                   
                    </form>
                   
                    
                </div>
                <div id="right_info2">
                    <br/>
                    <br/>
                    <a href="setName.php">Zmień imię</a>
                    <br/>
                    <br/>
                    <a href="setPass.php">Zmień hasło</a>
					<br/>
                    <br/>
					<a href="deleteAccount.php">Usuń konto</a>
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
