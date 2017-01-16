<html>
<head>
    
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="../styles.css" type="text/css">
  <script src="../navbar.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--bootstrap
  <link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">
  <script src="../styles/js/bootstrap.min.js"></script> -->
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
<body>
<header>
  <img class="logo" src="../fts.png">
</header>
<div id="cssmenu" class="align-right">
  <ul>
  <?php
    switch ($_SESSION['isAdmin']) { 
                case "1":
                echo '<li><a href="../adminDash.php"><span>AdminDash</span><i class="fa fa-unlock">9</i></a></li>' ;
                break;

                case "0":
                break;

                default:
                break;
            }

?>
     <li><a href="../index.php"><span>DASHBOARD</span><i class="fa fa-home"></i></a></li>
     <li><a href="nieuwTicketDash.php"><span><i class="fa fa-ticket"></i> NIEUW TICKET</span></a></li>
     <li><a href="../tickets.php"><span>ALLE TICKETS</span></a></li>
     <li><a href="../klanten.php"><span></i> KLANTEN</span></a></li>
     <li class="active"><a href="uitloggen.php"><span><i class="fa fa-sign-out"></i>UITLOGGEN</span></a></li>
  </ul>
</div>
 <br><br><br>
</body>
  </html>
