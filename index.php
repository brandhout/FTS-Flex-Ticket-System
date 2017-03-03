<?php
// laat foutmeldingen zien

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

echo '<!DOCTYPE html>
      <html>
      <head>
          <meta http-equiv="Refresh" content="60">
          <title>Flex Ticket System</title>
      </head>
      <body><div class="containertabel">
      ';
if($ingelogd) {//als er is ingelogd 
    $achterNaam = leesAccountAchterNaam($gebruiker->getAccountNr());//zet achternaam in een var
    echo "Welkom," . "  " . ($achterNaam) . "!</br>";//laat achternaam zien
        if($gebruiker->getAdmin()){//als gebruiker admin is laat ie wat zien.
            echo 'U bent een administrator.';
            $lijnNr = "*"; 
        } else {//als geen admin dan laat ie zien welk lijn mederwerker diegene is
        echo "
        U bent een ".$_SESSION['lijnNr']."e lijns medewerker,
        en de aannemer van .. tickets.
        ";
        $lijnNr = $_SESSION["lijnNr"];
        }
    }
 echo '<hr>';
     infoBar(); //Include de functies.
     echo'<br>';
 
    // Maak HTML tabel!
    // query voor het selecteren van alles uit tabel ticket           
        $ticketQuery ="SELECT * FROM ticket;";
            $ticketUitkomst = $connectie->query($ticketQuery);
            
        echo '
                <p> Openstaande tickets lijn '.$lijnNr.': </p>
<div class="centerform">
                <table id="example" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                <td><strong>TicketID</strong></td>
                <td><strong>trefwoorden</strong></td>
                <td><strong>Klantnaam</strong></td>
                <td><strong>Lijn</strong></td>
                <td><strong>Aannemer</strong></td>
                <td><strong>Aangewezen</strong></td>
                <td><strong>Prioriteit</strong></td>
                <td><strong>Streefdatum</strong></td>
                <td><strong>Resterende tijd</strong></td>
                </tr>
                </thead>
                <tfoot>
                <tr>
                <td><strong>TicketID</strong></td>
                <td><strong>trefwoorden</strong></td>
                <td><strong>Klantnaam</strong></td>
                <td><strong>Lijn</strong></td>
                <td><strong>Aannemer</strong></td>
                <td><strong>Aangewezen</strong></td>
                <td><strong>Prioriteit</strong></td>
                <td><strong>Streefdatum</strong></td>
                <td><strong>Resterende tijd</strong></td>
                </tr>
                </tfoot><tbody>
            ';
        // Moet functie gescreven worden voor streefdatum! Met date(), kan niet direct ingelezen worden.
	
        ////queries
	while($ticket = $ticketUitkomst->fetch_assoc()){
                                                        
            $klantId = $ticket['klantId'];//klant id is gelijk aan var ticket klantid
                $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";// haal achternaam op van klant maar klant id tabel moet gelijk zijn aan klantid var
                    $klantUitkomst = $connectie->query($klantQuery);//haalt gegevens op via connectie
                         
            if(!$klant = $klantUitkomst->fetch_assoc()){//als het niet lukt om gegevens te verzamelen laat dan een bericht zien
                echo "Klant query mislukt, een of meerdere tickets zijn corrupt<br>" . mysqli_error($connectie);
            }
            //anders maakt ie een tabel aan
            $ticketId = $ticket['ticketId'];           
            $ta = '</a></td><td>';
            $td = '</td><td>';
            $uitzondering = FALSE;
            
            $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";//query selecteer alles van oplossingen maar ticket moet gelijk aan var ticket id zijn
                $oplossingUitkomst = $connectie->query($oplossingQuery);// haal alles op via connectie
                
            while($oplossing = $oplossingUitkomst->fetch_assoc()){//while loop var is uitkomst van query
                if($oplossing['definitief'] === "1"){//als oplossing 1 is dan wordt uitzondering true
                    $uitzondering = TRUE;
                                        
            }}
            
            if($ticket['aangewAccountNr'] > 0){//als ticket groter is dan null dan wordt aangeaccountnr of aangeaccountnr of fstaccountnr
                $aangewAccountNr = $ticket['aangewAccountNr'];
            } else {
                $aangewAccountNr = $ticket['fstAccountNr'];
            }
            
            if($_SESSION['isAdmin'] != "1"){// als sessie admin niet nummer een is dan en
                if($ticket['lijnNr'] != $_SESSION['lijnNr']){//als ticket lijnr niet gelijk is aan session lijnnummer
                $uitzondering = TRUE;//dan wordt var uitzondering true
                }
            }//en laat  een tabel zien
            echo '';                
            if($uitzondering === FALSE){//kijkt of uitzondering vals is
                $streefdatum = new DateTime($ticket['streefdatum']);//hier wordt datum van db opgehaald en gaat hij van type date msqli naar type date php
                echo '<tr><td><a href=acties/leesTicket.php?ticket='. $ticket['ticketId'] .' >' .//zet nog meer var in tabel
                $ticket['ticketId'] . $ta . 
                $ticket['trefwoorden'] . $td .
                $klant['klantAchternaam'] . $td .
                $ticket['lijnNr'] . $td .
                leesAccountAchterNaam($ticket['fstAccountNr']) . $td .
                leesAccountAchterNaam($aangewAccountNr) . $td .
                prioriteitOmzet($ticket['prioriteit']) . $td .
                $streefdatum->format('d-m-Y') . $td;

//
//
//  ik weet het niet
//
//                
                $interval = $datum->diff($streefdatum);
                if(strpos($interval->format('%R%a dagen'),'-') !== FALSE ){
                    echo '
                        <p style="color:red">
                        '.$interval->format('%R%a dagen').'
                        </p> 
                         ';  
                } else {
                    echo '
                        <p style="color:green">
                        '.$interval->format('%R%a dagen').'
                        </p>   
                    ';
                    }

                echo '</td></tr>';                                      
            }
        }
                   
            
        
	echo "</tbody></table></div></div><hr>";

?>


