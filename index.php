<?php 
    
session_start();

if((isset($_SESSION['loged'])) && ($_SESSION['loged']==true)){
    header('Location: interface.php');
    exit();//opuszczanie skryptu
}

include 'make.php';
include 'classes/componentsClassMainPage.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'main';

$getComponents = new componentsClassMainPage();

$getComponents->getHead();

switch ($page){
    
case 'main':
    $getComponents->getMainPage();
    break;

case 'make':
    $getComponents->getMakePage();
    break;

case 'welcome':
    $getComponents->getWelcome();
    break;

}

$getComponents->getFooter();
          
?>
