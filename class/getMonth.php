<?php
require_once '../include/sessionhandler.php';
require_once '../include/settings.php';




$d = $_REQUEST["d"];
if ($_REQUEST["d"] < 10) {
    $d = "0".$_REQUEST["d"];
}
$m = $_REQUEST["m"];
if ($_REQUEST["m"] < 10) {
    $m = "0".($_REQUEST["m"] + 1);
}
$y = $_REQUEST["y"];
$textToStage = "";

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

#F retireves doc ids
$fstdoc = "";
function getDocs($pdo, $yi, $mi, $di, $ty) {
    $opt = "";
    //$sql = 'SELECT `doc_id` FROM `dates` WHERE `date` LIKE "'.$yi.'-'.$mi.'-'.$di.'%" ORDER BY `date` DESC';
    $sql = 'SELECT DISTINCT first_name, last_name, doc_id FROM user as u JOIN dates as d ON u.user_id = d.doc_id WHERE d.date LIKE"'.$yi.'-'.$mi.'-'.$di.'%" ';
    
    $returnContentToHTML = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $ite =0;
        $opts = array();
        foreach ($stmt as $row) {
            $opts[$ite] = $row;
            $ite++;
        }
        //var_dump($opts[2]);
        if(count($opts) > 0) {
            $opt = $opts[0][2];
            //var_dump($opt);
            if($_SESSION['role'] == "patient") {
                $returnContentToHTML = '<div><br><p>Wybierz nazwisko lekarza z listy poniżej aby zobaczyć dostępne terminy.</p><select class="form-control" id="pick" onchange="refreshDates(this.value)">';
                //onclick=viewDates(this.innerHTML,"+today.getMonth()+","+today.getFullYear()+", this.value"+")'>"
                if(count($opts) > 1){
                    //unset($opts[0]);
                    //$opts[0] = array("","Wybierz lekarza",0);
                    //$textToStage = print_r($opts);
                    $returnContentToHTML .= '<option value="">wybierz lekarza</option>';
                    foreach ($opts as $row) {
                        $returnContentToHTML .= '<option value="'.$row['doc_id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
                    }
                } else {
                        $returnContentToHTML .= '<option value="">wybierz lekarza</option>';
                        $returnContentToHTML .= '<option value="'.$row['doc_id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';

                }
                $returnContentToHTML .= '</select></div>';
            }
        } else {
            $returnContentToHTML = "<div><h3>Brak terminów w tym dniu</h3></div>";
        }
        
        
        $stmt->closeCursor();
        $returnContentToHTML .= '</table>';
            
    }
    catch(PDOException $e)  {
        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
    }
    if($ty === 1){
        return $opt;
    } else {
        return $returnContentToHTML;
    }
}
# | --------------------------------------------------------|
$fstdoc = getDocs($pdo, $y, $m, $d, 1);
# | --------------------------------------------------------|
if (0 == 0){
    $textToStage .= getDocs($pdo, $y, $m, $d, 0);
} else {
    $textToStage .= "";
}
# | --------------------------------------------------------|
#F retrieves Patients from DB 
function getDates($pdo, $yi, $mi, $di, $doc) {
    if($_SESSION['role'] == "patient" ){
        $sql = 'SELECT `date`, `date_id`,`doc_id` , `open` FROM `dates` WHERE `date` LIKE "'.$yi.'-'.$mi.'-'.$di.'%" AND `doc_id` = "'.$doc.'" ORDER BY `date` ASC';
    }
    if($_SESSION['role'] == "doctor"){
        
        
        $sql = 'SELECT date, d.date_id, doc_id, open , first_name, last_name FROM user u JOIN appointments a ON u.user_id = a.patient_id RIGHT JOIN dates d ON d.date_id = a.date_id WHERE `date` LIKE "'.$yi.'-'.$mi.'-'.$di.'%" AND `doc_id` = "'.$_SESSION['user_id'].'" ORDER BY `date` ASC';
    }
    if( $_SESSION['role'] == "admin"){
        
        
        $sql = 'SELECT date, d.date_id, doc_id, open , first_name, last_name FROM user u JOIN appointments a ON u.user_id = a.patient_id RIGHT JOIN dates d ON d.date_id = a.date_id WHERE `date` LIKE "'.$yi.'-'.$mi.'-'.$di.'%" ORDER BY `date` ASC';
    }
    $returnContentToHTML = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $returnContentToHTML .= '<br><p>Lista dostępnych terminów:</p><table class="table table-hover visi">';
        if( $_SESSION['role'] == "doctor" || $_SESSION['role'] == "admin"){
            $returnContentToHTML .= '<tr><th>Termin</th><th>Pacjent</th><th></th></tr>';
        }
        if( $_SESSION['role'] == "patient" ){
            $returnContentToHTML .= '<tr><th>Termin</th><th>Akcja</th><th></th></tr>';
        }
        foreach ($stmt as $row) {
            if($row['open'] == true){
                
                if($_SESSION['role'] == "patient" ){
                    $returnContentToHTML.= '<tr><td>'.$row['date'].'</td><td><button value="'.$row['date_id'].'"  id="dd'.$row['date_id'].'"onclick="bookDate(this.value)" class="btn nar loow" >'.'Rezerwuj'.'</button></td><td></td></tr>';
                }
                
                
                if( $_SESSION['role'] == "doctor"  ){
                    $returnContentToHTML.= '<tr><td>'.$row['date'].'</td><td><button value="'.$row['date_id'].'"  id="dd'.$row['date_id'].'"onclick="bookDate(this.value)" class="btn nar loow" >'.'Rezerwuj'.'</button></td><td><button value="'.$row['date_id'].'"  onclick="removeDate(this.value)" class="btn nar loow">Usuń</button></td></tr>';
                }
                if($_SESSION['role'] == "admin" ){
                    $returnContentToHTML.= '<tr><td>'.$row['date'].'</td><td><button value="'.$row['date_id'].'"  id="dd'.$row['date_id'].'"onclick="bookDate(this.value)" class="btn nar loow" >'.'Rezerwuj'.'</button></td><td><button value="'.$row['date_id'].'"  onclick="removeDate(this.value)" class="btn nar loow">Usuń</button></td></tr>';
                }
                
            } else {
                if($_SESSION['role'] == "doctor" || $_SESSION['role'] == "admin"){
                    $returnContentToHTML.= '<tr><td>'.$row['date'].'   <b>zarezerwowane</b></td><td>'.$row['first_name'].' '.$row['last_name'].'</td><td></td></tr>';
                } else {
                    $returnContentToHTML.= '<tr><td>Termin zajęty</td><td>...</td><td></td></tr>';
                }    
            }
        }
        $stmt->closeCursor();
        $returnContentToHTML .= '</table>';
            
    }
    catch(PDOException $e)  {
        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
    }
    return $returnContentToHTML;
}
if($c == 0){
    //$textToStage .= $fstdoc."C equals: ".$c;
    
    
    $textToStage .= getDates($pdo, $y, $m, $d, $fstdoc);
} else {
    //$textToStage .= "C equals: ".$c;
    $textToStage .= getDates($pdo, $y, $m, $d, $c);
}
echo $textToStage;
?>