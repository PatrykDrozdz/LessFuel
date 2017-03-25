<?php 

	require_once 'connect.php';
        include 'classes/MySQLiConnect.php';
        
        $id_users = $_SESSION['id_users'];
        
	try{

            $connection = new MySQLiConnect($host, $db_user, $db_password, $db_name);
  
            $userId = mysqli_real_escape_string($connection, $id_users);
            //WHERE users_id = '$userId'
            $query = "SELECT mark FROM cars ORDER BY mark";
            
            $result = $connection->queryExecuter($connection, $query);
            
            $howManyCars = $connection->rowCount($result);
            
            $rowsMark = mysqli_fetch_all($result, 0);
            
            mysqli_free_result($result);
            
            
            
            
            
            
		/*		
            for($i=1; $i<=$howMany; $i++){
                
                $res = mysqli_query($connection ,"SELECT * FROM cars WHERE "
                        . "id_cars = '$i' AND users_id = '$id_users'");
                
                $row2 = mysqli_fetch_assoc($res);
                
                //samochód
                $tabCar[$i] = $row2['mark'];
                   
            }
            */
            mysqli_close($connection);
         
        } catch(Exceptione $e) {
            
            $_SESSION['error'] = '<span class="error">Błąd serwera!</span>';
            
        }
        
?>

    <title>Strona główna</title>
    <body>
        <div class="container">
            
            <?php 
                
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
            
            ?>
            
            <div id="header">
                <div class="title">LessFuel
                </div>
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="interface.php?page=addCar">Dodaj auto</a></li>
                        <li><a href="interface.php?page=addCours">Dodaj kurs</a></li>
                        <li><a href="interface.php?page=setEmail">Zmiana e-mail'a</a></li>
                        <li><a href="interface.php?page=setName">Zmiana imienia</a></li>
                        <li><a href="interface.php?page=setPass">Zmiana hasła</a></li>
                        <li><a href="interface.php?page=deleteAccount">usuń konto</a></li>
                        <li><a href="interface.php?page=setCourse">Edytuj kurs</a></li>
                        <li><a href="interface.php?page=setCar">Edytuj pojazd</a></li>
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
                        echo '<option>'.$howManyCars.'</option>';
                        for($i=0; $i<$howMany; $i++){
                            echo '<option value="'.$i.'">'.$rowsMark[$i].'</option>';
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