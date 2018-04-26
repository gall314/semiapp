<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
//Define $place_x for use in templates
//home.php -> header.php
$place_x = "product page";

//generate content
$content = <<<Content
product 
Content;
$work= "";
for($i=1; $i<6; $i++) $work.= $content.$i.PHP_EOL."<br/>";
$content_x = $work;

//process templates
require_once 'templates/home.php';
?>