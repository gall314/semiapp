<?php
class UserClass {
    
#- - - - - - - - - - - -
#   P R O P E R T I E S
#- - - - - - - - - - - -
    private static $menuP = array("profile.php"=>"<i class='fa fa-user' aria-hidden='true'></i> Mój profil", "dates.php"=>"<i class='fa fa-calendar' aria-hidden='true'></i> Moje wizyty");
    private static $menuA = array("profile.php"=>"<i class='fa fa-user' aria-hidden='true'></i> Mój profil", "user.php"=>"<i class='fa fa-users' aria-hidden='true'></i> Użytkownicy", "dates.php"=>"<i class='fa fa-calendar' aria-hidden='true'></i> Wizyty");
    private static $menuD = array("profile.php"=>"<i class='fa fa-user' aria-hidden='true'></i> Mój profil", "user.php"=>"<i class='fa fa-users' aria-hidden='true'></i> Pacjenci", "dates.php"=>"<i class='fa fa-calendar' aria-hidden='true'></i> Mój kalendarz");
    private static $test="123";
#- - - - - - - - - - - -
#   M E T H O D S
#- - - - - - - - - - - -

#>>> Things a user can do

    public static function login($role){
        if($role == "admin"){
            return self::$menuA;
        } elseif ($role == "doctor") {
            return self::$menuD;
        } elseif ($role == "patient") {
            return self::$menuP;
        } else {
            echo "Uzytkownik nie ma zdefiniowanej roli lub rola jest niepoprawna.";
        }
    
    }
    public static function logi($role){
        if($role = "admin"){
            return "nic";
        }
    
    }
    

}

#patient can
#1 login
#2 edit own profile
#3 make apponitments for self
#4 view appointments


#doctor can
#1 login
#2 edit own profile
#3 make apponitments with self for patients
#4 view own appointments
#5 edit self timetable -crud 

#admin can
#1 login
#2 edit own profile
#3 make apponitments with any doctor for patients
#4 view any doctor's appointments 
#5 manage users - crud
#6 edit doctors' timetables -crud






?>