<?php

// Hier komen de globale functies, die in principe op elke pagina geimporteerd worden
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
$conn = new mysqli($servernaam, $username, $password, $database);    
    
// Check connection
if ($conn->connect_error) {
    die("Verbindingsfout!: " . $conn->connect_error);
} else{
return true;
}}

