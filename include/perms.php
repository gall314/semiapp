<?php
require_once 'class/UserClass.php';
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
#check for role

if (isset($_SESSION['username'])){
    $rola = checkRole($pdo, $_SESSION['username'] );
    $authMenu = UserClass::login($rola);
} else {
    $authMenu = "";
}


$menu_x = array(
    "PUBLIC_k"=>array(
                "index.php"=>"Strona Główna",
                "offer.php"=>"Usługi",
                "contact.php"=>"Kontakt"),
    "PRIVATE_k"=>$authMenu
//    array(
//                "user.php"=>"Użytkownicy..",
//                "dates.php"=>"Wizyty..",)
    );
?>