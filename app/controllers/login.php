<?php
$message = '';
if (isset($_POST['submit'])) {
    if (($_POST['username'] != "") &&  ($_POST['password'] != "") ) {
        try
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $urole = "";
            $stmt = $pdo -> prepare('SELECT * FROM `user` WHERE `email` = :username');
            $stmt -> bindValue(':username', $username, PDO::PARAM_STR);
            $stmt -> execute();
            if ($stmt->rowCount()>1) {
                $message = 'Incorrect number of users with the given username';
            } else  if ($stmt->rowCount()==0) {#username could not be found
                $message = 'Ups! Nieprawidłowa nazwa użytkownika!';
            } else {
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                if ($row['password'] == $password) {
                    $_SESSION['username']=$username;
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['secmail'] = $row['secmail'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['spam'] = $row['spam'];
                    header('Location:  /dashboard');
                } else { #incorrect password
                    $message = 'Ups! Nieprawidłowe hasło. Masz zły dzień, czy jak?';
                }
            }
            $stmt->closeCursor();
        }
        catch(PDOException $e)
        {
            $message = 'Połączenie z basza danych nie zostło nawiązane: ' . $e->getMessage();
        }
    } else {
        $message = 'Ups! Proszę podać nazwę użytkownika i hasło.';
    }
}