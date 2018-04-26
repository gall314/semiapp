<?php
require_once '../include/sessionhandler.php';
require_once '../include/settings.php';


//$day, $month, $year, $id, $p, $w, $s, $c, $t, $b
#d &m &y &id &po &wt &sr &cz &pt &sb

$day = $_REQUEST["d"];
$month = $_REQUEST["m"];
$year = $_REQUEST["y"];
$id = $_REQUEST["id"];
$p = $_REQUEST["po"];
$w = $_REQUEST["wt"];
$s = $_REQUEST["sr"];
$c = $_REQUEST["cz"];
$t = $_REQUEST["pt"];
$b = $_REQUEST["sb"];
$start = $_REQUEST["t1"];
$end = $_REQUEST["t2"];



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
function addDate($pdo, $day, $month, $year, $id, $p, $w, $s, $c, $t, $b, $start, $end){
 
    //echo "Dodany!". $day." ". $id." ". $p." ". $w." ". $s." ". $c." ". $t." ". $b;
    //echo "Dodany!". $month." ".$year;
    if($month < 10){
        $month = "0".($month+1);
    }
    if($day < 10){
        $day = "0".$day;
    }
    
    $num = ($end - $start) * 2;
    
    
    
    for ($i = 0; $i < $num ; $i++){
        
        $sql = "INSERT INTO `dates` (`date_id`, `date`, `doc_id`, `open`) VALUES (NULL, '".$year."-".$month."-".$day." ".$start.":00.', ".$id.", '1');";

        try  {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $stmt->closeCursor();    
        }
        catch(PDOException $e)  {
            echo "Connection to database failed.".$e->getMessage();
        }
        $start = strtotime($start) + 1800;
        $start = date('H:i', $start);
    }
    
    echo "<p class='alert alert-success'>Dodano nowy termin!</p>";
}

addDate($pdo, $day, $month, $year, $id, $p, $w, $s, $c, $t, $b, $start, $end);
?>