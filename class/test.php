<?php
require_once 'UserClass.php';
//$test = new UserClass();
//$test->test();
//echo $test->test."<br>";
//echo $test->menuItems["user.php"];
//UserClass::login("admin");
$dupa = UserClass::login("admin");
print_r ($dupa);

?>

<html>
     <header>
        <div class="container" id="top">
            <div id="menu">
                     <div>
                        <a class='logo' href='#'><img src='img/logo.png' alt='logo'></a>
                     </div>
                     <nav class='menu'>
                       <ul>
                        <li class=' '><a  href="index.php">Strona Główna</a></li>
                        <li class=' '><a  href="offer.php">Usługi</a></li>
                        <li class=' '><a  href="contact.php">Kontakt</a></li>
                        <li class='  '><a href='login.php'>Logowanie</a></li>
                       </ul>
                    </nav>
            </div>
        </div>
    </header>

</html>
<!--
<form action='$action' method='post'>
        <label>Login / e-mail:</label>
        <input  class='form-control'  type='email' required name='email'>
        <label for='rola'>Rola:</label>
        <select class='form-control' name='role' >
            <option value='admin'>admin</option>
            <option value='doctor'>lekarz</option>
            <option value='patient' selected>pacjent</option>
        </select>
        <label for='name1'>Imię:</label>
        <input  class='form-control' type='text' required name='first_name'>
        <label for='name2'>Nazwisko:</label>
        <input class='form-control' type='text' required name='last_name'>
        <label for='pass'>Hasło:</label>
        <input class='form-control' type='password' required name='password'>
        <label for='pass'>Powtórz hasło:</label>
        <input class='form-control' type='password' required name='password2'>
        <input class='btn' type='submit'  name='submit' value='Zapisz'>
</form>-->
