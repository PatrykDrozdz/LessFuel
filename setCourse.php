<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

        $id_users = $_SESSION['id_users'];
        
	require_once 'connect.php';
	try{
       
         $conection = new mysqli($host, $db_user, $db_password, $db_name);

          if($conection->connect_errno!=0){
             echo"Error: ".$conection->connect_errno;
         }else {
            
            $query = "SELECT * FROM course";
            
            $queryCars = "SELECT * FROM cars";
                
            $result2 = $conection->query($queryCars);  
            
            $result = $conection->query($query);
                
            $howMany = $result->num_rows;
            
            $howManyCars = $result2->num_rows;
            //echo $howManyCars;
            for($i=1; $i<=$howManyCars; $i++){
                
                $resCar = $conection->query("SELECT * FROM cars WHERE "
                        . "users_id = '$id_users' AND id_cars = '$i'");
                $rowCars = $resCar->fetch_assoc();
                
                //cars id
                $tabIdCars[$i] = $rowCars['id_cars'];
                if($tabIdCars[$i]!=NULL){
                    //echo $tabIdCars[$i] .'<br/>';
                }
                $resCar->free();        
            }
            $coursCount=0;
            for($i=1; $i<=$howMany; $i++){
                for($j=1; $j<=$howManyCars; $j++){
                    $res = $conection->query("SELECT * FROM course "
                        . "WHERE id_course = '$i' AND cars_id_cars = '$tabIdCars[$j]'");
                    $row2 = $res->fetch_assoc();
                    //kurs
                    $tabCoursS[$coursCount] = $row2['start_place'];
                    $tabCourseE[$coursCount] = $row2['end_place'];
                    $coursCount++;
                    
                $res->free();
                }
            }
            
            if(isset($_POST['courseName'])){
                
                $valid = true;
                
                $courseName = $_POST['courseName'];
                
                $places = explode(" - ", $courseName);
                
                $oldStartPlace = $places[0];
                $oldEndPlace = $places[1];
                
                //echo $oldStartPlace.' '.strlen($oldStartPlace).'<br/>'.$oldEndPlace.' '.strlen($oldEndPlace).'<br/>';
            
                $resOldCourse = $conection->query("SELECT * FROM course WHERE "
                        . "start_place = '$oldStartPlace' AND end_place = '$oldEndPlace'");
                
                $rowCourse = $resOldCourse->fetch_assoc();
                
                $idCourse = $rowCourse['id_course'];
                $oldDistance = $rowCourse['distance'];
                $oldDate = $rowCourse['day'];
                $oldFuelUsed = $rowCourse['fuel_used'];
                $oldRoadInfo = $rowCourse['additional_road_info'];
                $carId = $rowCourse['cars_id_cars'];
                
                //echo $idCourse.'<br/>'.$oldDistance.'<br/>'.$oldFuelUsed.'<br/>'.$oldRoadInfo.'<br/>'.$carId.'<br/> <br/>';
                
                $resOldCourse->free();
                
                $newFrom = $_POST['fromEdit'];
                
                if($newFrom==NULL){
                    $newFrom = $oldStartPlace;
                }
                
                $newTo = $_POST['toEdit'];
                
                if($newTo==NULL){
                    $newTo = $oldEndPlace;
                }
                
                $newDate = $_POST['dateEdit'];
                
                if($newDate==NULL){
                    $newDate = $oldDate;
                }
                
                $newDistance = $_POST['distanceEdit'];
                
                if($newDistance==NULL){
                    $newDistance = $oldDistance;
                }
                
                $newFuelUsed = $_POST['fuelEdit'];
                
                if($newFuelUsed==NULL){
                    $newFuelUsed = $oldFuelUsed;
                }
                
                $newInfoRoad = $_POST['infoRoadEdit'];
                
                if($newInfoRoad==NULL){
                    $newInfoRoad = $oldRoadInfo;
                }
                
                //echo $newFrom.'<br/>'.$newTo.'<br/>'.$newDistance.'<br/>'.$newFuelUsed.'<br/>'.$newInfoRoad.'<br/> <br/>';
                
                
                $resFinalInfo = $conection->query("SELECT * FROM final_info WHERE cars_id_cars = '$carId'");
                
                $rowFinalInfo = $resFinalInfo->fetch_assoc();
                
                $allFuel = $rowFinalInfo['total_fuel_used'];
                $allDistance= $rowFinalInfo['total_distance_driven'];
                
                $resFinalInfo->free();
                
                //echo $allFuel.'<br/>'.$allDistance.'<br/> <br/>';
                
                $totalFuel = ($allFuel - $oldFuelUsed) + $newFuelUsed;
                $totalDistance = ($allDistance  - $oldDistance) + $newDistance;
                
                //echo $totalFuel.'<br/>'.$totalDistance;
                
                if($valid==true){
                    
                    if($conection->query("UPDATE course SET start_place = '$newFrom', end_place = '$newTo', "
                            . "day = '$newDate', distance = '$newDistance', fuel_used = '$newFuelUsed', "
                            . "additional_road_info = '$newInfoRoad' WHERE id_course = '$idCourse'")){
                        
                        if($conection->query("UPDATE final_info SET total_fuel_used = '$totalFuel', "
                                . "total_distance_driven = '$totalDistance' WHERE cars_id_cars = '$carId'")){
                            
                            $_SESSION['coursEdit'] = "Dane trasy zostały zmienione";
                            
                        }else{
                            throw new Exception($conection->errno); 
                        }
                        
                    } else {
                       throw new Exception($conection->errno);  
                    }
                    
                    
                }
                
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
        
        
        <link href="css/jquery.datepick.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="js/jquery.plugin.js"></script>
        <script src="js/jquery.datepick.js"></script>
        <script src="js/jquery.datepick-pl.js"></script>
       
        
        
        <script>

    $(function() {
	$('#textfieldDp').datepick();
	$('#textfieldDp').datepick({onSelect: showDate});
    });

    function showDate(date) {
	alert('The date chosen is ' + date);
    }
            
        </script>
        
        
        
    </head>
    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel - edytuj dane trasy</div>
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="interface.php">Strona główna</a></li>
                        <li><a href="addCar.php">Dodaj auto</a></li>
                        <li><a href="addCours.php">Dodaj kurs</a></li>
                        <li><a href="setEmail.php">Zmiana e-mail'a</a></li>
                        <li><a href="setName.php">Zmiana imienia</a></li>
                        <li><a href="setPass.php">Zmiana hasła</a></li>
                        <li><a href="deleteAccount.php">usuń konto</a></li>
                        <li><a href="setCar.php">Edytuj pojazd</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
                
            </div>
            
            <div id="main_wall">
                
                 <form method="post">
                <div id="left_log">
               
                
                <br/>
                <br/>

                <select name="courseName" id="textfield">
                    
                     <?php 
                        for($i=0; $i<=$coursCount; $i++){
                            if($tabCoursS[$i]!=NULL){
                                echo '<option>'
                                .$tabCoursS[$i].' - '.$tabCourseE[$i].'</option>';
                            }
                    }
                    
                    ?>  
                    
                </select>
                
                </div>
                
                <div class="right_change">
                    <br/>
                    <br/>
                     Trasa 
                    <br/>
                    <br/>
                    z:
                   
                    <input type="text" class="textPlace" name="fromEdit"/>
                  
                     do:
      
                    <input type="text" class="textPlace" name="toEdit"/>
                    <br/>
                    <br/>
                    <br/>
                    data:
                    <br/>
                    <input type="text" id="textfieldDp" name="dateEdit">
                    <br/>
                    <br/>
                    <br/>
                    Odległość:
                    <br/>
                    <input type="text" id="textfield" name="distanceEdit"/>
                    <br/>
                    <?php 
                         if(isset($_SESSION['error_distance'])){
                            echo '<div class="error">'.$_SESSION['error_distance'].'</div>'; 
                            unset($_SESSION['error_distance']);
                        }
                   
                    ?>
                    <br/>
                    
                    <br/>
                    Zużyte paliwo:
                    <br/>
                    <input type="text" id="textfield" name="fuelEdit"/>
                    <br/>
                    <?php 
                         if(isset($_SESSION['error_fuel'])){
                            echo '<div class="error">'.$_SESSION['error_fuel'].'</div>'; 
                            unset($_SESSION['error_fuel']);
                        }
                   
                    ?>
                    <br/>
                   
                    <br/>
                    Dodatkowe informacje:
                    <br/>
                    <input type="text" id="textfield" name="infoRoadEdit"/>
                    <br/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['coursEdit'])){
                            echo '<div class="change">'.$_SESSION['coursEdit'].'</div>'; 
                            unset($_SESSION['coursEdit']);
                        }
						
			if(isset($_SESSION['error_road'])){
                            echo '<div class="error">'.$_SESSION['error_road'].'</div>'; 
                            unset($_SESSION['error_road']);
                        }
                   
                    ?>
                    <br/>
                    <br/>
                    <input type="submit" value="Edytuj" id="button"/>
                    </div>
                </form>
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
