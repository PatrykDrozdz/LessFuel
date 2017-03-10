<?php
    
    if(isset($_POST['pass']) && isset($_POST['oldPass'])){
        //walidacja
        $valid=true;
        
       $pass = $_POST['pass'];
       $oldPass = $_POST['oldPass'];
       $postPass = $_POST['pass']; 
       $id = $_SESSION['id_users'];
       
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

                    $id = $_SESSION['id_users'];
                    if($valid==true){
                        
                        if($conection->query("UPDATE  users SET password = '$pass_hash' WHERE id_users='$id'")){
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

<title>Zmień swoje hasło</title>
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
                    <input type="submit" value="zmień hasło" id="button"/>
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
                        <li><a href="interface.php?page=deleteAccount">Usuń konto</a></li>
                    </ul>                           
                </div>
                
            </div>
