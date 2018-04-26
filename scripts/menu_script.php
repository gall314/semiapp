<?php


#generate menu items
function menu($menu) {
    if (!is_array($menu)) return FALSE;
    
    $content="<div >".PHP_EOL;
    $content.="             <div>\n".PHP_EOL;
    $content.="<a class='logo' href='#'><img src='img/logo.png' alt='logo'></a>".PHP_EOL;
    $content.="</div>".PHP_EOL;
    $content.='<nav class="menu hidden-xs"><ul class="navbar-nav nav mull">'.PHP_EOL;//navbar-nav nav
    
    foreach ($menu["PUBLIC_k"] as $address => $headline) {
        if (is_file($address))
            $content.= "<li ><a class='mir' href=\"$address\">$headline</a></li>".PHP_EOL;
    }
    if (isset($_SESSION['username'])){
//        foreach ($menu["PRIVATE_k"] as $address => $headline) {
//            if (is_file($address))
//            $content .= "<li><a href=\"$address\">$headline</a></li>".PHP_EOL;
//        }
        $content .= '<li class=" dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Strefa użytkownika</a>
        <ul class="dropdown-menu suba">';
        
        foreach ($menu["PRIVATE_k"] as $address => $headline) {
            if (is_file($address))
            $content .= "<li><a class='mir' href=\"$address\">$headline</a></li>".PHP_EOL;
        }
        
        $content .= '<li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Wyloguj</a></li>
        </ul>
        </li>'.PHP_EOL;
        //$content .= '<li ><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>'.PHP_EOL;
    } else {
        $content .= "<li><a href='login.php'>Logowanie</a></li>".PHP_EOL;
        #$content .= "<li class='  '><a href='register.php'>Rejestracja</a></li>".PHP_EOL;
    }
    $content.="</ul></nav><div onclick='hamb()' class='hidden-md hidden-sm hidden-lg' id='hamb' style='float: right;'><i class='fa fa-bars fa-3x' aria-hidden='true'></i></div></div>".PHP_EOL;
    
    return $content;
}
?>