<?php
require_once 'include/sessionhandler.php';
require_once 'include/settings.php';
//Define $place_x for use in templates
//home.php -> header.php
$place_x = "help page";

//generate content



$content_x = <<<Content
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <h1>Zakres usług</h1>
                <p>Oferujemy naszym pacjentom szeroki zakres profesjonalnych usług dentystycznych oraz diagnostykę ortodontyczną. Zapraszamy do zapoznania się z naszą ofertą, a w przypadku wszelkich dodatkowych pytań, zachęcamy do kontaktu z Rejestracją.</p>
                <table class="table">
                <tr><th>Usługa</th><th>cena</th></tr>
                <tr><td>Pierwsza wizyta - przegląd</td><td>75,00 zł</td></tr>
                <tr><td>Wizyta kontrolna (kolejna)</td><td>80,00 zł</td></tr>
                <tr><td>Scaling/piaskowanie</td><td>100,00 zł</td></tr>
                <tr><td>Leczenie standardowe (1 ząb)</td><td>150,00 zł</td></tr>
                <tr><td>Leczenie kanałowe (1 kanał)</td><td>200,00 zł</td></tr>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <br><br>
                <div class="polaroid">
                    <img src="img/basia.jpg" alt="costam">
                    <div class="caption">
                        <p>Uśmiech dentystki.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2>Oferta specjalistyczna</h2>
                <p>Oferujemy naszym pacjentom szeroki zakres profesjonalnych usług dentystycznych oraz diagnostykę ortodontyczną. Zapraszamy do zapoznania się z naszą ofertą, a w przypadku wszelkich dodatkowych pytań, zachęcamy do kontaktu z Rejestracją.</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <br><br>
                <div class="polaroid">
                    <img src="img/basia.jpg" alt="costam">
                    <div class="caption">
                        <p>Uśmiech dentystki.</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <br><br><br><table class="table">
                <tr><th>Usługa</th><th>cena</th></tr>
                <tr><td>Pierwsza wizyta - przegląd</td><td>75,00 zł</td></tr>
                <tr><td>Wizyta kontrolna (kolejna)</td><td>80,00 zł</td></tr>
                <tr><td>Scaling/piaskowanie</td><td>100,00 zł</td></tr>
                <tr><td>Leczenie standardowe (1 ząb)</td><td>150,00 zł</td></tr>
                <tr><td>Leczenie kanałowe (1 kanał)</td><td>200,00 zł</td></tr>
                </table>
            </div>
        </div>
    </div> 
Content;

//process templates
require_once 'templates/home.php';
?>