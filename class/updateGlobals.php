<?php
require_once '../include/sessionhandler.php';
require_once '../include/settings.php';




$c = $_REQUEST["g"];



# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Nawiązanie połaczenia z bazą danych nie powiodło się.". $e->getMessage();
    die();
}


#F retrieves Patients from DB 
function updateGlobals($pdo, $c) {
    
        $g = explode(',', $c);
         $GLOBALS['g'] = $g;
    print_r ($GLOBALS['g']);
        
    
    //echo "Melduję, że coś otrzymałem ;) ! ".$GLOBALS['g'][0];
    //print_r($GLOBALS);
//    $sql = "INSERT INTO appointments ( date_id, patient_id, registrar ) VALUES (".$ci.','.$lid.','.$lid.')';
//    
//    try  {
//        $stmt = $pdo->prepare($sql);
//        $stmt->execute();
//        $stmt->closeCursor();    
//    }
//    catch(PDOException $e)  {
//        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
//    }
//    
//    $sql = "UPDATE `dates` SET `open`=0 WHERE `date_id`=".$ci;
//    
//    try  {
//        $stmt = $pdo->prepare($sql);
//        $stmt->execute();
//        $stmt->closeCursor();    
//    }
//    catch(PDOException $e)  {
//        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
//    }
//    
    
}


updateGlobals($pdo, $c);
?>