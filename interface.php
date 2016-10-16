<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

        $id_users = $_SESSION['id_users'];
        
	require_once 'connect.php';
	try{
        $valid=true;
         $conection = new mysqli($host, $db_user, $db_password, $db_name);
         
         //$id = $_SESSION['id'];//id uzytkownika
         
         if($conection->connect_errno!=0){
             echo"Error: ".$conection->connect_errno;
         }else {
            
            $query = "SELECT * FROM cars";
            
            if($valid==true){
                
                $result = $conection->query($query);
                
                //$row = $result->fetch_assoc();
                
                $howMany = $result->num_rows;
				
                 for($i=1; $i<=$howMany; $i++){
                      $res = $conection->query("SELECT * FROM cars WHERE id_cars = '$i' "
                              . "AND users_id = '$id_users'");
                      $row2 = $res->fetch_assoc();
                      //samochód
                      $tabCar[$i] = $row2['mark'];
                    
                 }


            }else{
                throw new Exception($conection->errno);
            }

            
         }
         
         $conection->close();
         
    }  catch(Exceptione $e){
                 echo '<span class="error">Błąd serwera!</span>';
                 echo'</br>'; //deweloper infor
                 echo 'developer info: '.$e;
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
        
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/selectRoad.js"></script>
        <script type="text/javascript" src="js/showCarRoadInfo.js"></script>
        
    </head>
    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel
                </div>
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="addCar.php">Dodaj auto</a></li>
                        <li><a href="addCours.php">Dodaj kurs</a></li>
                        <li><a href="setEmail.php">Zmiana e-mail'a</a></li>
                        <li><a href="setName.php">Zmiana imienia</a></li>
                        <li><a href="setPass.php">Zmiana hasła</a></li>
                        <li><a href="deleteAccount.php">usuń konto</a></li>
                        <li><a href="setCourse.php">Edytuj kurs</a></li>
                        <li><a href="setCar.php">Edytuj pojazd</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
                
            </div>
            
            <div id="main_wall">
                
                <div id="left_select">
 
                <br/>
                <br/>
                Pojazdy:
                <br/>
               <br/>
                <form method="post">
                    <select  name="carName" id="textfield" 
                             onchange="selRoad(this.value)">
                        <option value="">---</option>
                     <?php 
                        for($i=1; $i<=$howMany; $i++){
                            if($tabCar[$i]!=NULL){
                                echo '<option value="'.$i.'">'.$tabCar[$i].'</option>';
                            }
                    }
                    
                    ?>  
                    
                </select>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </form>
                
               Przebyte trasy:
                <br/>
                <br/>
                 <div id="roadSelect">
                     
                 </div>
                </div>
                
                <div id="right_info_final">

                    
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
