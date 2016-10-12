<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
    if(isset($_POST['name'])){
        //walidacja
        $valid=true;
        
       $name = $_POST['name'];
      
       $oldName = $_SESSION['name'];
       
       if($name==$oldName){
           $valid = false;
           $_SESSION['error_name'] = "Podano stare imię!";
       }
     
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
        
        
            
            require_once 'connect.php';
                
            mysqli_report(MYSQLI_REPORT_STRICT);
            
            try{
                $conection = new mysqli($host, $db_user, $db_password, $db_name);
                
                if($conection->errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {

                    $id = $_SESSION['id_users'];
                    if($valid==true){
                        
                        if($conection->query("UPDATE  users SET name = '$name' WHERE id_users='$id'")){
                            $_SESSION['name_change']="Imię zostało zmienione";
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
                <div class="title">LessFuel - Ustawienia Twojego konta</div>
                
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="interface.php">Strona główna</a></li>
                        <li><a href="addCar.php">Dodaj auto</a></li>
                        <li><a href="addCours.php">Dodaj kurs</a></li>
                        <li><a href="setEmail.php">Zmiana e-mail'a</a></li>
                        <li><a href="setPass.php">Zmiana hasła</a></li>
                        <li><a href="deleteAccount.php">usuń konto</a></li>
                        <li><a href="setCourse.php">Edytuj kurs</a></li>
                        <li><a href="setCar.php">Edytuj pojazd</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                        </ul>
                </div>
                
            </div>
            
            <div id="main_wall">
                <div id="left_log">
                  
                    <br/>
                    <br/>
                    <?php//zmiana e-maila ?>
                    <form method="post">
                    nowe imię:
                    <br/>
                    <input type="text" name="name" id="textfield"/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['error_name'])){
                            echo '<div class="error">'.$_SESSION['error_name'].'</div>'; 
                            unset($_SESSION['error_name']);
                        }
                        
                        if(isset($_SESSION['name_change'])){
                            echo '<div class="change">'.$_SESSION['name_change'].'</div>';
                            unset($_SESSION['name_change']);
                        }
                    ?>
                    <br/>
                    <br/>
                 
                    <input type="submit" value="zmień imię" id="button"/>
                    <br/>
                    <br/>
                   
                    </form>
                   
                    
                </div>
                <div id="right_info2">
                    <br/>
                    <br/>
                    <ul class="colOpt">
                        <li><a href="setEmail.php">Zmień e-mail</a></li>
                        <br/>
                        <li><a href="setPass.php">Zmień hasło</a></li>
                        <br/>
                        <li><a href="deleteAccount.php">Usuń konto</a></li>
                    </ul>
                   
                </div>
                
            </div>
            
            <div id="footer">
                <br/>
                <br/>
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