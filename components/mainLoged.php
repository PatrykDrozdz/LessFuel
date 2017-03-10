    <title>Strona główna</title>
    <body>
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel
                </div>
                <div class="logingout">
                    <ul class="menu">
                        <li><a href="interface.php?page=addCar">Dodaj auto</a></li>
                        <li><a href="interface.php?page=addCours">Dodaj kurs</a></li>
                        <li><a href="interface.php?page=setEmail">Zmiana e-mail'a</a></li>
                        <li><a href="interface.php?page=setName">Zmiana imienia</a></li>
                        <li><a href="interface.php?page=setPass">Zmiana hasła</a></li>
                        <li><a href="interface.php?page=deleteAccount">usuń konto</a></li>
                        <li><a href="interface.php?page=setCourse">Edytuj kurs</a></li>
                        <li><a href="interface.php?page=setCar">Edytuj pojazd</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>
                    </ul>
                </div>
                
            </div>
            
            <div id="main_wall">
                
                <div id="left_select">
 
                <br/>
                <br/>
                Pojazdy:
                <br/>
               <br/>
                <form method="post">
                    <select  name="carName" id="textfield" 
                             onchange="selRoad(this.value)">
                        <option value="">---</option>
                     <?php 
                        for($i=1; $i<=$howMany; $i++){
                            if($tabCar[$i]!=NULL){
                                echo '<option value="'.$i.'">'.$tabCar[$i].'</option>';
                            }
                    }
                    
                    ?>  
                    
                </select>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </form>
                
               Przebyte trasy:
                <br/>
                <br/>
                 <div id="roadSelect">
                     
                 </div>
                </div>
                
                <div id="right_info_final">

                    
                </div>
                
            </div>