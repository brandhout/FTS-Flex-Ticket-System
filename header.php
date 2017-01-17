<html>
<head>
    
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="styles.css" type="text/css">
  <script src="navbar.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--bootstrap--> 
  <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">
  <script src="styles/js/bootstrap.min.js"></script>
   <!--datepicker -->
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="styles/js/bootstrap.min.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
   <script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script> 

</head>
<body>
<header>
  
  
    <div id="theCarousel" class="carousel slide" data-interval="false">
        <img class="logo" src="fts.png">
  
      <ol class="carousel-indicators">
          <li data-target="#theCarousel" data-slide-to="0" class="active">
              
          </li>
          <li data-target="#theCarousel" data-slide-to="1">
              
          </li>
          <li data-target="#theCarousel" data-slide-to="2">
              
          </li>          
      </ol>
      <div class="carousel-inner">
          <div class="item active">
              <div class="slide1">
                  <div class="carousel-caption">
                  </div>
          </div>
      </div>
 <div class="item">
              <div class="slide2">
                  <div class="carousel-caption">
                  </div>
          </div>
      </div>   
 <div class="item">
              <div class="slide3">
                  <div class="carousel-caption">
                  </div>
          </div>
 </div></div>
          
          <a class="left carousel-control" href="#theCarousel"  data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"> </span></a>
          
          <a class="right carousel-control" href="#theCarousel"  data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"> </span> </a>         
  </div>
        <span onclick="openNav()"><i class="fa fa-bars toggle_menu"></i></span>
</header>
    
<div id="cssmenu" class="align-right">
  <ul>
  <?php
    switch ($_SESSION['isAdmin']) { 
                case "1":
                echo '<li><a href="admin/adminDash.php"><i class="fa fa-unlock"></i><span>AdminDash</span></a></li>' ;
                break;

                case "0":
                break;

                default:
                break;
            }

?>
     <li><a href="index.php"><span>DASHBOARD</span><i class="fa fa-home"></i></a></li>
     <li><a href="acties/nieuwTicketDash.php"><span><i class="fa fa-ticket"></i> NIEUW TICKET</span></a></li>
     <li><a href="tickets.php"><span>ALLE TICKETS</span></a></li>
     <li><a href="klanten.php"><span></i> KLANTEN</span></a></li>
     <li class="active"><a href="acties/uitloggen.php"><span><i class="fa fa-sign-out"></i>UITLOGGEN</span></a></li>
  </ul>
</div>
  
    
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-times"></i></a>
  <a href="#">About</a>
  <a href="#">Services</a>
  <a href="#">Clients</a>
  <a href="#">Contact</a>
</div>
    
 <br><br><br>
</body>
  </html>
