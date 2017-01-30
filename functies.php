<?php
date_default_timezone_set('Europe/Amsterdam');
// Hier komen de globale functies, die in principe op elke pagina geimporteerd worden.
function filtermail($email) {
if(preg_match("~([a-zA-Z0-9!#$%&amp;'*+-/=?^_`{|}~])@([a-zA-Z0-9-]).([a-zA-Z0-9]{2,4})~",$email)) {
	//Actie bij geldige mail
        return true;
        } else{ 
        //Als de email ongeldig is:
        $email = "e-mail ongeldig"; //Maak de variabele leeg en zet er "email ongeldig" in
        return false;
}}

function verbinddatabase() {
$servernaam = "localhost";
$username = "root";
$password = "Admin01!";
$database = "ftsPrimair";
    
// Maak connectie
$connectie = new mysqli($servernaam, $username, $password, $database);    
    
// Check connection
if ($connectie->connect_error) {
    die("Verbindingsfout!: " . $connectie->connect_error);
    echo "Pas op! Geen databaseconnectie!";
        
} else {
    return $connectie;
}}

function mysqldatum(){
$datum = date("Y-m-d H:i:s");
//Levert een datum aan die in het SQL variabeltype 'DATE' past.
return $datum;    
}

function updateNogBellen($in,$ticketId){
    $connectie = verbinddatabase();
    if($in === "0"){
        $nogBellenQuery = "UPDATE ticket SET nogBellen=0 WHERE ticketId = $ticketId";
    }
    if($in === "1"){
        $nogBellenQuery = "UPDATE ticket SET nogBellen=1 WHERE ticketId = $ticketId";
    }
    if(isset($nogBellenQuery)){
        if(!$connectie->query($nogBellenQuery)){
            echo "nogBellen query mislukt..." . $connectie->error();
            return FALSE;
        }
    }
}

function updateLijn($vanLijn,$naarLijn,$opmerking,$ticketId,$accountNr){
    $connectie = verbinddatabase();
    
    $doorstuurUpQuery = "INSERT INTO doorsturing (doorstuurId, vanLijn, naarLijn,
        opmerking, accountNr,
        datum, ticketId) VALUES (NULL,'$vanLijn', '$naarLijn','$opmerking'
        ,'$accountNr', CURRENT_DATE,
        '$ticketId')";
    $ticketLijnUpQuery = "UPDATE ticket SET lijnNr='$naarLijn' WHERE ticketId= $ticketId";
            
    if(!$connectie->query($doorstuurUpQuery)){
        echo "Lijnup query mislukt..." . mysqli_error($connectie);
    }
            
    if(!$connectie->query($ticketLijnUpQuery)){
        echo "Lijnup ticket query mislukt..." . mysqli_error($connectie);
    }
    header("Location: ../index.php");
    
}

function leesAccountAchterNaam($accountNr){
    $connectie = verbinddatabase();
    
    $leesAccountQuery = "SELECT achterNaam FROM account WHERE accountNr = '$accountNr'";
        $leesAccountUitkomst = $connectie->query($leesAccountQuery);
    
   $account = $leesAccountUitkomst->fetch_assoc();
   return $account['achterNaam'];
}

function sqlbuster($in){
    $connectie = verbinddatabase();
    $uit = mysqli_real_escape_string($connectie, stripcslashes(trim($in)));
    return $uit;
}

function checkDefinitief($ticketId){
    $connectie = verbinddatabase();    
    $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
    $oplossingUitkomst = $connectie->query($oplossingQuery);
    while($oplossing = $oplossingUitkomst->fetch_assoc()){
        if($oplossing['definitief'] === "1"){
            return TRUE;
        }
    }
}

function datumOmzet($datum){
    $DateTime = new DateTime($datum);
    return $DateTime->format('d-m-Y');
}

function overDatum($eindDatum){
    $datum = date("Y-m-d");
    if(strtotime($datum) > strtotime($eindDatum)){
            return TRUE;
        } else {
            return FALSE;          
        }
    
}

function leesLaptopTypeId($typeOm){
    $connectie = verbinddatabase();
    
    $typeQuery = "SELECT vVLaptopTypeId FROM veelVoorkomendeLaptopTypes WHERE vVLaptopTypeOm = '$typeOm'";
    $typeUitkomst = $connectie->query($typeQuery);
    $type = $typeUitkomst->fetch_assoc();
    
    return $type['vVLaptopTypeId'];
    
}

function prioriteitOmzet ($prioriteitINT){
    switch($prioriteitINT){
        case "1":
            return "Laag";
        case "2":
            return "Middel";
        case "3":
            return "Hoog";
    }
}

function leesBedrijfsNaam($bedrijfsId){
    $connectie = verbinddatabase();
    
    $bedrijfsQuery = "SELECT naam FROM bedrijf WHERE bedrijfsId = '$bedrijfsId'";
    $bedrijfsUitkomst = $connectie->query($bedrijfsQuery);
    $bedrijf = $bedrijfsUitkomst->fetch_assoc();
    
    return $bedrijf['naam'];
}

function leesInstantieNaam ($instantieId){
    $connectie = verbinddatabase();
    
    $instantieQuery = "SELECT instantieNaam FROM instantie WHERE instantieId = '$instantieId'";
    $instantieUitkomst = $connectie->query($instantieQuery);
    $instantie = $instantieUitkomst->fetch_assoc();
    
    return $instantie['instantieNaam'];
}

function infoBar(){
$connectie = verbinddatabase();
    
$query = $connectie->prepare("SELECT * FROM ticket");
$query->execute();
$query->store_result();
$rowsat = $query->num_rows;

$one=0;
$query1 = $connectie->prepare("SELECT * FROM oplossingen WHERE definitief = ?");
$query1->bind_param('s', $one);
$query1->execute();
$query1->store_result();
$rowsot = $query1->num_rows;

$query2 = $connectie->prepare("SELECT * FROM account");
$query2->execute();
$query2->store_result();
$rowsa = $query2->num_rows;

$zero=1;
$query3 = $connectie->prepare("SELECT * FROM oplossingen WHERE definitief = ?");
$query3->bind_param('s', $zero);
$query3->execute();
$query3->store_result();
$rowsbt = $query3->num_rows;

echo '

<html>  
<div class="container-fluid">
 <div class="row mb-3">
  ';
    switch ($_SESSION['isAdmin']) { 
                case "1": echo '     
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-success">
                        <div class="card-block bg-success">
                            <div class="rotate">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">aantal accounts</h6>
                            <h1 class="display-1">'.$rowsa.'</h1>
                        </div>
                    </div>
                </div>
                    				' ;
                break;

                case "0":
                break;

                default:
                break;
            }
echo '
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-danger">
                        <div class="card-block bg-danger">
                            <div class="rotate">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">openstaande tickets alle lijnen</h6>
                            <h1 class="display-2">'.$rowsot.'</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-info">
                        <div class="card-block bg-info">
                            <div class="rotate">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">totaal aantal tickets</h6>
                            <h1 class="display-3">'.$rowsat.'</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-warning">
                        <div class="card-block bg-warning">
                            <div class="rotate">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">gesloten tickets</h6>
                            <h1 class="display-4">'.$rowsbt.'</h1>
                        </div>
                    </div>
                </div>
            </div>   

             </div>           
</html>
';
}