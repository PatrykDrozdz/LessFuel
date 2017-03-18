<?php //zabezpieczenie przed wejście bez logowania
    session_start();
    
    if(!isset($_SESSION['loged'])){
        header('Location: index.php');
        exit();
    }

    
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
        exit();
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 'mainLoged';
    
    include 'classes/componetnsClassLoged.php';
    
    $getComponentsLoged = new componetnsClassLoged();
    
    $getComponentsLoged->getHead();
    
    switch ($page){
        
    case 'mainLoged':
        $getComponentsLoged->getMainPageLoged();
        break;
    
    case 'addCar':
        $getComponentsLoged->getAddCar();
        break;
    case 'addCours':
        $getComponentsLoged->getAddCourse();
        break;
    
    case 'setEmail':
        $getComponentsLoged->getSetEmail();
        break;
    
    case 'deleteAccount':
        $getComponentsLoged->getDeleteAccount();
        break;
    
    case 'setCar':
        $getComponentsLoged->getSetCar();
        break;
    
    case 'setCourse':
        $getComponentsLoged->getSetCourse();
        break;
    
    case 'setName':
        $getComponentsLoged->getSetName();
        break;
    
    case 'setPass':
        $getComponentsLoged->getSetPass();
        break;
    
    
    }
	
    $getComponentsLoged->getFooter();
    
?>

