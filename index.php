<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';

$orig_action = $action = $_GET['action'];
if(empty($action)) {
    $action = 'index';
}
if(!file_exists('app/views/'.$action.'.php')) {
    $action = 'error404';
}
ob_start();
require_once 'app/views/'.$action.'.php';
$content_x = ob_get_clean();

require_once 'templates/home.php';
