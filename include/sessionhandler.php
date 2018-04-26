<?php

session_start();




if (!isset($_SESSION['visits'])){
    
    session_regenerate_id();
    $_SESSION['visits'] = true;
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}


if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){
    die('session hijacking attempt failed!');
}

?>