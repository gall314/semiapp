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
    if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "patient"){
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
        
        $AllDocs[$row['user_id']] = $row['first_name'].' '.$row['last_name'];
            
        }
        $stmt->closeCursor();
                
    }
    catch(PDOException $e)  {
        echo  "Connection to database failed.".$e->getMessage();
    }
    return $AllDocs;
}


#F get appointments
function getAppos ($pdo) {
    $passon = getAllDocs($pdo);
    if($_SESSION['role'] == "patient"){
        $sql = 'SELECT first_name, last_name, date, d.date_id FROM user u JOIN dates d ON u.user_id = d.doc_id JOIN appointments a ON d.date_id = a.date_id WHERE patient_id ='.$_SESSION['user_id'].' ORDER BY date DESC;';
    }
    if($_SESSION['role'] == "doctor"){
        $sql = 'SELECT first_name, last_name, date, d.date_id FROM user u JOIN appointments a ON u.user_id = a.patient_id JOIN dates d ON a.date_id = d.date_id WHERE d.doc_id = '.$_SESSION['user_id'].' ORDER BY d.date DESC;';
    }
    if($_SESSION['role'] == "admin"){
        //do zmiany
        $sql = 'SELECT first_name, last_name, date, user_id, d.date_id, doc_id, app_id FROM user u JOIN appointments a ON u.user_id = a.patient_id JOIN dates d ON a.date_id = d.date_id ORDER BY d.date DESC;';
    }
    $returnContentToHTML = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $returnContentToHTML .= '<br><div><table class="table table-hover " id="appos">';
        if($_SESSION['role'] == "patient"){
            $returnContentToHTML .= '<tr><th>Data Twojej wizyty</th><th>Lekarz</th><th>akcja</th></tr>';
        }
        if($_SESSION['role'] == "doctor"){
            $returnContentToHTML .= '<tr><th>Data Godzina</th><th>Pacjent</th><th>akcja</th></tr>';    
        }
        if($_SESSION['role'] == "admin"){
            $returnContentToHTML .= '<tr><th>Data Godzina</th><th>Pacjent</th><th>Lekarz</th><th>akcja</th></tr>';    
        }
        foreach ($stmt as $row) {
             
            if($_SESSION['role'] == "patient" || $_SESSION['role'] == "doctor"){
                $returnContentToHTML.= '<tr><td>'.$row['date'].'</td><td>'.$row['first_name']." ".$row['last_name'].'</td><td><button value="'.$row['date_id'].'" onclick="cancelDate(this.value)" class="btn">odwołaj</a></td>';
            } 
            if($_SESSION['role'] == "admin"){
                $returnContentToHTML.= '<tr id="'.$row['app_id'].'"><td>ss'.$row['date'].'</td><td><button value='.$row['app_id'].' id="cp'.$row['app_id'].'" class="btn loow';
                
                if($row['user_id'] == $_SESSION['user_id']){
                        $returnContentToHTML.= ' redd"';
                } else {
                    $returnContentToHTML.= '"';
                }
                $returnContentToHTML.= 'onclick="changePatient(this.value)">'.$row['first_name']." ".$row['last_name'].'</button></td><td><button value="'.$row['app_id'].'" id="cd'.$row['app_id'].'" onclick="changeDoctor(this.value)" class="btn loow">'.$passon[$row['doc_id']].'</button></td><td><button value="'.$row['date_id'].'" onclick="cancelDate(this.value)" class="btn  loow">odwołaj</a></td>';
            }
            
        }
        $stmt->closeCursor();
        $returnContentToHTML .= '</table></div>';
            
    }
    catch(PDOException $e)  {
        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
    }
    return $returnContentToHTML;
    }


echo getAppos($pdo);

?>