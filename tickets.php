<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'header.php';
    include_once 'functies.php';
    $connectie = verbinddatabase();
    
    // Maak HTML tabel!
               
        $ticketQuery ="SELECT * FROM ticket;";
            $ticketUitkomst = $connectie->query($ticketQuery);

        echo '
            <!DOCTYPE html>
            <html>
                <body>
                    <form action="">
                            <p> Geef weer: </p>
                           <button name="welkTicket" type="submit" value="alle">Alle</button>
                           <button name="welkTicket" type="submit" value="open">Open</button>
                           <button name="welkTicket" type="submit" value="gesloten">Gesloten</button>
                    </form> 


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
            $opgelost = "Nee";
                                                        
            $klantId = $ticket['klantId'];
                $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";
                    $klantUitkomst = $connectie->query($klantQuery);
                         
            if(!$klant = $klantUitkomst->fetch_assoc()){
                echo "Klant query mislukt..." . mysqli_error($connectie);
            }
            
            $ticketId = $ticket['ticketId'];
            $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
                $oplossingUitkomst = $connectie->query($oplossingQuery);

            
            //Nieuw oplossing script
            while($oplossing = $oplossingUitkomst->fetch_assoc()){
                if($oplossing['definitief'] === "1"){
                    $opgelost = "Ja";
                }
            }
                                                        
            echo '<tr><td align=left"><a href=acties/leesTicket.php?ticket='. $ticket['ticketId'] .' >' .
                $ticket['ticketId'] . '</td><td align="left"></a>' . 
                $ticket['trefwoorden'] . '</td><td align="left"></a>' .
                $klant['klantAchternaam'] . '</td><td align="left"></a>' .
                $ticket['lijnNr'] . '</td><td align="left"></a>' .
                $ticket['fstAccountNr'] . '</td><td align="left"></a>' .
                $opgelost . '</td><td align="left"></a>';
            echo '</tr>';
	}
   
	
	echo "</table>";
    
 ?>

 
   
    
  </body>
</html>
