<?php
//require_once 'perms.php';


//$menu_x = array(
//    "PUBLIC_k"=>array(
//                "index.php"=>"Strona Główna",
//                "offer.php"=>"Usługi",
//                "contact.php"=>"Kontakt"),
//    "PRIVATE_k"=>array(
//                "user.php"=>"Użytkownicy..",
//                "dates.php"=>"Wizyty..",)
//    );
                
#UserClass::login($rola);
#$page_name_x = "Blockbuster Shack - VHS rental";

//Konfiguracja połączenia dla Serwera
$DBEngine = 'mysql';
$DBServer = 'localhost';
$DBUser   = 'root';
$DBPass   = '';
$DBName   = 'gabinet';


//if (isset($_SESSION['username'])){
//    $username = $_SESSION['username'];
//    # Connect with DB
//    try {
//        $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    } 
//    catch (PDOException $e) {
//        $returnContentToHTML .= "Connection to database failed.". $e->getMessage();
//    die();
//    }
//
//    
//}



$SALT = "enigma";

?>


