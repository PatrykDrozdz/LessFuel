
<title>Zarejestruj swoje konto</title>
<body onload="change_slide()">
    
    <?php 
        if(isset($_SESSION['error'])){
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
        }
    ?>
    
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel</div>
                
                <a href="index.php?page=main">Strona główna</a>
            </div>
                <div id="give_your_e-mail">   
                    <div id="left_log">
                    <form method="post">
                    <br/>
                    e-mail:
                    <br/>
                    <input type="text" name="email" id="textfield"/>
                    
                     <?php 
                        if(isset($_SESSION['error_email'])){
                            echo '<div class="error">'.$_SESSION['error_email'].'</div>'; 
                            unset($_SESSION['error_email']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    imię:
                    <br/>
                    <input type="text" name="yourName" id="textfield"/>
                    
                    <?php 
                        if(isset($_SESSION['error_name'])){
                            echo '<div class="error">'.$_SESSION['error_name'].'</div>'; 
                            unset($_SESSION['error_name']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    hasło:
                    <br/>
                    <input type="password" name="pass1" id="textfield"/>
                    
                     <?php 
                        if(isset($_SESSION['error_pass'])){
                            echo '<div class="error">'.$_SESSION['error_pass'].'</div>'; 
                            unset($_SESSION['error_pass']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
                    powtórz hasło:
                   <br/>
                    <input type="password" name="pass2" id="textfield"/>
                    <br/>
                    <br/>
                    <label>
                    <input type="checkbox" name="reg"/> Akceptuje 
                    </label>
                    <a href="">regulamin</a>
                    
                    <?php 
                        if(isset($_SESSION['error_reg'])){
                            echo '<div class="error">'.$_SESSION['error_reg'].'</div>'; 
                            unset($_SESSION['error_reg']);
                        }
                    ?>
                    
                    <br/>
                    <br/>
          
                    <input type="submit" value="Załóż konto" id="button"/>
                    
                </form>
                    </div>
                    <div id="right_info2">
                        <div id="photos"></div>
                    </div>    
                    
                </div>
