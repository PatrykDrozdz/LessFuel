<?php 

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
            
           
                
                $result = $conection->query($query);
                
                //$row = $result->fetch_assoc();
                
                $howMany = $result->num_rows;
				
                 for($i=1; $i<=$howMany; $i++){
                      $res = $conection->query("SELECT * FROM cars WHERE id_cars = '$i' "
                              . "AND users_id = '$id_users'");
                      $row2 = $res->fetch_assoc();
                      //samochód
                      $tabCar[$i] = $row2['mark'];
                      $res->free();
                 }


            
         
         
            //edycja samochodu
            if(isset($_POST['carName'])){
             
                $mark = $_POST['carName'];
             
                $resChange = $conection->query("SELECT * FROM cars WHERE "
                     . "mark = '$mark' AND users_id = '$id_users'");
             
                $rowChange = $resChange->fetch_assoc();
                
                $idCar = $rowChange['id_cars'];
                $oldMark = $rowChange['mark'];
                $oldCapacity = $rowChange['capacity'];
                $oldYearProd = $rowChange['production_year'];
                $oldAddInfo = $rowChange['additional_info'];
             
                //echo $idCar.'<br/>'.$oldMark.'<br/>'.$oldCapacity.'<br/>'.$oldYearProd.'<br/>'.$oldAddInfo.'<br/> <br/>';
             
                $resChange->free();

             
                $newMark = $_POST['markEdit'];
             
                if($newMark==NULL){
                    $newMark=$oldMark;
                }
             
                $newCapacity = $_POST['capacityEdit'];
             
                if($newCapacity==NULL){
                    $newCapacity=$oldCapacity;
                }
             
                $newYearProd = $_POST['yearProdEdit'];
             
                if($newYearProd==NULL){
                    $newYearProd=$oldYearProd;
                }
             
                $newInfoCar = $_POST['infoCarEdit'];
             
                if($newInfoCar==NULL){
                    $newInfoCar = $oldAddInfo;
                }
             
                //echo $newMark.'<br/>'.$newCapacity.'<br/>'.$newYearProd.'<br/>'.$newInfoCar;
             
                          
                if($newCapacity==NULL && $newInfoCar==NULL && $newMark==NULL && $newYearProd==NULL){
                    $valid=false;
                    $_SESSION['error_no_change'] = "Nie wprowadzono żadnych zmian!";
                }
             
                if($valid==true){
                    
                    if($conection->query("UPDATE cars SET mark = '$newMark', capacity = '$newCapacity', "
                            . "production_year = '$newYearProd', additional_info = '$newInfoCar' WHERE "
                            . "id_cars = '$idCar'")){
                        $_SESSION['carChange']="Dane auta zostały zmienione";
                    } else {
                       throw new Exception($conection->errno); 
                    }
                 
                } else{
                    throw new Exception($conection->errno);
                }
            }
         
         
            $conection->close();
         }
    }  catch(Exceptione $e){
                 echo '<span class="error">Błąd serwera!</span>';
                 echo'</br>'; //deweloper infor
                 echo 'developer info: '.$e;
    }
	
	
	
?>

    <body onload="change_slide()">
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel - edytuj dane auta</div>
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="interface.php?page=mainLoged">Strona główna</a></li>
                        <li><a href="interface.php?page=addCar">Dodaj auto</a></li>
                        <li><a href="interface.php?page=addCours">Dodaj kurs</a></li>
                        <li><a href="interface.php?page=setEmail">Zmiana e-mail'a</a></li>
                        <li><a href="interface.php?page=setName">Zmiana imienia</a></li>
                        <li><a href="interface.php?page=setPass">Zmiana hasła</a></li>
                        <li><a href="interface.php?page=deleteAccount">usuń konto</a></li>
                        <li><a href="interface.php?page=setCourse">Edytuj kurs</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
                
            </div>
            
            <div id="main_wall">
                <form method="post">
                    <div id="left_log">
    
                    <br/>
                    <br/>

                    <select name="carName" id="textfield">
                    
                        <?php 
                            for($i=1; $i<=$howMany; $i++){
                                if($tabCar[$i]!=NULL){
                                     echo '<option>'.$tabCar[$i].'</option>';
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
                    Marka samochodu:
                    <br/>
                    <input type="text" id="textfield" name="markEdit"/>
                    
                      <?php 
                        if(isset($_SESSION['error_mark'])){
                            echo '<div class="error">'.$_SESSION['error_mark'].'</div>'; 
                            unset($_SESSION['error_mark']);
                        }
                    ?>
                    
                    <br/>
                     <br/>
                    <br/>
                    Pojemność:
                    <br/>
                    <input type="text" id="textfield" name="capacityEdit"/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['error_capacity'])){
                            echo '<div class="error">'.$_SESSION['error_capacity'].'</div>'; 
                            unset($_SESSION['error_capacity']);
                        }
                    
                    ?>
                    <br/>
                     <br/>
                    <br/>
                    Rok produkcji:
                    <br/>
                    <input type="text" id="textfield" name="yearProdEdit"/>
                    <br/>
                    <?php 
                         if(isset($_SESSION['error_yearProd'])){
                            echo '<div class="error">'.$_SESSION['error_yearProd'].'</div>'; 
                            unset($_SESSION['error_yearProd']);
                        }
                   
                    ?>
                    <br/>
                     <br/>
                    <br/>
                    Dodatkowe informacje:
                    <br/>
                    <input type="text" id="textfield" name="infoCarEdit"/>
                    <br/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['carChange'])){
                            echo '<div class="change">'.$_SESSION['carChange'].'</div>'; 
                            unset($_SESSION['carChange']);
                        }
                        
                        
                        if(isset($_SESSION['error_no_change'])){
                            echo '<div class="error">'.$_SESSION['error_no_change'].'</div>'; 
                            unset($_SESSION['error_no_change']);
                        }

                      ?>
                    <br/>
                    <br/>
                     <input type="submit" value="Edytuj" id="button"/>
                    </div>
               
                </form>
            </div>
