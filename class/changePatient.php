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


#F changes Patient in appointment
function changePatient($pdo, $ci) {
    
    //echo "<h2>Termin usunięty</h2>";
    //-------------
    
    
    $sql = "SELECT first_name, last_name, user_id FROM user WHERE role = 'patient'";
    $response = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $response = '<select class="loow w10" id="pselect" onchange="commPatient(this.value, this.parentNode.parentNode.id)">';
        $response .= '<option>zmień pacjenta</option>';
        foreach ($stmt as $row) {
            $response .= '<option value="'.$row['user_id'].'">'.$row['first_name']." ".$row['last_name'].'</option>';
        }
        $response .= '</select>';
        $stmt->closeCursor();    
    }
    catch(PDOException $e)  {
        echo "Connection to database failed.".$e->getMessage();
    }
    return $response;
}

echo changePatient($pdo, $c);
?>