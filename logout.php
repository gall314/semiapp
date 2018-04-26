<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
//Define $place_x for use in templates
//home.php -> header.php
$place_x = "logout page";

//generate content
unset($_SESSION['username']);
header('Location:  http:index.php');
//$content_x = "Thanks for logging out. Come back soon.";

//process templates
require_once 'templates/home.php';
?>