<head>
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="styles.css" type="text/css">
  <link rel="stylesheet" href="../styles.css" type="text/css"> <!-- Tijdelijke oplossing voor het includen van de style in hogere mappen -->
  <script src="navbar.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  </head>
<header>
  <img class="logo" src="fts.PNG">
</header>
<?php

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
	 	
  </ul>
</div>

 <!-- database knop -->
<div class="center">
    <a href="index.php" class="dbknop">Dashboard</a>
</div>
 <br><br><br>

</html>
