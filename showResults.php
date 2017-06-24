<?php
    
    require_once 'connect.php';
    include 'classes/MySQLiConnect.php';
        
    $id_users = $_SESSION['id_users'];

    try{

        $connection = new MySQLiConnect($host, $db_user, $db_password, $db_name);
            
        $query = "SELECT mark FROM cars WHERE users_id = '$id_users'";
            
        $connection->queryExecuter($connection, $query);
            
        $result = $connection->getResult();
            
        $howManyCars = $connection->rowCount($result);
            
        while($row = mysqli_fetch_assoc($result)){
            
            $rows[] = $row['mark'];
            
        }
            
        $connection->getFetch($result, 'mark');
            
        //mysqli_free_result($result);
         
        mysqli_close($connection);
            
    } catch(Exceptione $e) {
            
        $_SESSION['error'] = '<span class="error">Błąd serwera!</span>';
            
    }
    
?>

