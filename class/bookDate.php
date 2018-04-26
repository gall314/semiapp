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
function bookDate($pdo, $ci) {
    
    if($_SESSION['role'] == "doctor"){
        echo "<p class='alert alert-danger'>Drogi Lekarzu, niestety nie uprawnień do rejestracji pacjentów.</p>";
    } else {
        echo "<h2>Zarezerwowane!</h2>";
        //-------------
        $lid = $_SESSION['user_id'];

        $sql = "INSERT INTO appointments ( date_id, patient_id, registrar ) VALUES (".$ci.','.$lid.','.$lid.')';

        try  {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();    
        }
        catch(PDOException $e)  {
            $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
        }

        $sql = "UPDATE `dates` SET `open`=0 WHERE `date_id`=".$ci;

        try  {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();    
        }
        catch(PDOException $e)  {
            $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
        }
    }
    
    
}

bookDate($pdo, $c);
?>