<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
#F generates a form
#NOTE TO SELF: poprawić contaner formularza
function generateForm($action) {
$form = <<<Cont
    <form action="$action" method='post'>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='email'>Adres e-mail (nazwa użytkownika):</label><br>
            <input class='form-control' type='email' name='email' id='email' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='fname'>Imię:</label><br>
            <input class='form-control' type='text' name='first_name' id='fname' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='lname'>Nazwisko:</label><br>
            <input class='form-control' type='text' name='last_name' id='lname' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='password'>Hasło:</label><br>
            <input class='form-control' type='password' name='password' id='password' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <label for='password2'>Powtórz hasło:</label><br>
            <input class='form-control' type='password' name='password2' id='password2' ><br>
        </div>
        <div class="">
            <input class='form-control' type='hidden' name='role' value='' ><br>
        </div>
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <input class='btn stretch' type='submit'  name='submit' value='Zapisz'>
        </div>
    </form>
Cont;
    /*$form .= "<form action='$action' method='post'>".PHP_EOL;
    $form .= "Adres email:<br><input type='email' name='email' value=''><br>".PHP_EOL;
    $form .= "Imię:<br><input  type='text' name='first_name' value=''><br>".PHP_EOL;
    $form .= "Nazwisko:<br><input type='text' name='last_name' value=''><br>".PHP_EOL;
    $form .= "<input class='btn' type='submit'  name='submit' value='Zapisz'>".PHP_EOL;
    $form .= "</form>".PHP_EOL;*/
    
    
    return $form;
}

#F add a new patient
function addPatient ($pdo, $email, $first_name, $last_name, $password){
    $sql = "INSERT INTO user (email, first_name, last_name, password, secmail) VALUES(:email, :first, :last, :password, :email);";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':first', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
}

# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Connection to database failed.". $e->getMessage();
    die();
}
# Save a new record
# validate if form contains data
if (isset($_POST['submit'])) {
    
    if (($_POST['first_name']!="") && ($_POST['last_name'] != "") && ($_POST['email'] != "") && ($_POST['password'] != "") && ($_POST['password2'] != "")){
        try {
           if ($_POST['password'] == $_POST['password2']){
                addPatient($pdo, $_POST['email'],$_POST['first_name'], $_POST['last_name'], $_POST['password']);
               header('Location:  http:login.php');
           } else {
               echo "hasła nie pasują";
           }

        }
        catch (PDOException $e){
            echo "Failed to save the new record!".$e->getMessage();
        }
    } else {
        echo "poprawić";
        //$content_x .= '<div class="alert alert-warning">'.PHP_EOL;
        //$content_x .= '<strong>Info!</strong>Formularz wymaga danych!'.PHP_EOL;
        //$content_x .= '</div></div>'.PHP_EOL;
    }
} 
//generate content 
$content_x ="";
$content_x .= '<br><br>'.PHP_EOL;
$content_x .= '<div class="container high">'.PHP_EOL;
$content_x .= '<div class="row">'.PHP_EOL;
$content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">';
$content_x .= '<h1>Rejestracja</h1>';
$content_x .= '<div class="alert alert-info">'.PHP_EOL;
$content_x .= '<strong>Info!</strong> Wypełnij formularz aby utworzyć konto.'.PHP_EOL;
$content_x .= '</div></div>'.PHP_EOL;
$content_x .= generateForm(basename(__FILE__));
$content_x .= '<br><br>'.PHP_EOL;
$content_x .= '</div></div>'.PHP_EOL;



//process templates
require_once 'templates/home.php';
?>