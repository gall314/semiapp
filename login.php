<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';

//Define $place_x for use in templates
//home.php -> header.php
//$place_x = "sign in page";

#generate content
function genForm($action){
$form = <<<Cont
    
    <form action="$action" method='post'>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='lname'>Login/e-mail:</label><br>
            <input class='form-control' type='email' name='username' id='lname' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='password'>Hasło:</label><br>
            <input class='form-control' type='password' name='password' id='password' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <input class='btn stretch' type='submit'  name='submit' value='Logowanie'>
        </div>
    </form>
    
Cont;
    return $form;
}
function genRegist(){
    $trail = <<<Cont
    <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
    <br><p>Nie masz jeszcze konta? Zarejestruj się.</p>
    <a class="btn" href="register.php">Rejestracja</a>
    </div>
Cont;
    return $trail;
}


$content_x = '<br><br>'.PHP_EOL;
$content_x .= '<div class="container high"><div class="row">';
$content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
$content_x .= '<h1>Logowanie</h1>'.PHP_EOL;
$content_x .= '</div>';
$content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3"><div class="alert alert-info">'.PHP_EOL;
$content_x .= '<strong>Info!</strong> Wypełnij formularz aby się zalogować. Przykładowy username: <b>pat@beat.com</b> password: <b>wert1234</b>'.PHP_EOL;
$content_x .= '</div></div>'.PHP_EOL;

if (isset($_SESSION['username'])){
    header('Location:  http:dates.php');
}




   //TESTING ONLY echo "twoja rola to: ".$_SESSION['role']." ".$_SESSION['secmail']." ".$_SESSION['user_id'];



if (isset($_POST['submit'])){
    if (($_POST['username'] != "") &&  ($_POST['password'] != "") ) {
        
        
        
        #connect to bd and verify credentials
        try
           {
              $username = $_POST['username'];
              $password = $_POST['password'];
              $urole = "";

              $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
              $stmt = $pdo -> prepare('SELECT *
                                        FROM `user` 
                                        WHERE `email` = :username'); 
              $stmt -> bindValue(':username', $username, PDO::PARAM_STR);
              $stmt -> execute();
              if ($stmt->rowCount()>1) throw new PDOException('Incorrect number of users with the given username');
              if ($stmt->rowCount()==0) {#username could not be found
                    $content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
                    $content_x .= '<div class="alert alert-danger">';
                    $content_x .= '<img src="assets/home.png" width="100px" alt="">';
                    $content_x .= 'Ups! Nieprawidłowa nazwa użytkownika!<br>';
                    $content_x .= '</div></div>';
                  
                    $content_x.= genForm(basename(__FILE__)).genRegist();
                    
               } else {
                    $row=$stmt->fetch(PDO::FETCH_ASSOC); 
                    //print_r($row);
                    #fetch row
                    #if ($row['password'] == md5($password.$SALT)) { #all clear -welcome message
                    if ($row['password'] == $password) {
                        $_SESSION['username']=$username;
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['secmail'] = $row['secmail'];
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['spam'] = $row['spam'];
                        header('Location:  http:login.php');
//                        
                    } else { #incorrect password
                        $content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
                        $content_x .= '<div class="alert alert-danger">';
                        $content_x .= '<img src="assets/home.png" width="100px" alt="">';
                        $content_x .= 'Ups! Nieprawidłowe hasło. Masz zły dzień, czy jak?<br>';
                        $content_x .= '</div></div>';
                        $content_x .= genForm(basename(__FILE__)).genRegist();
                    }
               }
               
               
              $stmt->closeCursor();
           }
           catch(PDOException $e)
           {
              echo 'Połączenie z basza danych nie zostło nawiązane: ' . $e->getMessage();
           } 
        
    } else {
        $content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
        $content_x .= '<div class="alert alert-danger">';
        $content_x .= '<img src="assets/home.png" width="100px" alt="">';
        $content_x .= "Ups! Proszę podać nazwę użytkownika i hasło.<br>";
        $content_x .= "</div></div>";
        $content_x.= genForm(basename(__FILE__)).genRegist();
        
    }
} else {
    $content_x.= genForm(basename(__FILE__)).genRegist();
    
}
    
    
    

 


//process templates
require_once 'templates/home.php';
?>
