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

#F get appointments
//function getAppos ($pdo) {
//
//    $sql = 'SELECT first_name, last_name, date FROM user u JOIN dates d ON u.user_id = d.doc_id JOIN appointments a ON d.date_id = a.date_id WHERE patient_id = 1';
//    $returnContentToHTML = "";
//    try  {
//        $stmt = $pdo->prepare($sql);
//        $stmt->execute();
//        $returnContentToHTML .= '<br><div><table class="table table-hover " id="appos">';
//        $returnContentToHTML .= '<tr><th>Data Twojej wizyty</th><th>Lekarz</th><th>akcja</th></tr>';
//        foreach ($stmt as $row) {
//             
//            
//            $returnContentToHTML.= '<tr><td>'.$row['date'].'</td><td>'.$row['first_name']." ".$row['last_name'].'</td><td><button class="btn">rezygnuj</a></td>';
//            
//        }
//        $stmt->closeCursor();
//        $returnContentToHTML .= '</table></div>';
//            
//    }
//    catch(PDOException $e)  {
//        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
//    }
//    return $returnContentToHTML;
//    }
#F retrieves Patients from DB 
function cancelDate($pdo, $ci) {
    
    
    //-------------
//    $lid = $_SESSION['user_id'];
//    
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
    $daydate;
    $sql = "SELECT date FROM `dates` WHERE date_id =".$ci;
    
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        foreach ($stmt as $row) {
            $daydate = $row[0];
            
        }
        $stmt->closeCursor();    
    }
    catch(PDOException $e)  {
        echo "Connection to database failed.".$e->getMessage();
    }
    $dzis =  date("Y-m-d");
    $dzis = strtotime($dzis);
    $daydate = strtotime($daydate);
    $czeck =  $daydate - $dzis;
    $czeck =  $czeck / (3600*24);
    
    if($czeck > 2){
        
        $sql = "DELETE FROM `appointments` WHERE `appointments`.`date_id` =".$ci;

        try  {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();    
        }
        catch(PDOException $e)  {
            echo "Connection to database failed.".$e->getMessage();
        }

        $sql = "UPDATE `dates` SET `open`= 1 WHERE `date_id`=".$ci;

        try  {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();    
        }
        catch(PDOException $e)  {
            echo "Connection to database failed.".$e->getMessage();
        }
    }  else {
       echo 1;
    }
//    if($_SESSION['spam']){
//        $header = "From: Gabinet Dentystyczny WSB";
//        $msg = "Wiadomość z Gabinetu Dentystycznego WSB<br>Twoja wizyta została odwołana. Zaloguj się aby zarezerwować inny dogodny termin <a href='euroslang.com/gabwsb/'>logowanie</a>";
//        mail($_SESSION['secmail'],"Twoja wizyta została odwołana. ", $msg, $header);
//    }
    //-------------------------------------
    

    //return $text;
}

//echo getAppos($pdo);
//echo $textToStage = 
cancelDate($pdo, $c);
?>