


    <body onload="change_slide()">
        <div class="container">
            
            <div id="header">
                <div class="title">LessFuel</div>

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
                
             
                
                <div id="left_add">
                    <?php 
                            
                        if(isset($_SESSION['error'])){
                            echo $_SESSION['error'];
                        }
                    ?>
                    
                </div> 
                
                <div id="make_account">
                    Nie masz jeszcze konta. <br/>
                    Załóż je teraz !!!
                    
                    <br/>
                    
                    <a href="index.php?page=make">Załóż konto</a>
                    
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
            