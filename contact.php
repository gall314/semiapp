<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
//Define $place_x for use in templates
//home.php -> header.php
//$place_x = "contact page";
require_once 'include/dbhandler.php';

# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Nawiązanie połaczenia z bazą danych nie powiodło się.". $e->getMessage();
    die();
}
#grab secmail and name
if (isset($_SESSION['username'])){
$userdata = grabUser($pdo, $_SESSION['username'] );
}
#generate content
$action = basename(__FILE__);
$nam = "";
$mai = "";
if (isset($_SESSION['username'])){
    $nam = $userdata[1];
    $mai = $userdata[0];
}
$content = <<<Content
    <br><br>
    <div class='container high'>
        <div class="row" id='contactForm'>
            <form action="$action" method="POST">
                <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
                    <h1>Napisz do nas</h1>
                </div>
                <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
                    <label for >Imię i nazwisko:</label>
                    <input class='form-control' type="text" required value="$nam" name="name" placeholder="podaj swoje imię i nazwisko">
                    <br>
                </div>
                <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
                    <label for >Adres e-mail:</label>
                    <input class='form-control' type="email" required name="email" placeholder="podaj swój adres e-mail" value="$mai">
                    <br>
                </div>
                <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
                    <label for >Treść wiadomości:</label>
                    <textarea class='form-control' name="msgbody" required rows="6" placeholder="Wpisz treść wiadomości"></textarea>
                    <br>
                </div>
                <div class="col-sm-12 col-md-6 col-md-offset-3">
                    <input class="btn  stretch" type="submit" value="Wyślij" name="submit">
                </div>
            </form>
    </div></div>
Content;

if (isset($_POST["submit"])) {
    if(($_POST["email"]!= "") &&  ($_POST["msgbody"]!= "") &&  ($_POST["email"]!= "")){
        $header = "From: ".$_POST["email"];
        $msg = "wiadomość od".$_POST["name"]."<br>treść wiadomości<br>".$_POST["msgbody"];
        mail("recepcja@mailinator.com","zapytanie o wizytę w gabinecie", $msg, $header);
        
        $alert ='<br><div class="alert alert-success col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">Wygląda na to, że wiadomość została wysłana.</div>';
        $content_x = $alert.$content;
        
    } else {
        
        //header('Location:  http:contact.php');
        $alert ='<br><div class="alert alert-danger col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">Ej, no! może tak coś wpisz...<img src="img/smi2.png" style="width: 30px;"></div>';
        $content_x = $alert.$content;
        
    }
    
}

if (!isset($_POST["submit"])) {
    $content_x = $content;
}
//process templates
require_once 'templates/home.php';
?>