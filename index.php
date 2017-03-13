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


$gebruiker = $_SESSION["gebruiker"];

$achternaam = leesAccountAchterNaam($gebruiker->getAccountNr());

?>

<!DOCTYPE html>
    <html>
    <head>
        <title>Flex Ticket System</title>
        <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
        <style>
            body{
                background-image:url("back.jpg");
            }
        
        </style>
    </head>
    <body>
        <div class="container w3-container w3-sand" style="text-align:center;">
        <h2>Welkom, <?php echo $achternaam?> </h2>
        <div id="insert"></div>
    </body>
        <script>
            function loadInsert(){
                $("#insert").load("inc/indexAjax.php");
                return true;
            }
            
            loadInsert();
            
            setInterval(function(){
                loadInsert()
            } , 3000);
            
        </script>        
    
    </html>