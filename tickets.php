<?php

include_once 'header.php';
include_once 'functies.php';
verbinddatabase();

$query= "";
$uitkomst= mysqli_query($connectie, $query)
        or die("Kan aangevraagde actie niet verwerken:" .mysql_error());

if($uitkomst) {
// Maak HTML tabel!

    echo '<table align="left"
        <td><td align="left"><strong>TicketID</strong></td>
        <td><td align="left"><strong>Onderwerp</strong></td>
        <td><td align="left"><strong>Klantnaam</strong></td>
        <td><td align="left"><strong>Lijn</strong></td>
        <td><td align="left"><strong>Aannemer</strong></td>
        <td><td align="left"><strong>Opgelosd</strong></td></tr>';
    
    while($rij = mysqli_fetch_array($uitkomst)){
        // Deze 'zolang' of 'terwijl' loop geeft een rij data, en herhaalt dit totdat er geen data
        // meer in de uitkomst zit.
        echo '<tr><td align=left">' .
                $rij[ticketId] . '</td><td align="left">' .
                $rij[onderwerp] . '</td><td align="left">' .
                $rij[klantAchterNaam] . '</td><td align="left">' .
                $rij[lijnNr] . '</td><td align="left">' .
                $rij[fstAccountNr] . '</td><td align="left">' .
                $rij[definitief] . '</td><td align="left">';
        
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
          <input type="text" name="Titel"><br>
          Beschrijving <br>
          <input type="text" name="Beschrijving"><br>
          <input type="submit" name="zoeken" value="zoeken"><br>    
      </form>
      
      
  </body>
</html>

