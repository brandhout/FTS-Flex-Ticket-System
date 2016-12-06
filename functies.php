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