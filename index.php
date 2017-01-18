<?php
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
session_start();
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();

$datum = new DateTime();

echo '<!DOCTYPE html>
      <html>
      <head>
          <meta http-equiv="Refresh" content="15">
          <title>Flex Ticket System</title>
      </head>
      <body>
      <h1> Dasboard </h1>
      ';
if(isset($_SESSION['gebruikersNaam'])) {
    $achterNaam = leesAccountAchterNaam($_SESSION['accountNr']);
    echo "Welkom," . "  " . ($achterNaam) . "!</br>";
        if($_SESSION['isAdmin'] === "1"){
            echo 'U bent een administrator.';
            $lijnNr = "*";
        } else {
        echo "
        U bent een ".$_SESSION['lijnNr']."e lijns medewerker,
        en de aannemer van .. tickets.
        ";
        $lijnNr = $_SESSION["lijnNr"];
        }
    } else {
    header('Location: acties/inloggen.php'); 
}   

    // Maak HTML tabel!
               
        $ticketQuery ="SELECT * FROM ticket;";
            $ticketUitkomst = $connectie->query($ticketQuery);
            
        echo '<div class="containert1">
                <h3> Openstaande tickets lijn '.$lijnNr.': </h3>

                <table align="left" cellspacing="5" cellpadding="8">
                <td align="left"><strong>TicketID</strong></td>
                <td align="left"><strong>trefwoorden</strong></td>
                <td align="left"><strong>Klantnaam</strong></td>
                <td align="left"><strong>Lijn</strong></td>
                <td align="left"><strong>Aannemer</strong></td>
                <td align="left"><strong>Aangewezen</strong></td>
                <td align="left"><strong>Prioriteit</strong></td>
                <td align="left"><strong>Streefdatum</strong></td>
                <td align="left"><strong>Resterende tijd</strong></td></tr>

            ';
        // Moet functie gescreven worden voor streefdatum! Met date(), kan niet direct ingelezen worden.
			
	while($ticket = $ticketUitkomst->fetch_assoc()){
                                                        
            $klantId = $ticket['klantId'];
                $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";
                    $klantUitkomst = $connectie->query($klantQuery);
                         
            if(!$klant = $klantUitkomst->fetch_assoc()){
                echo "Klant query mislukt, een of meerdere tickets zijn corrupt<br>" . mysqli_error($connectie);
            }
            
            $ticketId = $ticket['ticketId'];           
            $td = '</td><td align="left"></a>';
            $uitzondering = FALSE;
            
            $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
                $oplossingUitkomst = $connectie->query($oplossingQuery);
                
            while($oplossing = $oplossingUitkomst->fetch_assoc()){
                if($oplossing['definitief'] === "1"){
                    $uitzondering = TRUE;
                                        
            }}
            
            if($ticket['aangewAccountNr'] > 0){
                $aangewAccountNr = $ticket['aangewAccountNr'];
            } else {
                $aangewAccountNr = $ticket['fstAccountNr'];
            }
            
            if($_SESSION['isAdmin'] != "1"){
                if($ticket['lijnNr'] != $_SESSION['lijnNr']){
                $uitzondering = TRUE;
                }
            }
                            
            if($uitzondering === FALSE){
                $streefdatum = new DateTime($ticket['streefdatum']);
                echo '<tr><td align=left><a href=acties/leesTicket.php?ticket='. $ticket['ticketId'] .' >' .
                $ticket['ticketId'] . $td . 
                $ticket['trefwoorden'] . $td .
                $klant['klantAchternaam'] . $td .
                $ticket['lijnNr'] . $td .
                leesAccountAchterNaam($ticket['fstAccountNr']) . $td .
                leesAccountAchterNaam($aangewAccountNr) . $td .
                prioriteitOmzet($ticket['prioriteit']) . $td .
                $streefdatum->format('d-m-Y') . $td;
                
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

                echo '</tr>';                                      
            }
        }
                   
            
        
	echo "</table></div>";

?>


