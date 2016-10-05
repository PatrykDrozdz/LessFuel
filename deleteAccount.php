<?php //zabezpieczenie przed wej�cie bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
 if(isset($_POST['pass'])){
        //walidacja
        $valid=true;
        
       $pass = $_POST['pass'];

       $id = $_SESSION['id'];
       
       if((strlen($pass)<5) || (strlen($pass)>15)){
            $valid = FALSE;
            $_SESSION['error_pass'] = "Hasło musi mieć od 5 do 15 znaków";
        }
        
        //hashowanie has�a
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        

            require_once 'connect.php';
                
            mysqli_report(MYSQLI_REPORT_STRICT);
            
            try{
                $conection = new mysqli($host, $db_user, $db_password, $db_name);
                
                if($conection->errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
			$id_users = $_SESSION['id_users'];	
                        $zero = 0;
			$query = "UPDATE users SET "
                                . "flag = '$zero' WHERE id_users = '$id_users'";
                        
                    if($valid==true){
                        
                        if($conection->query($query)){
                            session_unset();
			    header('Location: index.php');
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
        
        <title>Usuń konto</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="paliwo spalanie pojazdy licznik kalkulator baza danych"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrom=1"/>
        
        <link rel="stylesheet" href="css/style.css" type="text/css"/>

        
    </head>
    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel</div>
                
                <div class="logingout">
                    <a href="interface.php">Strona główna</a>
                    <a href="addCar.php">Dodaj auto</a>
                    <a href="addCours.php">Dodaj kurs</a>
                    <a href="logout.php">Wyloguj się</a>
                </div>
                
            </div>
            
            <div id="main_wall">
                <div id="left_log">
			 <form method="post">
			<br/>
			<br/>
		       Potwierdz hasłem:
                       <br/>
			<input type="password" name="pass" id="textfield"/>
                        <br/>
                        <?php 
                         if(isset($_SESSION['error_pass'])){
                            echo '<div class="error">'.$_SESSION['error_pass'].'</div>'; 
                            unset($_SESSION['error_pass']);
                        }

                       ?>
			<br/>
			<br/>
                    <input type="submit" value="usuń konto" id="button"/>
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
					<a href="setEmail.php">Usuń konto</a>
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