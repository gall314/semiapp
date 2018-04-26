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
function changeDoctor($pdo, $ci) {
    
    //echo "<h2>Termin usunięty</h2>";
    //-------------
    
    
    $sql = "SELECT first_name, last_name, user_id FROM user WHERE role = 'doctor'";
    $response = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $response = '<select class="loow w10" id="diselect" onchange="commDoctor(this.value, this.parentNode.nextSibling.childNodes[0].value)">';
        $response .= '<option>zmień lekarza</option>';
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

echo changeDoctor($pdo, $c);
?>