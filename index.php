<?php 
    
session_start();

if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
    header('Location: interface.php');
    exit();//opuszczanie skryptu
}

$page = isset($_GET['page']) ? $_GET['page'] : 'main';

switch ($page){
    
case 'main':
    include ('components/head.php');
    include ('components/mainPage.php');
    include ('components/footer.php');
    break;

case 'make':

    include ('components/head.php');
    include ('components/makeBody.php');
    include ('components/footer.php');
    include 'make.php';
    break;

case 'welcome':
    include ('components/head.php');
    include ('components/welcome.php');
    include ('components/footer.php');
    break;

}

          
?>
