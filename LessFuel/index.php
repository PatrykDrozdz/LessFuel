<?php 
    
session_start();

if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
    header('Location: interface.php');
    exit();//opuszczanie skryptu
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
        
        <link href="http://localhost/lessfuel/make.php" />
        
        <script src="js/jquery.js"></script>
        <script type="text/javascript" src="js/slider.js"></script>
        
    </head>
    <body onload="change_slide()">
        <div class="container">
            
            <div id="header">
                <h1>LessFuel</h1>
            </div>
            
            <div id="left_log">
                
                <form action="loging.php" method="post" name="form_name">
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    e-mail:
                    <br/>
                    <input type="text" name="login" id="textfield" 
                           placeholder="login"/>
                    <br/>
                    hasło:
                    <br/>
                    <input type="password" name="pass" id="textfield" 
                           placeholder="hasło"/>
                    <br/>
                    <br/>
                    <input type="submit" value="Zaloguj się" id="button"/>
                    
                </form>
                
                <?php 
                if(isset($_SESSION['error'])){
                    echo $_SESSION['error'];
                }
                ?>
                
                <div id="left_add"></div> 
                
                <div id="make_account">
                    Nie masz jeszcze konta. <br/>
                    Załóż je teraz !!!
                    
                    <br/>
                    
                    <a href="http://localhost/lessfuel/make.php">Załóż konto</a>
                    
                </div>
                
            </div>
            
            <div id="right_info">
                Witamy jest to wersja próbna aplikacji służącej do
                przeliczania oraz gromadzenia informacji o przebiegu 
                oraz zużytym paliwie.<br/>
                W przyszłości prawdopodobnie powstanie aplikacjia mobilna.
                <br/>
                <br/>
                Życzymy miłego użytkowania.
                <div id="photos">
                    
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
