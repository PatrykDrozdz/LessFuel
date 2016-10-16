<?php

 require_once 'connect.php';
 $conection = new mysqli($host, $db_user, $db_password, $db_name);

//get roads
 if(isset($_POST['postvalue'])){
     
    $value = $_POST['postvalue'];
    
    try{

        if($conection->connect_errno!=0){
             echo"Error: ".$conection->connect_errno;
        } else {

            $queryCountCourse= "SELECT * FROM course";
            
            
            $result = $conection->query($queryCountCourse);
            
            
            $howManyCourses = $result->num_rows;
            
            //echo $value.'<br/>'.$howManyCourses;
            
            echo'<form method="post">';
            echo'<select id="textfield" name="course" onchange="showCarRoad(this.value)">';
            echo '<option value="">---</option>';
            
            for($i=1; $i<=$howManyCourses; $i++){
               
                $resultCourse = $conection->query("SELECT * FROM course WHERE "
                        . "id_course = '$i' AND cars_id_cars = '$value'");
                
                $rowCourse = $resultCourse->fetch_assoc();

                $tabCoursS[$i] = $rowCourse['start_place'];
                $tabCourseE[$i] = $rowCourse['end_place'];
                $dayCourse[$i] = $rowCourse['day'];
                
                $fullCourseName[$i] = $tabCoursS[$i].' - '.$tabCourseE[$i].' - '.$dayCourse[$i];
                if($tabCoursS[$i]!=NULL){
                    $carRoad = $value.','.$i;
                    
                    echo '<option value="'.$carRoad .'">'.$fullCourseName[$i].'</option>';
                }
                $resultCourse->free();
            }
            echo '</select>';
            echo'</form>';
        }
        
        $conection->close();
    }catch(Exception $e){
        echo '<span class="error">Błąd serwera!</span>';
         echo'</br>'; //deweloper infor
         echo 'developer info: '.$e;
    }
    
 }
 
if(isset($_POST['postvalue2'])){
    
    echo '<br/> <br/>';
    
    $value = $_POST['postvalue2'];
   
    $ides= explode(",", $value);
    
    $idCar = $ides[0];
    $idCourse = $ides[1];
    
    //echo $idCar.'<br/>'.$idCourse;
    
     try{

        if($conection->connect_errno!=0){
             echo"Error: ".$conection->connect_errno;
        } else {
            
            $resultCarShow = $conection->query("SELECT * FROM cars WHERE "
                    . "id_cars = '$idCar'");
            
            $rowCars = $resultCarShow->fetch_assoc();
            
            echo "<table>
                    <tr>
                    <th>Marka</th>
                    <th>Pojemnosc</th>
                    <th>Rok produkcji</th>
                    <th>dodatkowe informacje</th>
                    </tr>";
            echo'<tr>';
            echo '<td>'.$rowCars['mark'].'</td>';
            echo '<td>'.$rowCars['capacity'].'</td>';
            echo '<td>'.$rowCars['production_year'].'</td>';
            echo '<td>'.$rowCars['additional_info'].'</td>';
            echo '</tr>'
            . '</table>';
            echo '<br/> <br/>';
            
            $resultCarShow->free();
            
            $resultCourseShow = $conection->query("SELECT * FROM course WHERE "
                    . "id_course = '$idCourse'");
            
            $rowCourse = $resultCourseShow->fetch_assoc();
            
            
            echo "<table>
                    <tr>
                    <th>Początek</th>
                    <th>Koniec</th>
                    <th>data</th>
                    <th>odległość</th>
                    <th>zużyte paliwo</th>
                    <th>dodatkowe informacje</th>
                    </tr>";
            echo'<tr>';
            echo '<td>'.$rowCourse['start_place'].'</td>';
            echo '<td>'.$rowCourse['end_place'].'</td>';
            echo '<td>'.$rowCourse['day'].'</td>';
            echo '<td>'.$rowCourse['distance'].'</td>';
            echo '<td>'.$rowCourse['fuel_used'].'</td>';
            echo '<td>'.$rowCourse['additional_road_info'].'</td>';
            echo '</tr>'
            . '</table>';
            echo '<br/> <br/> <br/>';
            
            $resultCourseShow->free();
            
            
            $resultFinalInfo = $conection->query("SELECT * FROM final_info "
                    . "WHERE cars_id_cars = '$idCar'");
            
            $rowFinalInfo = $resultFinalInfo->fetch_assoc();
            
            echo "<table>
                    <tr>
                    <th>Suma przejechanych kilomentrów</th>
                    <th>Suma zurzytego paliwa</th>
                    </tr>";
            echo'<tr>';
            echo '<td>'.$rowFinalInfo['total_distance_driven'].'</td>';
            echo '<td>'.$rowFinalInfo['total_fuel_used'].'</td>';
            echo '</tr>'
            . '</table>';
            
            $resultFinalInfo->free();
        }
        
        $conection->close();
        
     } catch (Exception $e){
        echo '<span class="error">Błąd serwera!</span>';
        echo'</br>'; //deweloper infor
        echo 'developer info: '.$e;
     }
}
 
?>
