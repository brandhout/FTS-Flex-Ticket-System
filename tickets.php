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
 * - Meer data toevoegen  (aanmaakdatum etc. etc.)
 * - Opmaak
 */
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'header.php';
    include_once 'functies.php';
    $connectie = verbinddatabase();
  
    $alleenOpen = FALSE;
    $alleenGesloten = FALSE;
    
    // Maak HTML tabel!
                          
        if(isset($_GET['welkTicket'])){   
            
            if($_GET['welkTicket'] === "open"){
                $alleenOpen = TRUE;
            }       
            
            if($_GET['welkTicket'] === "gesloten"){
                $alleenGesloten = TRUE;
            }       
        }
        
        if(isset($_GET['kipquery'])){
            $searchq = $connectie->real_escape_string($_GET['kipquery']);
            $zoekTicketQuery = "SELECT * FROM ticket WHERE probleem LIKE '%$searchq%';";           
            if(!$ticketUitkomst = $connectie->query($zoekTicketQuery)){
                echo $connectie->error;
            }
        } else {
            $ticketQuery ="SELECT * FROM ticket;";
            $ticketUitkomst = $connectie->query($ticketQuery);
        }

        echo '
            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Refresh" content="15">
                    <title> FTS Ticketlijst </title>
                </head>
                <body>
                
                    <form action="">
                            <p> Geef weer: </p>
                           <button class="sub2" name="welkTicket" type="submit" value="alle">Alle</button>
                           <button class="sub2" name="welkTicket" type="submit" value="open">Open</button>
                           <button class="sub2" name="welkTicket" type="submit" value="gesloten">Gesloten</button>
                    </form>
                    <div class="containert1">
                    <form action="">
                    <p> Zoek in beschrijving </p>
                    <input type="text" name="kipquery" required>
                    <button name="submit" type="submit">Zoek</button><br>
                    


                    <table align="left" border="solid red">
                    <td align="left"><strong>TicketID</strong></td>
                    <td align="left"><strong>trefwoorden</strong></td>
                    <td align="left"><strong>Klantnaam</strong></td>
                    <td align="left"><strong>Lijn</strong></td>
                    <td align="left"><strong>Aannemer</strong></td>
                    <td align="left"><strong>Aangewezen</strong></td>
                    <td align="left"><strong>Streefdatum</strong></td>
                    <td align="left"><strong>Prioriteit</strong></td>
                    <td align="left"><strong>Status</strong></td></tr>
                    
            ';
        		
        echo "<br><h3>Aantal tickets :<strong>".$ticketUitkomst->num_rows. "</strong><br><br></h3>";
			
	while($ticket = $ticketUitkomst->fetch_assoc()){
            $status = "Open";
            $opgelost = FALSE;
            $uitzondering = FALSE;
                                           
            $klantId = $ticket['klantId'];
                $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";
                    $klantUitkomst = $connectie->query($klantQuery);
                         
            if(!$klant = $klantUitkomst->fetch_assoc()){
                echo "Klant query mislukt..." . mysqli_error($connectie);
            }
            
            if($ticket['aangewAccountNr'] > 0){
                $aangewAccountNr = $ticket['aangewAccountNr'];
            } else {
                $aangewAccountNr = $ticket['fstAccountNr'];
            }
            
            $ticketId = $ticket['ticketId'];
            $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
                $oplossingUitkomst = $connectie->query($oplossingQuery);

            
            //Nieuw oplossing script
            while($oplossing = $oplossingUitkomst->fetch_assoc()){
                if($oplossing['definitief'] === "1"){
                    $status = "Gesloten";
                    $opgelost = TRUE;
                } 
            }
            
            if(overDatum($ticket['streefdatum'])){
                $status = '<p style="color:red">
                    Te laat,';
                if (!$opgelost){
                $status .= '<br>Open</p>';
                } else {
                    $status .= '<br>Gesloten</p>';
                }
            }
            
            if($opgelost === TRUE && $alleenOpen === TRUE){
                $uitzondering = TRUE;
            }
            
            if($opgelost === FALSE && $alleenGesloten === TRUE){
                $uitzondering = TRUE;
            }
                
            if(!$uitzondering){                                            
                echo '<tr><td align="left"><a href=acties/leesTicket.php?ticket='. $ticket['ticketId'] .' >' .
                    $ticket['ticketId'] . '</td><td align="left"></a>' . 
                    $ticket['trefwoorden'] . '</td><td align="left">' .
                    $klant['klantAchternaam'] . '</td><td align="left">' .
                    $ticket['lijnNr'] . '</td><td align="left">' .
                    leesAccountAchterNaam($ticket['fstAccountNr']) . '</td><td align="left">' .
                    leesAccountAchterNaam($aangewAccountNr) . '</td><td align="left">' .
                    datumOmzet($ticket['streefdatum']) . '</td><td align="left">' .
                    prioriteitOmzet($ticket['prioriteit']) . '</td><td align="left">' .
                    $status . '</td>';
                echo '</tr>';
            }
	}
   
	
	echo "</table>";
        echo "</div>";
 ?>

 
   
  </body>
</html>
