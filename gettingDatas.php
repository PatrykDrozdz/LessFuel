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
                    echo '<option value="'.$i.'">'.$fullCourseName[$i].'</option>';
                }
                $resultCourse->free();
            }
            echo '</select>';
            echo'</form>';
        }
        
        
    }catch(Exception $e){
        echo '<span class="error">Błąd serwera!</span>';
         echo'</br>'; //deweloper infor
         echo 'developer info: '.$e;
    }
    
 }
 
if(isset($_POST['postvalue2'])){
    
    $value = $_POST['postvalue2'];
    echo '<br/> <br/>'.$value;
}
 
?>
