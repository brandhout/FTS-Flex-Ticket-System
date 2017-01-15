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