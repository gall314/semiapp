<?php
require_once '../include/sessionhandler.php';
require_once '../include/settings.php';




$c = $_REQUEST["c"];



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
function removeDate($pdo, $ci) {
    
    echo "<h2>Termin usunięty</h2>";
    //-------------
    
    
    $sql = "DELETE FROM dates WHERE date_id =".$ci;
    
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $stmt->closeCursor();    
    }
    catch(PDOException $e)  {
        echo "Connection to database failed.".$e->getMessage();
    }
    
}

removeDate($pdo, $c);
?>