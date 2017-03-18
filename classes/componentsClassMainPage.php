<?php

include 'classes/commonComponentsClass.php';

class componentsClassMainPage extends commonComponentsClass {

    public function getMainPage(){
        include 'components/mainPage.php';
    }
    
    public function getMakePage(){
        include 'components/makeBody.php';
    }
    
    public function getWelcome(){
        include 'components/welcome.php';
    }
}
?>