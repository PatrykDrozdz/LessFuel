<?php 

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
                    $tabDate[$coursCount] = $row2['day'];
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
                $dateOld = $places[2];
                
                //echo $oldStartPlace.' '.strlen($oldStartPlace).'<br/>'.$oldEndPlace.' '.strlen($oldEndPlace).'<br/>';
            
                $resOldCourse = $conection->query("SELECT * FROM course WHERE "
                        . "start_place = '$oldStartPlace' AND end_place = '$oldEndPlace' AND day = '$dateOld'");
                
                $rowCourse = $resOldCourse->fetch_assoc();
                
                $idCourse = $rowCourse['id_course'];
                $oldDistance = $rowCourse['distance'];
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


<title>Edytuj swoje kursy</title>

    <body onload="change_slide()">
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel - edytuj dane trasy</div>
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="interface.php?page=mainLoged">Strona główna</a></li>
                        <li><a href="interface.php?page=addCar">Dodaj auto</a></li>
                        <li><a href="interface.php?page=addCours">Dodaj kurs</a></li>
                        <li><a href="interface.php?page=setEmail">Zmiana e-mail'a</a></li>
                        <li><a href="interface.php?page=setName">Zmiana imienia</a></li>
                        <li><a href="interface.php?page=setPass">Zmiana hasła</a></li>
                        <li><a href="interface.php?page=deleteAccount">usuń konto</a></li>
                        <li><a href="interface.php?page=setCar">Edytuj pojazd</a></li>
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
                                .$tabCoursS[$i].' - '.$tabCourseE[$i].' - '.$tabDate[$i].'</option>';
                            }
                    }
                    
                    ?>  
                    
                </select>
                
                <br/>
                    <br/>
                    <br/>
                    <div id="photos">
                    
                     </div>
                
                
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
                    <input type="number" min="0" step="0.1"  id="textfield" name="distanceEdit"/>
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
                    <input type="number" min="0" step="0.1"  id="textfield" name="fuelEdit"/>
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
