<?php 
    
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
                        <li><a href="interface.php?page=setEmail">Zmień e-mail</a></li>
                        <br/>
                        <li><a href="interface.php?page=setPass">Zmień hasło</a></li>
                        <br/>
                        <li><a href="interface.php?page=deleteAccount">Usuń konto</a></li>
                    </ul>
                   
                </div>
                
            </div>
