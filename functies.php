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

function updateLijn($vanLijn,$naarLijn,$ticketId,$accountNr){
    $connectie = verbinddatabase();
    if($vanLijn < $naarLijn){
        $doorstuurUpQuery = "INSERT INTO doorsturing (doorstuurId, vanLijn, naarLijn,
            opmerking, accountNr,
            datum, ticketId) VALUES (NULL,'$vanLijn', '$naarLijn',''
            ,'$accountNr', CURRENT_DATE,
            '$ticketId')";
        $ticketLijnUpQuery = "UPDATE ticket SET lijnNr='$naarLijn' WHERE ticketId= $ticketId";
            
        if(!$connectie->query($doorstuurUpQuery)){
            echo "Lijnup query mislukt..." . mysqli_error($connectie);
        }
            
        if(!$connectie->query($ticketLijnUpQuery)){
            echo "Lijnup ticket query mislukt..." . mysqli_error($connectie);
        }
    }
}