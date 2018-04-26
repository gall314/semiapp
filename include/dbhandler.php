<?php

#F generates a form
function generateForm3($action, $rol) {
$form = "";
$form .= <<<FORM
<form action='$action' method='post'>
        <label>Login / e-mail:</label>
        <input  class='form-control'  type='email' required name='email'>
FORM;
if ($rol == "admin"){
$form .= <<<FORMg
        <label for='role'>Rola:</label>
        <select class='form-control' id="role" name='role' >
            <option value='admin'>admin</option>
            <option value='doctor'>lekarz</option>
            <option value='patient' selected>pacjent</option>
        </select>
FORMg;
} else {
$form .= <<<FORMg
        <input type="hidden"  id="role" name='role' value='patient'>
FORMg;
}
$form .= <<<FORMe
        <label for='name1'>Imię:</label>
        <input  class='form-control' type='text' id='name1' required name='first_name'>
        <label for='name2'>Nazwisko:</label>
        <input class='form-control' type='text' required name='last_name'>
        <label for='pass'>Hasło:</label>
        <input class='form-control' type='password' required name='password'>
        <label for='pass'>Powtórz hasło:</label>
        <input class='form-control' type='password' required name='password2'>
        <br>
        <input class='btn' type='submit'  name='submit' value='Zapisz'>
    
</form>
FORMe;
    
//    $form = "";
//    $form .= "<form action='$action' method='post'>".PHP_EOL;
//    $form .= "e-mail:<br><input  class='form-control'  type='email' required name='email' value=''><br>".PHP_EOL;
//    $form .= "rola:<select class='form-control' name='role'><option value='admin'>admin</option><option value='doctor'>lekarz</option><option value='patient' selected>pacjent</option></select><br>".PHP_EOL;
//    $form .= "Imię:<br><input  class='form-control' type='text' required name='first_name' value=''><br>".PHP_EOL;
//    $form .= "Nazwisko:<br><input class='form-control' type='text' required name='last_name' value=''><br>".PHP_EOL;
//    $form .= "Hasło:<br><input class='form-control' type='password' required name='password' value=''><br>".PHP_EOL;
//    
//    $form .= "<input class='btn' type='submit'  name='submit' value='Zapisz'>".PHP_EOL;
//    $form .= "</form>".PHP_EOL;
    return $form;
}
#F retrieves user from DB 
function grabUser ($pdo, $email) {

    $sql = 'SELECT secmail, first_name, last_name FROM `user` WHERE email = "'.$email.'" ';
    $returnContentToHTML = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        foreach ($stmt as $row) {
           $grab[0] = $row["secmail"];
           $grab[1] = $row["first_name"]." ".$row["last_name"];
        }
        $stmt->closeCursor();    
    }
    catch(PDOException $e)  {
        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
    }
    //echo "rola to: ".$role;
    return $grab;
}
#F retrieves user's role from DB 
function checkRole ($pdo, $email) {

    $sql = 'SELECT role FROM `user` WHERE email = "'.$email.'" ';
    $returnContentToHTML = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        foreach ($stmt as $row) {
           $role = $row["role"];
        }
        $stmt->closeCursor();    
    }
    catch(PDOException $e)  {
        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
    }
    //echo "rola to: ".$role;
    return $role;
}
#F retrieves Patients from DB 
function getUsers ($pdo, $rola, $urol) {

    $sql = 'SELECT user_id, email, first_name, last_name, join_date FROM `user`  WHERE role= "'.$rola.'" ORDER BY `user`.`last_name` ASC;';
    $returnContentToHTML = "";
    try  {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $returnContentToHTML .= '<br><table class="table table-hover " id="-tabb">';
        $returnContentToHTML .= '<tr><th>Nazwisko</th><th class="hidden-xs hidden-sm">Imię</th><th>Login</th><th class="hidden-xs hidden-sm">Data aktualizacji</th><th></th><th></th></tr>';
        foreach ($stmt as $row) {
            $time = strtotime($row['join_date']);
            $myday = date("d", $time);
            $mymonth = date("m", $time);
            $myyear = date("Y", $time);
            $mytime = date("G:i ", $time);
            $miesiac =array("01"=>"styczeń", "02"=>"luty", "03"=>"marzec","04"=>"kwiecień","05"=>"maj","06"=>"czerwiec","07"=>"lipiec","08"=>"sierpień","09"=>"wrzesień","10"=>"październik","11"=>"listopad","12"=>"grudzień");
            
            
            $returnContentToHTML.= '<tr><td>'.$row['last_name'].'</td><td class="hidden-xs hidden-sm">'.$row['first_name'].'</td><td>'.$row['email'].'</td>';
            $returnContentToHTML.= '<td class="hidden-xs hidden-sm">'.$myday.' '.$miesiac[$mymonth]." ".$myyear.'</td><td>';
            if($urol=="admin"){
                $returnContentToHTML.= '<a  href="delete_user.php?id='.$row['user_id'].'"> <i class="fa fa-trash-o" aria-hidden="true"><b class="hidden-xs hidden-sm"> usuń</b></i></a></td><td>';
            }
            $returnContentToHTML.= '<a  href="edit_user.php?id='.$row['user_id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"><b class="hidden-xs hidden-sm"> edytuj</b></i> </a>';
            $returnContentToHTML.= '</td></tr>';
        }
        $stmt->closeCursor();
        $returnContentToHTML .= '</table>';
            
    }
    catch(PDOException $e)  {
        $returnContentToHTML .= "Connection to database failed.".$e->getMessage();
    }
    return $returnContentToHTML;
}
#F add actor 
function addUser ($pdo, $email, $first_name, $last_name, $password, $password2, $role){
    $email = strtolower($email);
    if($password === $password2){
    $sql = "INSERT INTO user (email, first_name, last_name, password, role, secmail) VALUES(:email, :first, :last, :password, :role, :email);";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':first', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
    } else {
        echo "ej no! hasła nie pasują";
    }
}
#F generates a form
function editUser($action, $user_id, $first_name, $last_name) {
    $form = "";
    $form .= "<form action='$action' method='post'>".PHP_EOL;
    $form .= "Imię: <input  type='text' name='first_name' value='$first_name'>".PHP_EOL;
    $form .= "Nazwisko: <input  type='text' name='last_name' value='$last_name'>".PHP_EOL;
    $form .= "Hasło: <input  type='password' name='password' value='***'>".PHP_EOL;
    $form .= "<input class='bttn' type='submit'  name='submit' value='Save'>".PHP_EOL;
    $form .= "<input type='hidden' name='id' value='$user_id'>".PHP_EOL;
    $form .= "</form>".PHP_EOL;
    return $form;
}
?>