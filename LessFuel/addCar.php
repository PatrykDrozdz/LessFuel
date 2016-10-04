<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }
    
    ///dodawanie do bazy danych
    
    if(isset($_POST['mark']) && isset($_POST['capacity']) && isset($_POST['yearProd'])){
            
            
            $valid=true;
                
            $mark = $_POST['mark']; 
            $capacity = $_POST['capacity'];//liczba double
            $yearProd = $_POST['yearProd'];//liczba int
            $infoCar = $_POST['infoCar']; 
           
            if(!is_int($yearProd)){
                $valid=FALSE;
                $_SESSION['error_yearProd'] = "Podaj właściwą";
            }    
            
            if(!is_float($capacity)){
                $valid=FALSE;
                $_SESSION['error_capacity'] = "Podaj liczbę całkowitą";
            }
            
            if(ctype_alnum($mark)==FALSE){
                   $valid=FALSE;
            $_SESSION['error_mark'] = "Nazwa auta może składać się tylko "
                    . "z liter i cyfr (bez polskich zanków)";
            }
            
                 require_once 'connect.php';
                 
              try{
                $conection = new mysqli($host, $db_user, $db_password, $db_name);
               
                $userId = $_SESSION['id'];//id użytkownika
                
                $chechCar = $conection->query("SELECT id FROM cars WHERE "
                        . "mark='$mark' AND userId = '$userId'");
                
                
               $howManyCars= $chechCar->num_rows;
               
               if(!$chechCar ) {
                    throw new Exception ($conection->errno);
                }

                if($howManyCars>0){
                    $valid=false;
                    $_SESSION['error_mark'] = "Samochód o podanej nazwie jest już w bazie"
                            . " tego użykownika!";
                }
                
                if($conection->errno!=0){
                    throw new Exception(mysqli_connect_errno());
                } else {
                     
                    $query = "INSERT INTO cars(id, mark, capacity, yearProd, addInfo, userId)"
                            . "VALUES (NULL, '$mark', '$capacity', '$yearProd', '$infoCar', '$userId')";

                    //ustawienia sesji
                    $result = $conection->query("SELECT * FROM cars WHERE userId = '$id'");
                    
                     $row = $result->fetch_assoc();
                     
                     $res = $conection->query("SELECT * FROM users WHERE id = '$id'");
                     
               /*      $row2 = $res->fetch_assoc();
                     
                    $_SESSION['idCar'] = $row['id'];//wyłuskanie id auta
                    
                    $_SESSION['mark'] = $row['mark'];
                    $_SESSION['capacity'] = $row['capacity'];
                    $_SESSION['yearProd'] = $row['yearProd'];
                    
                 */
                if($valid==true){
                    ////////////////
                        if($conection->query($query)){
							
                            $_SESSION['carAdd']="Dodano Auto do bazy"; 
			
                
                        } else {
                            throw new Exception($conection->errno);
                        }

                $conection->close();
                }
            }
                
                
            }catch(Exceptione $e){
                 echo '<span class="error">Błąd serwera!</span>';
                 echo'</br>'; //deweloper infor
                 echo 'developer info: '.$e;
            }
            
            
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
        <script type="text/javascript" src="js/slider.js"></script>
        
    </head>
    <body onload="change_slide()">
        <div class="container">
            
            <div id="header">
                <h1>LessFuel</h1>
                
                <div class="logingout">
                   <a href="interface.php">Strona główna</a>
                   <a href="addCours.php">Dodaj kurs</a>
                    <a href="setEmail.php">Ustawienia</a>
                    <a href="logout.php">Wyloguj się</a>
                </div>
                
            </div>
            
            <div id="main_wall">
                
                <form method="post">
                    <div id="left_log">
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    Marka samochodu:
                    <br/>
                    <input type="text" id="textfield" name="mark"/>
                    
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
                    <input type="text" id="textfield" name="capacity"/>
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
                    <input type="text" id="textfield" name="yearProd"/>
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
                    <input type="text" id="textfield" name="infoCar"/>
                    <br/>
                    <br/>
                     <?php 
                         if(isset($_SESSION['carAdd'])){
                            echo '<div class="change">'.$_SESSION['carAdd'].'</div>'; 
                            unset($_SESSION['carAdd']);
                        }
                        
                         if(isset( $_SESSION['error_car'] )){
                            echo '<div class="error">'. $_SESSION['error_car'].'</div>'; 
                            unset( $_SESSION['error_car'] );
                        }
                         
                        
                      ?>
                    <br/>
                    <br/>
                    <input type="submit" value="Dodaj" id="button"/>
                    </div>
                    </form>
                <div id="left_add">
                    <div id="photos"></div>
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
