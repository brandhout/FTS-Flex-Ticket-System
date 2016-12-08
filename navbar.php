<html>

<div id="cssmenu" class="align-right">
  <ul>
     <li class="active"><a href="#" target="_blank"><i class="fa fa-sign-out"></i> UITLOGGEN</a></li>
     <li class="has-sub"><a href="#"><i class="fa fa-fw fa-bars"></i>Ga Naar...</a>
        <ul>
           <li class="has-sub"><a href="#">Menu 1</a>
              <ul>
                 <li><a href="#">Menu 1.1</a></li>
                 <li><a href="#">Menu 1.2</a></li>
              </ul>
           </li>
           <li><a href="#">Menu 2</a></li>
        </ul>
     </li>
     <li><a href="tickets.php"><i class="fa fa-ticket"></i> Alle Tickets</a></li>
     <li><a href="acties/nieuwTicket.php"><i class="fa fa-plus-square"></i> nieuw ticket</a></li>
          <li><a href="index.php"><i class="fa fa-home"></i> DASHBOARD</a></li>
	 
    <?php
/*
 * De volgende switch kijkt of de variabele isAdmin TRUE of FALSE is. Als hij true
 * is dan komt er een extra veld bij de navbar. De adminDash kan dan geopend worden.
 * Normaal doet hij niets, ook als de variabele dus NULL is.
 */
        switch ($isAdmin) { 
            case "TRUE":
            echo '<li><a href="adminDash.php"><i class="fa fa-unlock-alt"<</i>administrator</a></li>' ;
            break;
    
            case "FALSE":
            break;
    
            default:
            break;
        }
    ?>
      	
  </ul>
</div>
 <br><br><br>

</html>