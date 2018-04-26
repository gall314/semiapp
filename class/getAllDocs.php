<?php
require_once '../include/sessionhandler.php';
require_once '../include/settings.php';




# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Nawiązanie połaczenia z bazą danych nie powiodło się.". $e->getMessage();
    die();
}
#F retrives all docs

function getAllDocs($pdo){
    if ($_SESSION['role'] == "admin"){
        $sql = "SELECT first_name, last_name, user_id FROM user WHERE role = 'doctor'";
    }
    if ($_SESSION['role'] == "doctor"){
        $sql = "SELECT first_name, last_name, user_id FROM user WHERE role = 'doctor' AND user_id =".$_SESSION['user_id'];
    }
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $AllDocs = "";
        
        
        foreach ($stmt as $row) {
        
        $AllDocs .= '<option value="'.$row['user_id'].'" >'.$row['first_name'].' '.$row['last_name'].'</option>';
            
        }
        $stmt->closeCursor();
                
    }
    catch(PDOException $e)  {
        $AllDocs .= "Connection to database failed.".$e->getMessage();
    }
    return $AllDocs;
}

echo getAllDocs($pdo);
?>