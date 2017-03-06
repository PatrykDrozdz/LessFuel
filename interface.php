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
	
    
    $page = isset($_GET['page']) ? $_GET['page'] : 'mainLoged';
    
    switch ($page){
        
    case 'mainLoged':
        include ('components/head.php');
        include ('components/mainLoged.php');
        include ('components/footer.php');
        break;
    
    case 'addCar':
        include ('components/head.php');
        include ('components/addCar.php');
        include ('components/footer.php');
        break;
    case 'addCours':
        include ('components/head.php');
        include ('components/addCours.php');
        include ('components/footer.php');
        break;
    
    case 'setEmail':
        include ('components/head.php');
        include ('components/setEmail.php');
        include ('components/footer.php');
        break;
    
    case 'deleteAccount':
        include ('components/head.php');
        include ('components/deleteAccount.php');
        include ('components/footer.php');
        break;
    
    case 'setCar':
        include ('components/head.php');
        include ('components/setCar.php');
        include ('components/footer.php');
        break;
    
    case 'setCourse':
        include ('components/head.php');
        include ('components/setCourse.php');
        include ('components/footer.php');
        break;
    
    case 'setName':
        include ('components/head.php');
        include ('components/setName.php');
        include ('components/footer.php');
        break;
    
    case 'setPass':
        include ('components/head.php');
        include ('components/setPass.php');
        include ('components/footer.php');
        break;
    
    
    }
	
	
?>

