<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
//require_once 'inclue/perms.php';
require_once 'include/dbhandler.php';

#F generates a form -dbhandler.php
#F retrieves Patients from DB -dbhandler.php
#F add actor -dbhandler.php
#F generates a form -dbhandler.php

/*
 * if not logged in
 */
if (!isset($_SESSION['username'])){
    header('Location:  http:login.php');
}
//$place_x = "actors page";do skasowania


# Connect with DB
try {
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    $returnContentToHTML .= "Nawiązanie połaczenia z bazą danych nie powiodło się.". $e->getMessage();
    die();
}

#check for role
$rola = checkRole($pdo, $_SESSION['username'] );

# Save a new record
# validate if form contains data
if (isset($_POST['submit'])) {
    
    if (($_POST['first_name']!="") && ($_POST['last_name'] != "") && ($_POST['email'] != "")){
        try {
           #code removed
            addUser($pdo, $_POST['email'],$_POST['first_name'], $_POST['last_name'], $_POST['password'], $_POST['password2'],$_POST['role']);

        }
        catch (PDOException $e){
            echo "Niepowodzenie! Wpis nie został dokonany.".$e->getMessage();
        }
    }
} 
//generate content 
$content_x ='';
$content_x .= '<div class="container">'.PHP_EOL;
$content_x .= "<div class='row'>".PHP_EOL;
$content_x .= '<div class="col-sm-12"><h1>Strefa zarządzania użytkownikami</h1>'.PHP_EOL;
$content_x .= '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'.PHP_EOL;
$content_x .= '<ul class="nav nav-tabs">'.PHP_EOL;
if (checkRole($pdo, $_SESSION['username'] ) == "doctor" || checkRole($pdo, $_SESSION['username'] ) == "admin"){
    $content_x .= '<li class="active "><a onclick="activate()" data-toggle="tab" href="#home">Pacjenci</a></li>'.PHP_EOL;
}
if (checkRole($pdo, $_SESSION['username'] ) == "admin"){
    $content_x .= '<li class=""><a onclick="activate(menu1)" data-toggle="tab" href="#menu1">Lekarze</a></li>'.PHP_EOL;
    $content_x .= '<li class=""><a onclick="activate()" data-toggle="tab" href="#menu2">Recepcja</a></li>'.PHP_EOL;
}
if (checkRole($pdo, $_SESSION['username'] ) == "doctor" || checkRole($pdo, $_SESSION['username'] ) == "admin"){
    $content_x .= '<li class=""><a onclick="activate()" data-toggle="tab" href="#menu3">Nowy</a></li>'.PHP_EOL;
}
$content_x .= '</ul>'.PHP_EOL;
$content_x .= '<div class="tab-content">'.PHP_EOL;

//$content_x .= <<<Cont
//    <ul class="nav nav-tabs">
//        <li class="active"><a data-toggle="tab" href="#home">Pacjenci</a></li>
//        <li><a data-toggle="tab" href="#menu1">Lekarze</a></li>
//        <li><a data-toggle="tab" href="#menu2">Recepcja</a></li>
//        <li><a data-toggle="tab" href="#menu3">Nowy</a></li>
//    </ul>
//    <div class="tab-content">
//    
//Cont;
if ($rola == "doctor" || $rola == "admin"){
    $content_x .= '<div class="tab-content">'.PHP_EOL;
    $content_x .= "<div id='home' class='tab-pane bg-wh in active'>".PHP_EOL;
    $content_x .= getUsers($pdo, "patient", $rola).PHP_EOL;
    $content_x .= "</div>".PHP_EOL;
}
if ($rola == "admin"){
    $content_x .= "<div id='menu1' class='tab-pane bg-wh'>".PHP_EOL;
    $content_x .= getUsers($pdo, "doctor", $rola).PHP_EOL;
    $content_x .= "</div>".PHP_EOL;
    $content_x .= "<div id='menu2' class='tab-pane bg-wh'>".PHP_EOL;
    $content_x .= getUsers($pdo, "admin", $rola).PHP_EOL;
    $content_x .= "</div>".PHP_EOL;
}
if ($rola == "doctor" || $rola == "admin"){
    $content_x .= '<div id="menu3" class="tab-pane bg-wh">'.PHP_EOL;
    $content_x .= '<div class="container">'.PHP_EOL;
    $content_x .= '<div class="row">'.PHP_EOL;
    $content_x .= '<div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">'.PHP_EOL;
    $content_x .= '<br><div class="alert alert-info ">Wypełnij formularz aby dodać nowego użytkownika.</div>'.PHP_EOL;
    $content_x .= generateForm3(basename(__FILE__), $rola).PHP_EOL;
    $content_x .= '</div></div><br><br>'.PHP_EOL;
    $content_x .= "</div></div></div></div><br><br><br><br>".PHP_EOL;
}
    
    
    


//process templates
require_once 'templates/home.php';
?>