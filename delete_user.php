<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
/*
 * if not logged in
 */
if (!isset($_SESSION['username'])){
    header('Location:  http:login.php');
}
# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Connection to database failed.". $e->getMessage();
    die();
}
#F delete actor
            $sql = "DELETE FROM user WHERE user_id =:id ;";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            header('Location:  http:user.php');
?>