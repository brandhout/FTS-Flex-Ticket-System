<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'header.php';
    include_once 'functies.php';
    $connectie = verbinddatabase();
    session_start();


    
    // Maak HTML tabel!
               
        $query ="SELECT klantAchterNaam FROM klant";
        $query .="SELECT fstAccountNr FROM oplossing";
        $query .="SELECT * from ticket";
        $uitkomst = mysqli_multi_query($connectie, $query);
        
         if($uitkomst) { 


        echo '<table align="left"
            <td><td align="left"><strong>TicketID</strong></td>
            <td><td align="left"><strong>trefwoorden</strong></td>
            <td><td align="left"><strong>Klantnaam</strong></td>
            <td><td align="left"><strong>Lijn</strong></td>
            <td><td align="left"><strong>Accountnummer</strong></td>
            <td><td align="left"><strong>Opgelosd</strong></td></tr>';

        while($rij = mysqli_fetch_array($uitkomst)){
            // Deze 'zolang' of 'terwijl' loop geeft een rij data, en herhaalt dit totdat er geen data
            // meer in de uitkomst zit.
            echo '<tr><td align=left">' .
                    $rij[ticketId] . '<a href="acties/leesTicket.php?ticket='.$rij[ticketId].'></td><td align="left"></a>' . 
                    $rij[trefwoorden] . '<a href="acties/leesTicket.php?ticket='.$rij[onderwerp].'></td><td align="left"></a>' .
                    $rij[klantAchterNaam] . '<a href="acties/leesTicket.php?ticket='.$rij[klantAchterNaam].'></td><td align="left"></a>' .
                    $rij[lijnNr] . '<a href="acties/leesTicket.php?ticket='.$rij[lijnNr].'></td><td align="left"></a>' .
                    $rij[fstAccountNr] . '<a href="acties/leesTicket.php?ticket='.$rij[fstAccountNr].'></td><td align="left"></a>' .
                    $rij[definitief] . '<a href="acties/leesTicket.php?ticket='.$rij[definitief].'></td><td align="left"></a>';

            echo '</tr>';
        }
        echo '</table>';    
    }
 ?>

 <!DOCTYPE html>
 <html>
  <body>
      
      <h2> Gevanceerd sorteren </h2>
      <form name="filterfunctie" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          Naam <br>
          <input type="text" name="Titel" disabled><br>
          Beschrijving <br>
          <input type="text" name="Beschrijving" disabled><br>
          <input type="submit" name="zoeken" value="zoeken" disabled><br>    
      </form>
      
      <h2> Ga naar ticket: </h2>
      <form name="openTicket" action="acties/leesTicket.php" method="POST">
          Ticket ID: <br>
          <input type="text" name="ticketId" disabled><br>
          <input type="submit" name="zoeken" value="zoeken" disabled><br>    
      </form>
      
      
  </body>
</html>
