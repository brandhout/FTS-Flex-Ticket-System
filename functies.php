<?php

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
        
} else {
    return $connectie;
}}

function mysqldatum(){
$datum = date("Y-m-d H:i:s");
//Levert een datum aan die in het SQL variabeltype 'DATE' past.
return $datum;    
}
