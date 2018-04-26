            
            
                <div >
                    <a class="logo" href="#"><img src="img/logo.png" alt="logo"></a>
                </div>
                
                <!--div --><!--?php echo $place_x ?--><!--/div-->
                <div >
                    <p class="text-right">
                    <?php
                        if (isset($_SESSION['username'])){
                        #logged in 

//                            echo "Welcome <b>".strtoupper(substr($_SESSION['username'],0,1)).substr($_SESSION['username'],1)." </b>";
//                            echo "<a href = 'logout.php'>log out</a>";
                        } else {
                        #not logged in 
                        //echo "<a href = 'login.php'>Sign in</a>";
                        //echo " to your account";
                        }
                    ?>
                    </p>
                </div>
            