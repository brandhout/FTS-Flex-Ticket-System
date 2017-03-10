<?php
/* 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * TODO:
 * - Streefdatum weergeven
 * - Meer data toevoegen
 * - Opmaak
 */

//functie voor het kijken of er iemand is ingelogd
require_once 'classes/gebruiker.php';
session_start();//sessie starten
if(!isset($_SESSION['gebruikersNaam'])) { //als sessie niet is ingelogd dan word header false en ga je naar het inlogpagina.
    $ingelogd = FALSE;
    header('Location: acties/inloggen.php');
    die();
} else {
    $ingelogd = TRUE;// anders is ingelogd true
}

require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();//aanroepen van een functie connectie met database

$datum = new DateTime();

$gebruiker = $_SESSION["gebruiker"];

$achternaam = leesAccountAchterNaam($gebruiker->getAccountNr());

?>

<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Refresh" content="60">
        <title>Flex Ticket System</title>
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
        <style>
            body{
                background-image:url("back.jpg");
            }
        
        </style>   

    </head>
    <body>
    <div class="container w3-container w3-dark-grey" style="text-align:center;">
    
        <h2>Welkom, <?php echo $achternaam?> </h2>
        <div class="nieuwDataBar w3-teal w3-hover-shadow w3-padding-64 w3-center">
            <i class="fa fa-pencil-square-o fa-5x"></i>
            <p> Openstaande Tickets </p>
            <h1> X </h1>
        </div>
        
        <div class="nieuwDataBar w3-green w3-hover-shadow w3-padding-64 w3-center">
            <i class="fa fa-ticket fa-5x"></i>
            <p> Aantal Tickets </p>
            <h1> X </h1>
        </div>

        <div class="nieuwDataBar w3-indigo w3-hover-shadow w3-padding-64 w3-center">
            <i class="fa fa-times fa-5x"></i>
            <p> Gesloten Tickets </p>
            <h1> X </h1>
        </div>
        <h3 style="text-align:center;"> Openstaande Tickets: </h3>
        
        <div class="ticketCard w3-card-8 w3-green w3-hover-shadow w3-center">
            <div class="w3-container w3-center">
                <h3>Ticket</h3>
            </div>
            <p>
            <i class="fa fa-ticket fa-5x"></i><strong>2</strong><p>
            <p> 
            Trefw: windows,office
            <hr>
            Info: 99 
            Info: 99
            <div class="w3-section">
                <button class="w3-button w3-grey">Openen</button>
            </div>
            
            </p></div>
        <div class="ticketCard w3-card-8 w3-green w3-hover-shadow w3-center">
            <div class="w3-container w3-center">
                <h3>Ticket</h3>
            </div>
            <p>
            <i class="fa fa-ticket fa-5x"></i><strong>2</strong><p>
            <p> 
            Trefw: windows,office
            <hr>
            Info: 99 
            Info: 99
            <div class="w3-section">
                <button class="w3-button w3-grey">Openen</button>
            </div>
            
            </p></div>


        
    </div>
        