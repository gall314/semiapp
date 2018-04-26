<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';

#F generates a form
function generateForm4($action, $actor_id, $first_name, $last_name, $secmail) {
    $form = "";
    $form .= '<div class="container high"> <div class="row" id="editForm">';
    $form .= "<form action='$action' method='post'>".PHP_EOL;
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= '<h1>Mój profil</h1><div onclick="toggleSpam(11)" class="spam me" id="spa">--</div><p class="spam">Powiadomienia:  </p></div>';
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='first'>Imię: </label>";
    $form .= "<input class='form-control' type='text' name='first_name' id='first' value='$first_name'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='last'><br>Nazwisko: </label>";
    $form .= "<input class='form-control' type='text' id='last' name='last_name' value='$last_name'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='pass'><br>Hasło: </label>";
    $form .= "<input class='form-control' type='text' id='pass' name='password'  placeholder='***'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
    $form .= "<label for='emai'><br>Email:  </label>";
    $form .= "<input class='form-control' type='email' id='emai' name='secmail'  value='$secmail'>".PHP_EOL;
    $form .= "</div>";
    $form .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3"><br>';
    $form .= "<input class='btn form-control' type='submit'  name='submit' value='Aktualizuj'>".PHP_EOL;
    $form .= "</div>";
    $form .= "<input type='hidden' name='id' value='$actor_id'>".PHP_EOL;
    $form .= "</form>".PHP_EOL;
    $form .= "</div></div>";
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
   
    
    if (    $_POST['password'] != "" ){
        
            try {

                $stmt = $pdo->prepare('UPDATE user SET 
                                    first_name=:first_name, 
                                    last_name=:last_name,
                                    secmail=:secmail,
                                    password=:password                    
                                    WHERE email=:actor_id;'
                                    );
                $stmt->bindValue(':actor_id', $_POST['id'], PDO::PARAM_INT);
                $stmt->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
                $stmt->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
                $stmt->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
                $stmt->bindValue(':secmail', $_POST['secmail'], PDO::PARAM_STR);
                $stmt->execute();
                $stmt->closeCursor(); 
                #updateActor($pdo, $_POST['id'],$_POST['first_name'], $_POST['last_name']);
//                $content_x .= "Zapisano poprawnie.<br>".PHP_EOL;
//                $content_x .= generateForm4 ( basename(__FILE__),$_POST['id'],$_POST['first_name'], $_POST['last_name']);
//                $content_x .= '<a class="bttn" href="user.php">back</a>'.PHP_EOL;
                header('Location:  http:profile.php');
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
                                WHERE email=:actor_id;'
                                );
            $stmt->bindValue(':actor_id', $_POST['id'], PDO::PARAM_INT);
            $stmt->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
            $stmt->bindValue(':secmail', $_POST['secmail'], PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor(); 
            #updateActor($pdo, $_POST['id'],$_POST['first_name'], $_POST['last_name']);
//            $content_x .= "Zapisano poprawnie.<br>".PHP_EOL;
//            $content_x .= generateForm4 ( basename(__FILE__),$_POST['id'],$_POST['first_name'], $_POST['last_name']);
//            $content_x .= '<a class="bttn" href="user.php">back</a>'.PHP_EOL;
            header('Location:  http:profile.php');
        }
        catch (PDOException $e){
            $content_x ="Failed to update the record!".$e->getMessage();
        }
    } 
    #process templates
    require_once 'templates/home.php';
}
#Open form with target data to be edited

    
    try {
    $sql = 'SELECT first_name, last_name, secmail FROM `user` WHERE email="'.$_SESSION["username"].'";';
    $stmt = $pdo->prepare($sql);
    //$stmt->bindValue(':actor_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $row=$stmt->fetch();
    $stmt->closeCursor(); 
    //generate content
    
    $content_x .= "<br>".PHP_EOL;
    $content_x .= generateForm4(basename(__FILE__),$_SESSION["username"],$row['first_name'],$row['last_name'],$row['secmail']);
    }
    catch(PDOException $e)  {
        $content_x .= "Connection to database failed.".$e->getMessage();
    }
    
    #$content_x .= getActors($pdo);
    #process templates
    

require_once 'templates/home.php';
?>