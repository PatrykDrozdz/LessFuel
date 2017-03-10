<?php //zabezpieczenie przed wejście bez logowania

    
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
                
                if($conection->errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                        
                    $id = $_SESSION['id_users'];
                    if($valid==true){
                        
                        if($conection->query("UPDATE  users SET email = '$email' WHERE id_users='$id'")){
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

<title>Zmień swój e-mail</title>
    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel - Ustawienia Twojego konta</div>
                
                <div class="logingout">
                    
                    
                      <ul class="menu">
                        <li><a href="interface.php?page=mainLoged">Strona główna</a></li>
                        <li><a href="interface.php?page=addCar">Dodaj auto</a></li>
                        <li><a href="interface.php?page=addCours">Dodaj kurs</a></li>
                        <li><a href="interface.php?page=setName">Zmiana imienia</a></li>
                        <li><a href="interface.php?page=setPass">Zmiana hasła</a></li>
                        <li><a href="interface.php?page=deleteAccount">usuń konto</a></li>
                        <li><a href="interface.php?page=setCourse">Edytuj kurs</a></li>
                        <li><a href="interface.php?page=setCar">Edytuj pojazd</a></li>
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
                    <input type="submit" value="zmień e-mail" id="button"/>
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
                        <li><a href="interface.php?page=setPass">Zmień hasło</a></li>
                        <br/>
                        <li><a href="interface.php?page=deleteAccount">Usuń konto</a></li>
                    </ul>                    
                </div>
                
            </div>

