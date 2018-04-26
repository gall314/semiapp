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


#F toggles notification emails
function toggleSpam($pdo, $c) {
    
    $toggle;
    //-------------
    $sql = "SELECT `spam` FROM `user` WHERE `user_id` =".$_SESSION['user_id'];
     try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        foreach($stmt as $row){
            if($c == 11) {
                $toggle = $row[0];
            }
            if($c == 1) {
                echo $row[0];
            }
        }
        $stmt->closeCursor();    
    }
    catch(PDOException $e)  {
        echo "Connection to database failed.".$e->getMessage();
    }
    if($c == 11) {
    //-------------
        if ($toggle == 1) {
            $sql = "UPDATE `user` SET `spam` = '0' WHERE `user`.`user_id` =".$_SESSION['user_id'];
            echo 0;
        } 
        if ($toggle == 0){
            $sql = "UPDATE `user` SET `spam` = '1' WHERE `user`.`user_id` =".$_SESSION['user_id']; 
            echo 1;
        }


        try  {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();    
        }
        catch(PDOException $e)  {
            echo "Connection to database failed.".$e->getMessage();
        }
    }
    
}

toggleSpam($pdo, $c);
?>