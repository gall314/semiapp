<?php
require_once 'include/settings.php';

$pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
$stmt = $pdo -> prepare('SELECT employee_id, password 
                                        FROM `employees` 
                                '); 
$stmt -> execute();
$stmt1 = $pdo -> prepare('UPDATE employees 
                            SET password=:password
                            WHERE employee_id=:employee_id
                                '); 
foreach ($stmt as $row) {
    $stmt1 -> bindValue(':employee_id', $row['employee_id'], PDO::PARAM_INT);
    $stmt1 -> bindValue(':password', md5($row['password'].$SALT), PDO::PARAM_STR);
    $stmt1 -> execute();
}
$stmt1 -> closeCursor();
$stmt -> closeCursor();