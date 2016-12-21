<html>
<head>
    
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="styles.css" type="text/css">
  <script src="navbar.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
   <!--datepicker -->
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>  

</head>

<header>
  <img class="logo" src="fts.PNG">
</header>
<?php

switch ($_SESSION["isAdmin"]) { 
            case "TRUE":
            echo '<li><a href="adminDash.php"><i class="fa fa-unlock-alt"<</i>administrator</a></li>' ;
            break;
    
            case "FALSE":
            break;
    
            default:
            break;
        }

?>

<div id="cssmenu" class="align-right">
    <ul>
        <li class="active"><a href="uitloggen.php" target="_blank"><i class="fa fa-sign-out"></i> UITLOGGEN</a></li>
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
	<li><a href="adminDash.php"><i class="fa fa-admin"></i> admin Dashboard</a></li> 	
  </ul>
</div>
 <br><br><br>
  </html>

