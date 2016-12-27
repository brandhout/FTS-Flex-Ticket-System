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
session_start();
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();

echo '<!DOCTYPE html>
      <html>
      <body>
      <h1> Dasboard </h1>
      ';
if(isset($_SESSION['gebruikersNaam'])) {
    echo "Welkom" . "  " . ($_SESSION['gebruikersNaam']) . "</br>";
    }  else {
    header('Location: acties/inloggen.php'); 
}   

    // Maak HTML tabel!
               
        $ticketQuery ="SELECT * FROM ticket;";
            $ticketUitkomst = $connectie->query($ticketQuery);

        echo '
                    <h3> Openstaande tickets: </h3>

                    <table align="left" cellspacing="5" cellpadding="8">
                    <td align="left"><strong>TicketID</strong></td>
                    <td align="left"><strong>trefwoorden</strong></td>
                    <td align="left"><strong>Klantnaam</strong></td>
                    <td align="left"><strong>Lijn</strong></td>
                    <td align="left"><strong>Accountnummer</strong></td>
                    <td align="left"><strong>Opgelosd</strong></td></tr>
                    
            ';
        		
        echo "Aantal tickets :".$ticketUitkomst->num_rows. "<br>";
			
	while($ticket = $ticketUitkomst->fetch_assoc()){
                                                        
            $klantId = $ticket['klantId'];
                $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";
                    $klantUitkomst = $connectie->query($klantQuery);
                         
            if(!$klant = $klantUitkomst->fetch_assoc()){
                echo "Klant query mislukt..." . mysqli_error($connectie);
            }
            if($ticket['oplossingId'] === "0") {
                echo '<tr><td align=left"><a href=acties/leesTicket.php?ticket='. $ticket['ticketId'] .' >' .
                $ticket['ticketId'] . '</td><td align="left"></a>' . 
                $ticket['trefwoorden'] . '</td><td align="left"></a>' .
                $klant['klantAchternaam'] . '</td><td align="left"></a>' .
                $ticket['lijnNr'] . '</td><td align="left"></a>' .
                $ticket['fstAccountNr'] . '</td><td align="left"></a>
                <strong>Nee</strong> </td><td align="left"></a>';
            echo '</tr>';                            
        }}
	echo "</table>";

?>

</body>
</html>
