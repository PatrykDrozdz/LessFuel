<?php 

    
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
        

    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel - Ustawienia Twojego konta</div>
                
                <div class="logingout">
                    
                      <ul class="menu">
                        <li><a href="interface.php?page=mainLoged">Strona główna</a></li>
                        <li><a href="interface.php?page=addCar">Dodaj auto</a></li>
                        <li><a href="interface.php?page=addCours">Dodaj kurs</a></li>
                        <li><a href="interface.php?page=setEmail">Zmiana e-mail'a</a></li>
                        <li><a href="interface.php?page=setName">Zmiana imienia</a></li>
                        <li><a href="interface.php?page=setPass">Zmiana hasła</a></li>
                        <li><a href="interface.php?page=setCourse">Edytuj kurs</a></li>
                        <li><a href="interface.php?page=setCar">Edytuj pojazd</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
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
                    <ul class="colOpt">
                        <li><a href="interface.php?page=setName">Zmień imię</a></li>
                        <br/>
                        <li><a href="interface.php?page=setEmail">Zmień e-mail</a></li>
                        <br/>
                        <li><a href="interface.php?page=setPass">Zmień hasło</a></li>
                        <br/>
                       
                    </ul>                        
                </div>
                
            </div>
