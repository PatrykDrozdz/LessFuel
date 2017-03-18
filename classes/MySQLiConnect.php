<?php

class MySQLiConnect extends mysqli {
    
    private $valid = false;
    private $result;
    private $indexString = 'Location: index.php';

    public function __construct($host, $username, $pass, $db) {
        
        parent::__construct($host, $username, $pass, $db);

        if(mysqli_connect_error()){
            
            $this->valid = false;
            
        } else {
            
            $this->valid = true;
            
        }
    }

    
    public function getIndexString(){
        return $this->indexString;
    }
    
    //zabezpieczenie przed 
    public function injectionSafer($value){
        
        $result = htmlentities($value, ENT_QUOTES, "UTF-8");
        return $result;
        
    }
    
    
    public function queryExecuter($connection, $query, $log){

        if($this->result=mysqli_query($connection,
                    sprintf($query,
                    mysqli_real_escape_string($connection, $log)))){
            return true;
        } else {
            return false;
        }

    }
    
    public function getResult(){
        return $this->result;
    }
    
    public function rowCount($value){
        $result = mysqli_num_rows($value);
        return $result;
    }
    
}

?>