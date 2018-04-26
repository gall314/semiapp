<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';

#F generates a form
function generateForm2($action, $actor_id, $first_name, $last_name, $secmail, $password, $email) {
    
    $form = "";
//    $form .= '<div class="container high"> <div class="row" id="editForm">';
    $form .= "<form action='$action' method='post'>".PHP_EOL;
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='first'> Imię: </label>";
    $form .= "<input class='form-control' type='text' name='first_name' id='first' value='$first_name'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='emai'><br>Nazwisko:  </label>";
    $form .= "<input class='form-control' type='text' name='last_name' value='$last_name'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='emai'><br>Hasło:  </label>";
    $form .= "<input class='form-control' type='text' name='password' value='' placeholder='***'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='emai'><br>Email:  </label>";
    $form .= "<input class='form-control' type='text' name='secmail' value='$secmail'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3"><br>';
    $form .= "<input class='btn form-control' type='submit'  name='submit' value='Aktualizuj'>".PHP_EOL;
    $form .= "</div>";
    $form .= "<input type='hidden' name='id' value='$actor_id'>".PHP_EOL;
    $form .= "<input type='hidden' name='pass' value='$password'>".PHP_EOL;
    $form .= "<input type='hidden' name='email' value='$email'>".PHP_EOL;
    $form .= "</form>".PHP_EOL;
    $form .= "</div>";
    return $form;
}
/*
 * if not logged in
 */
if (!isset($_SESSION['username'])){
    header('Location:  http:login.php');
}
$place_x = "edit actors page";
# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Connection to database failed.". $e->getMessage();
    die();
}
$content_x ="";
# Update a  record
# validate if form contains data
if (isset($_POST['submit'])) {
    //echo $_POST['pass'];
    
//        if(($_POST['secmail'] == "")) {
//            $imail = $_POST['email']; 
//            //echo $imail;
//        }
        //$_POST['password'] = $_POST['pass'];
        if ( $_POST['password'] != ""){
            try {

                $stmt = $pdo->prepare('UPDATE user SET 
                                    first_name=:first_name, 
                                    last_name=:last_name,
                                    secmail=:secmail,
                                    password=:password
                                    WHERE user_id=:actor_id;'
                                    );
                $stmt->bindValue(':actor_id', $_POST['id'], PDO::PARAM_INT);
                $stmt->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
                $stmt->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
                $stmt->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
                $stmt->bindValue(':secmail', $_POST['secmail'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor(); 
                #updateActor($pdo, $_POST['id'],$_POST['first_name'], $_POST['last_name']);
                $content_x .= "Zapisano poprawnie.<br>".PHP_EOL;
                $content_x .= generateForm2 ( basename(__FILE__),$_POST['id'],$_POST['first_name'], $_POST['last_name']);
                //$content_x .= '<a class="bttn" href="user.php">back</a>'.PHP_EOL;
                header('Location:  http:user.php');
            }
            catch (PDOException $e){
                $content_x ="Failed to update the record!".$e->getMessage();
            }
        }
     if (($_POST['first_name']!="") && ($_POST['last_name'] != "") && ($_POST['secmail'] != "") && ($_POST['password'] == "")){
            try {

                $stmt = $pdo->prepare('UPDATE user SET 
                                    first_name=:first_name, 
                                    last_name=:last_name,
                                    secmail=:secmail
                                    WHERE user_id=:actor_id;'
                                    );
                $stmt->bindValue(':actor_id', $_POST['id'], PDO::PARAM_INT);
                $stmt->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
                $stmt->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
                $stmt->bindValue(':secmail', $_POST['secmail'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor(); 
                #updateActor($pdo, $_POST['id'],$_POST['first_name'], $_POST['last_name']);
                $content_x .= "Zapisano poprawnie.<br>".PHP_EOL;
                $content_x .= generateForm2 ( basename(__FILE__),$_POST['id'],$_POST['first_name'], $_POST['last_name']);
                //$content_x .= '<a class="bttn" href="user.php">back</a>'.PHP_EOL;
                header('Location:  http:user.php');
            }
            catch (PDOException $e){
                echo "Failed to update the record!".$e->getMessage().'<br><a href="index.php">powrót<a>';
                
            }
        }
    
    //$content_x .= "niestety";
    #process templates
    //header('Location:  http:user.php');
}
#Open form with target data to be edited
if (isset($_GET['id'])){
    
    try {
    $sql = 'SELECT first_name, last_name, email, secmail, password FROM `user` WHERE user_id=:actor_id;';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':actor_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $row=$stmt->fetch();
    $stmt->closeCursor(); 
    //generate content
    $content_x .= '<div class="container high"> <div class="row" id="editForm">';
    $content_x .= '<br><br><div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3""><div class="alert alert-info">Edytuj dane poniżej nastepnie kliknij "aktualizuj" aby zapisac zmiany i wrócić do poprzedniego ekranu.</div></div><br>'.PHP_EOL;
    $content_x .= generateForm2(basename(__FILE__),$_GET['id'],$row['first_name'],$row['last_name'],$row['secmail'],$row['password'],$row['email']);
    $content_x .= '</div>';
    }
    catch(PDOException $e)  {
        $content_x .= "Connection to database failed.".$e->getMessage();
    }
    
    #$content_x .= getActors($pdo);
    #process templates
    require_once 'templates/home.php';
} 

?>