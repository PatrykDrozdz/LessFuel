<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
    if(isset($_POST['pass']) && isset($_POST['oldPass'])){
        //walidacja
        $valid=true;
        
       $pass = $_POST['pass'];
       $oldPass = $_POST['oldPass'];
       $postPass = $_POST['pass']; 
       $id = $_SESSION['id'];
       
       if((strlen($pass)<5) || (strlen($pass)>15)){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Hasło musi mieć od 5 do 15 znaków";
        }
        
        //hashowanie hasła
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        
        if($pass_hash==$oldPass){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Podane hasła są identyczne";
        }
        
        
            
            require_once 'connect.php';
                
            mysqli_report(MYSQLI_REPORT_STRICT);
            
            try{
                $conection = new mysqli($host, $db_user, $db_password, $db_name);
                
                if($conection->errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {

                    $id = $_SESSION['id'];
                    if($valid==true){
                        
                        if($conection->query("UPDATE  users SET password = '$pass_hash' WHERE id='$id'")){
                            $_SESSION['pass_change']="Hasło zostało zmienione";
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
                    nowe hasło:
                    <br/>
                    <input type="password" name="pass" id="textfield"/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['error_pass'])){
                            echo '<div class="error">'.$_SESSION['error_pass'].'</div>'; 
                            unset($_SESSION['error_pass']);
                        }
                        
                        if(isset($_SESSION['pass_change'])){
                            echo '<div class="change">'.$_SESSION['pass_change'].'</div>';
                            unset($_SESSION['pass_change']);
                        }
                    ?>
                    <br/>
                    <br/>
                    stare hasło:
                    <br/>
                    <input type="password" name="oldPass" id="textfield"/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['error_pass'])){
                            echo '<div class="error">'.$_SESSION['error_pass'].'</div>'; 
                            unset($_SESSION['error_pass']);
                        }
                    ?>
                    <br/>
                    <br/>
                    <input type="submit" value="zmien hasło" id="button"/>
                    <br/>
                    <br/>
                   
                    </form>
                   
                    
                </div>
                <div id="right_info2">
                    <br/>
                    <br/>
                    <a href="setEmail.php">Zmień e-mail</a>
                    <br/>
                    <br/>
                    <a href="setName.php">Zmień imię</a>
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