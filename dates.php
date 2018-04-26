<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';


//require_once 'include/dbhandler.php';

//Define $place_x for use in templates
//home.php -> header.php
$place_x = "Wizyty";

//generate content



if (isset($_SESSION['username'])){

    # Connect with DB
    try {
        $pdo = new PDO("$DBEngine:host=$DBServer;dbname=$DBName", $DBUser, $DBPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        $returnContentToHTML .= "Nawiązanie połaczenia z bazą danych nie powiodło się.". $e->getMessage();
        die();
    }

    
    
    
    $content_x = <<<Content
    <div class='container'>
        <div class="row">
            <div class="col-md-12">
                <h1>Wizyty - terminy</h1>
Content;
    if($_SESSION['role']=="admin"){
        $content_x .= "<p>Aby razejestrować pacjenta na wizytę. Wybierz datę z kalendarza, następnie przy wybranym terminie kliknij <b>Rezerwuj</b>. Na liście zarejestrowanych wizyt pojawi się nowy wpis, w który należy kliknąc i podać nazwisko pacjenta. Podląd nazwiska lekarza jest dostępny wyłącznie w widoku pacjenta, aby zachęcic do samodzielnej rejestracji oraz uniknąć faworyzowania lekarzy przez pracowników recepcji <i class='fa fa-smile-o' aria-hidden='true'></i></p>";
    }
    if($_SESSION['role']=="patient"){
        $content_x .= "<p>Aby razejestrować się na wizytę wybierz datę z kalendarza, następnie przy wybranym terminie kliknij <b>Rezerwuj</b>. Dodatkowe informacje znajdziesz w <a href='help.php'>dziale pomocy</a> <i class='fa fa-smile-o' aria-hidden='true'></i></p>";
    }
    date_default_timezone_set("Europe/Warsaw");
    $mytime = date("h:i");
    $num = cal_days_in_month(CAL_GREGORIAN, 2, 2017); // 30
    $noOfCurrDays = date("t");
    $currMonth = date("M");
    
    $content_x .= "<br><p>Jest godzina<b> ".$mytime."</b></p><br>";
    $content_x .= <<<CONT
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-12" id="fgf">
                <h2>Lista zarezerwowanych wizyt</h2>
                <p id="cann"></p>
             </div>
            <div class="col-md-12" id="booked">
             </div>
        </div>
CONT;
//$content_x .= getAppos($pdo);
$content_x .= <<<CON
    <div class="row">
        <div class="col-md-12 ">
            <h2>Zarezerwuj kolejna wizytę </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-lg-5">
            <h3>Kalendarz</h3>
            <div id="cal">
                <div class="month">      
                      
                        <div onclick="mfNext(-1)" class="prev">&#10094;</div>
                        <div onclick="mfNext(1)" class="next">&#10095;</div>
                        <div style="text-align:center" id="cMonth">
                          Miesiąc i rok
                          <span style="font-size:18px">2016</span>
                </div>     
                </div>
                    <ul class="weekdays">
                      <li>
                          <span class="hidden-sm ">Pon</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Poniedziałek</span>
                      </li>
                      <li>
                          <span class="hidden-sm ">Wt</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Wtorek</span>
                      </li>
                      <li>
                          <span class="hidden-sm ">Śr</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Środa</span>
                      </li>
                      <li>
                          <span class="hidden-sm ">Cz</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Czwartek</span>
                      </li>
                      <li>
                          <span class="hidden-sm ">Pt</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Piątek</span>
                      </li>
                      <li>
                          <span class="hidden-sm ">Sb</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Sobota</span>
                      </li>
                      <li>
                          <span class="hidden-sm ">Nd</span>
                          <span class=" hidden-xs hidden-md hidden-lg">Niedziela</span>
                      </li>
                    </ul>

                    <ul id="dz" class="days">  
                      
                      <li ><span class="active">10</span></li>
                      
                    </ul>
                </div>
            </div>
        
            <div class="col-md-7 col-lg-7">
                <div id="result1">
                </div>
                <div id="result">
                <br><br>
                    <h3>Proszę wybierz datę z kalendarza.</h3> 
                    <p>Aby zarejestrować nową wizytę należy wybrać datę z kalendarz, nastepnie wybrać lekarza i przy dostępnym terminie kliknąć "Rezerwuj".</p>
                    <img class="hidden-sm hidden-xs" src="img/arro.png" alt="arrow" style="width: 30%;">
                </div>
            </div>
        </div>

CON;

if($_SESSION['role'] == "doctor" || $_SESSION['role'] == "admin"){
    $content_x .= <<<COiN
        
        <div class="row" id="addnew">
            <div class="col-md-12 col-lg-12">
                <h3>Dodaj godziny pracy.</h3> 
                <p>Wybierz datę z kalendarza, następnie podaj zakres godzin pracy. Aby usunąć godziny pracy wybierz datę z kalendarz a następnie lekarza i kliknij usuń przy wybranym terminie.</p>
                <div id="alert" class=""></div>
                <div>
                    <select onchange="updateGdocID(this.value)" class="form-control nar" id="selectd">
                    </select>
                </div><br>
                <div>
                    <button  onclick="stepUp(1)" class="nar btn"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
                    <input class="form-control nar" type="time" value="09:00" id="dutytime" readonly>
                    <button  onclick="stepDown(1)" class="nar btn"><i class="fa fa-chevron-down" aria-hidden="true"></i></button>
                </div><br>
                <div>
                    <button  onclick="stepUp(2)" class="nar btn"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>
                    <input class="form-control nar" type="time" value="17:00" id="dutytime2" readonly>
                    <button  onclick="stepDown(2)" class="nar btn"><i class="fa fa-chevron-down" aria-hidden="true"></i></button>
                </div><br>
                <div class="hidden">
                    <p class="nar">powtarzaj w każdy:</p>
                    <input id="pon" class="nar" type="checkbox"> Pon
                    <input id="wt" class="nar" type="checkbox"> Wt
                    <input id="sr" class="nar" type="checkbox"> Śr
                    <input id="cz" class="nar" type="checkbox"> Cz
                    <input id="pt" class="nar" type="checkbox"> Pt
                    <input id="sb" class="nar" type="checkbox"> Sb<br>
                    <p id="sht" class="nar">(przez 3 miesiące)<p>
                </div><br>
                <div>
                    <button id="add" value="" onclick="addDate(this.value)" class="nar btn">dodaj termin</button>
                </div>
            </div>
            
        </div>
        
    
    
COiN;
    
}
    
$content_x .= '<div id="bin" class="row"><br><br><br><br><br><br></div>';

} else {
    header('Location:  http:login.php');
    
}
//process templates
require_once 'templates/home.php';
?>