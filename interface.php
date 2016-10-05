<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

	
	require_once 'connect.php';
	try{
        $valid=true;
         $conection = new mysqli($host, $db_user, $db_password, $db_name);
         
         //$id = $_SESSION['id'];//id uzytkownika
         
          if($conection->connect_errno!=0){
             echo"Error: ".$conection->connect_errno;
         }else {
            
            $query = "SELECT * FROM cars WHERE userId = '$id'";
            
            if($valid==true){
                
                $result = $conection->query($query);
                
                //$row = $result->fetch_assoc();
                
                $howMany = $result->num_rows;
					
                 for($i=1; $i<=$howMany; $i++){
                      $res = $conection->query("SELECT * FROM cars WHERE id = '$i' AND userId = '$id'");
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
        
    </head>
    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel</div>
                
                <div class="logingout">
                    <a href="addCar.php">Dodaj auto</a>
                    <a href="addCours.php">Dodaj kurs</a>
                    <a href="setEmail.php">Ustawienia</a>
                    <a href="logout.php">Wyloguj się</a>
                </div>
                
            </div>
            
            <div id="main_wall">
                
                <div id="left_log">
                
               <?php 
                    echo"<a>Witaj  ".$_SESSION['name']."!";
               ?>
                
                <br/>
                <br/>
                <?php//lista rozwijana ?>
                <form method="post">
                <select name="name" id="textfield">
                    
                     <?php 
                        for($i=1; $i<=$howMany; $i++){
                            echo '<option name="carId">'.$tabCar[$i].'</option>';
                    }
                    
                    ?>  
                    
                </select>
                </form>
                </div>
                
                <div id="right_info">
                    
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
