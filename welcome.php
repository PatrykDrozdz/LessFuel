<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['registered'])){
        header('Location: index.php');
        exit();
    }else{
        unset($_SESSION['registered']);
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
                <div class="title">LessFuel</div>
                    
                    <a href="index.php">Strona Główna - zapraszamy do zalogowania się</a>
                
                
            </div>
            
            <div id="main_wall">
                
                
               <?php 
                    echo"<a>Witaj. Dziękujemy za rejestrację. Przejdź do strony głównej i zaloguj się</a>";
               ?>
                
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
