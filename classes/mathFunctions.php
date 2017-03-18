<?php

class mathFunctions {
    
    public function inequality($a, $b){
        
        if($a>$b){
            return true;
        } else if($b>$a) {
            return false;
        }
        
    }
    
    public function equality($a, $b){
        
        if($a==$b){
            return true;
        } else if($a!=$b) {
            return false;
        }
        
    }
    
}


?>