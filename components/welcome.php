<?php //zabezpieczenie przed wejście bez logowania
   // session_start();
    
    if(!isset($_SESSION['registered'])){
        header('Location: index.php');
        exit();
    }else{
        unset($_SESSION['registered']);
    }

?>

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
            
