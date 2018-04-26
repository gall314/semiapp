<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';

try {
    global $pdo;
    $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $orig_action = $action = $_GET['action'];
    if (empty($action)) {
        $action = 'index';
    }
    if (!file_exists('app/views/' . $action . '.php')) {
        $action = 'error404';
    }

    $roles = array(
        'admin' => array('dashboard'),
        'patient' => array('dashboard'),
        'doctor'  => array('dashboard')
    );
    $secured = array('dashboard');

    $is_secured = in_array($action, $secured);
    $redirected = false;
    if($is_secured) {
        $is_logged = isset($_SESSION['username']);
        $is_in_role = in_array($action, $roles[$_SESSION['role']]);
        if(!$is_logged) {
            header('Location: /login');
            $redirected =true;
        }
        if(!$is_in_role) {
            header('Location: /error403');
            $redirected =true;
        }
    }
    if(!$redirected) {
        if (file_exists('app/controllers/' . $action . '.php')) {
            include('app/controllers/' . $action . '.php');
        }
        ob_start();
        require_once 'app/views/' . $action . '.php';
        $content_x = ob_get_clean();
    }

}
catch (PDOException $e) {
    $returnContentToHTML .= "Connection to database failed.". $e->getMessage();
    die();
}



require_once 'templates/home.php';
