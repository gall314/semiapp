//define 


var today = new Date();
var mPin = [];
var monthsPl = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];
var globalarray;


//check number of days in month
function daysInMonth(month,year) {
    return new Date(year, month, 0).getDate();
}
//populate the calendar's headline
if ( document.getElementById("cMonth") != null) {
    document.getElementById("cMonth").innerHTML = today.getFullYear() + " " + monthsPl[today.getMonth()];
}

//generate list of days 
function mfNext(pin) {
    today.setMonth(today.getMonth() + (pin));
    var ss = daysInMonth((today.getMonth()+ (1)), today.getFullYear());
    if(document.getElementById("cMonth") != null){
        document.getElementById("cMonth").innerHTML = today.getFullYear() + " " +  monthsPl[today.getMonth()];
    
        var dpos = today.getDay(today.setDate(1));
        document.getElementById("dz").innerHTML = "";
        if (dpos == 0) {
            for (d = 0; d < 6; d++) {
                document.getElementById("dz").innerHTML += "<li></li>";
            }
        } else {
            for (d = 1; d < dpos; d++) {
                document.getElementById("dz").innerHTML += "<li></li>";
            }
        }
        for (i = 1; i <= ss; i++) {
            document.getElementById("dz").innerHTML += "<li id='"+i+"' class='wiw'   onclick='viewDates(this.textContent,"+today.getMonth()+","+today.getFullYear()+", this.id"+")'>"+i+"</li>";
        }
        if(document.getElementById("add") != null) {
            document.getElementById("add").setAttribute("year", today.getFullYear());
            document.getElementById("add").setAttribute("month", today.getMonth());
        }
    }
}

//initialise the calendar for current month
mfNext(0);



//F grab all docs id first and last names
function getAllDocs(){
    
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("selectd") != null){
                    var myhtmlid = document.getElementById("selectd");
                    myhtmlid.innerHTML = this.responseText;
                }
                
            }
        };

        xmlhttp.open("GET", "class/getAllDocs.php", true);
        xmlhttp.send();
    
    //document.getElementById("dd"+aid).innerHTML = "zarezerwowane";
}

getAllDocs();
//display appointment dates on click
//F display booked appointments 
function showDate(aid){
    
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(document.getElementById("booked") != null){
                    document.getElementById("booked").innerHTML = this.responseText;
                }
            }
        };

        xmlhttp.open("GET", "class/showDate.php", true);
        xmlhttp.send();
    
    //document.getElementById("dd"+aid).innerHTML = "zarezerwowane";
}
showDate();

//F display available dates

function viewDates(myday,mymo, myye, thisid){ 
    mPin = [myday, mymo, myye];
    
    mfNext(0);   
//    var theDate = new Date();
//    theDate.setFullYear(2020, 0, myday);
    
    if (myday >= 1 && myday <=31) {
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result").innerHTML = this.responseText;
                if (document.getElementById("add") != null){
                    document.getElementById("add").setAttribute("value", thisid);
                }
            }
        };
        xmlhttp.open("GET", "class/getMonth.php?d=" + myday + "&m=" +mymo + "&y=" +myye + "&c=" + 0, true);
        xmlhttp.send();
    }
    var mydayclean = document.getElementById(thisid).textContent;
    document.getElementById(thisid).innerHTML = '<span class="active">'+mydayclean+'</span>';
    showDate();
}

//F display appointment dates on doctor change
function refreshDates(did){
        
        alert(mPin[2]+" "+ mPin[1]+" "+mPin[0]+" "+did);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            document.getElementById("result").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "class/getMonth.php?d=" + mPin[0] + "&m=" +mPin[1] + "&y=" +mPin[2] + "&c=" + did, true);
    xmlhttp.send();
        
    
}

//F book an appointment 
function bookDate(aid){
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText;
            document.getElementById("booked").innerHTML = showDate();
        }
    };
    xmlhttp.open("GET", "class/bookDate.php?c=" + aid, true);
    xmlhttp.send();
    
    document.getElementById("dd"+aid).innerHTML = "zarezerwowane";
    
}
//F cancel an appointment 
function cancelDate(aid){
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            if(this.responseText == 1){
                    document.getElementById("cann").innerHTML = "<div class='alert alert-danger'>Niestety nie można anulować tej wizyty ponieważ termin minął lub jest mniej niż 2 dni przed terminem!</div>";
            } else {
                document.getElementById("cann").innerHTML = "";
                document.getElementById("booked").innerHTML = this.responseText;
            }
            showDate();
        }
    };
    xmlhttp.open("GET", "class/cancelDate.php?c=" + aid, true);
    xmlhttp.send();
    
    
    
}
//F add office hours 
function addDate(day, month, year, p, w, s, c, t, b){
    
    if (day>=1 && day<=31){
        document.getElementById("alert").innerHTML = "";
        document.getElementById("alert").removeAttribute("class");
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("alert").innerHTML = this.responseText;
                                
            }
        };
        xmlhttp.open("GET", "class/addDate.php?d=" + day + "&m=" + document.getElementById("add").getAttribute('month') + "&y=" + document.getElementById("add").getAttribute('year') + "&id=" + document.getElementById("selectd").value + "&po=" + document.getElementById("pon").checked + "&wt=" + document.getElementById("wt").checked + "&sr=" + document.getElementById("sr").checked + "&cz=" + document.getElementById("cz").checked + "&pt=" + document.getElementById("pt").checked + "&sb=" + document.getElementById("sb").checked + "&t1=" + document.getElementById("dutytime").value + "&t2=" + document.getElementById("dutytime2").value, true);
        xmlhttp.send();
        
    } else {
        
        document.getElementById("alert").innerHTML = "nie podano daty! Podaj datę na kalendarzu powyżej.";
        document.getElementById("alert").setAttribute("class", "alert alert-danger");
        
    }
    
}
//F increase the time by a step 
function stepUp(d){
    if(d == 1){
        document.getElementById("dutytime").stepUp(30);
    } 
    if(d === 2) {
        document.getElementById("dutytime2").stepUp(30);
    }
}
//F decrease the time by a step 
function stepDown(d){
    if(d == 1){
        document.getElementById("dutytime").stepDown(30);
    }
    if(d == 2){
        document.getElementById("dutytime2").stepDown(30);
    }
    
}


//F remove a date from list 
function removeDate(aid){
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("result").innerHTML = this.responseText;
            //alert(this.responseText);
        }
    };
    xmlhttp.open("GET", "class/removeDate.php?c=" + aid, true);
    xmlhttp.send();
    
    //bookDate(aid);
}
//F send doc id to global 
function changePatient(aid){
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (document.getElementById("cp"+aid) !== null){
                document.getElementById("cp"+aid).parentElement.innerHTML = this.responseText;
            }
            //alert(this.responseText);
        }
    };
    xmlhttp.open("GET", "class/changePatient.php?c=" + aid, true);
    xmlhttp.send();
    
}
//F update patient
function commPatient(aid, id){
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             showDate();
        }
    };
    xmlhttp.open("GET", "class/commPatient.php?c=" + aid + "&a=" + id, true);
    xmlhttp.send();
}
//F turn notifications off
function toggleSpam(aid){
 
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (document.getElementById("spa") != null){
                    if(this.responseText == 0 ){
                        var spa = document.getElementById("spa");
                        spa.innerHTML = "<i class='fa fa-toggle-off fa-2x' aria-hidden='true'></i>";
                        spa.setAttribute("style", "color: #d613a2;");
                    } 
                    if(this.responseText == 1 ){
                        
                        var spa = document.getElementById("spa");
                        spa.innerHTML = "<i class='fa fa-toggle-on fa-2x' aria-hidden='true'></i>";
                        spa.setAttribute("style", "color: #61c70a;");
                        
                    }
                }
            }
        };
        xmlhttp.open("GET", "class/toggleSpam.php?c=" + aid, true);
        xmlhttp.send();
    
}
toggleSpam(1);

function hamb(){
    
    document.getElementById("hamb").innerHTML ="Menu niedostępne";
    
}
//F change doctor in appointment
function changeDoctor(aid){
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (document.getElementById("cd"+aid) !== null){
                
                document.getElementById("cd"+aid).parentElement.innerHTML = this.responseText;
            }
            
        }
    };
    xmlhttp.open("GET", "class/changeDoctor.php?c=" + aid, true);
    xmlhttp.send();
    
}
//F update patient
function commDoctor(aid, id){
    //alert(id);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             showDate();
        }
    };
    xmlhttp.open("GET", "class/commDoctor.php?c=" + aid + "&a=" + id, true);
    xmlhttp.send();
}
