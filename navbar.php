
<ul id="navmenu">
    
  <li><a href="tickets.php">Tickets</a></li>
<?php
/*
 * De volgende switch kijkt of de variabele isAdmin TRUE of FALSE is. Als hij true
 * is dan komt er een extra veld bij de navbar. De adminDash kan dan geopend worden.
 * Normaal doet hij niets, ook als de variabele dus NULL is.
 */
 switch ($isAdmin) { 
    case "TRUE":
        echo '<li><a href="adminDash.php">administrator</a></li>' ;
        break;
    
    case "FALSE":
        break;
    
    default:
        break;
}
?>
  <li style="float:right"><a href="acties/nieuwTicket.php">+ Nieuw ticket</a></li>
  <li><a class="active" href="index.php">Dash</a></li>
</ul>

