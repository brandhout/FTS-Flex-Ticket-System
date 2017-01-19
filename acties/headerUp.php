<html>
<head>
    
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="../styles.css" type="text/css">
  <script src="navbar.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">
  <script src="../styles/js/bootstrap.min.js"></script>
   <!--datepicker -->
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="../styles/js/bootstrap.min.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
    $( function() {
    $( "#datepicker1" ).datepicker();
  } );
  </script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!--menu--> 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.11.1.js"></script>   
  
<script>
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
            $(this).toggleClass('open');       
        }
    );
});
</script>

</head>
<body>
<header>
  
  
<div class="container">
  <nav class="navbar navbar-inverse">
    <div class="navbar-header">
    	<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">FTS</a>
	</div>
	
	<div class="collapse navbar-collapse js-navbar-collapse">
		<ul class="nav navbar-nav">
			<li class="dropdown mega-dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Groot menu <span class="caret"></span></a>				
				<ul class="dropdown-menu mega-dropdown-menu">
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">afbeeldingen</li>                            
                            <div id="menCollection" class="carousel slide" data-ride="carousel">
                              <div class="carousel-inner">
                                <div class="item active">
                                    <a href="#"><img src="http://placehold.it/254x150/ff3546/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 1"></a>
                                    <h4><small>voorbeeld</small></h4>                                        
                                    <button class="btn btn-primary" type="button">#</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span>#</button>       
                                </div><!-- End Item -->
                                <div class="item">
                                    <a href="#"><img src="http://placehold.it/254x150/3498db/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 2"></a>
                                    <h4><small>voorbeeld</small></h4>                                        
                                    <button class="btn btn-primary" type="button">#</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span>#</button>        
                                </div><!-- End Item -->
                                <div class="item">
                                    <a href="#"><img src="http://placehold.it/254x150/2ecc71/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 3"></a>
                                    <h4><small>voorbeeld</small></h4>                                        
                                    <button class="btn btn-primary" type="button">#</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span>#</button>      
                                </div><!-- End Item -->                                
                              </div><!-- End Carousel Inner -->
                              <!-- Controls -->
                              <a class="left carousel-control" href="#menCollection" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="right carousel-control" href="#menCollection" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                              </a>
                            </div><!-- /.carousel -->
                            <li class="divider"></li>
                            <li><a href="#">ga naar.... <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
						</ul>
					</li>
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Features</li>
							<li><a href="#">Auto Carousel</a></li>
                            <li><a href="#">Carousel Control</a></li>
                            <li><a href="#">Left & Right Navigation</a></li>
							<li><a href="#">Four Columns Grid</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Fonts</li>
                            <li><a href="#">Glyphicon</a></li>
							<li><a href="#">Google Fonts</a></li>
						</ul>
					</li>
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Plus</li>
							<li><a href="#">Navbar Inverse</a></li>
							<li><a href="#">Pull Right Elements</a></li>
							<li><a href="#">Coloured Headers</a></li>                            
							<li><a href="#">Primary Buttons & Default</a></li>							
						</ul>
					</li>
					  <?php
    switch ($_SESSION['isAdmin']) { 
                case "1":
                echo '<li class="col-sm-3">
						<ul>
                                                        <li class="dropdown-header">Admin-menu</li>
							<li><a href="../admin/adminDash.php">AdminDash</a></li>
							<li><a href="../admin/accounts.php">accountbeheer</a></li>
                                                        <li><a href="../admin/nieuwAccount.php">nieuw account aanmaken</a></li>
							<li><a href="../admin/invoerApparaten.php">invoeren apparaten</a></li>
							<li><a href="#">...</a></li>
							<li><a href="#">...</a></li>
						</ul>
					</li>
				' ;
                break;

                case "0":
                break;

                default:
                break;
            }

?>

				</ul>				
			</li>
            <li class="">
    			<a href="../index.php">dashboard<i class="fa fa-home"></i>	</a>			
			</li>
  <?php
    switch ($_SESSION['isAdmin']) { 
                case "1":
                echo '<li><a href="../admin/adminDash.php">Admin Dashboard<i class="fa fa-unlock"></i></a></li>' ;
                break;

                case "0":
                break;

                default:
                break;
            }

?>
		</ul>
        <ul class="nav navbar-nav navbar-right">
                        <li>
                <a href="nieuwTicketDash.php">nieuw ticket <i class="fa fa-ticket"></i></a>
            </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">navigeer naar <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="../tickets.php">tickets</a></li>
            <li><a href="../klanten.php">klanten</a></li>
            <li><a href="nieuwTicketDash.php">nieuwe ticket</a></li>
            <li class="divider"></li>
            <li><a href="#">komt nog meer aan!</a></li>
          </ul>
        </li>
        <li><a href="uitloggen.php">uitloggen <i class="fa fa-sign-out"></i></a></li>
      </ul>
	</div><!-- /.nav-collapse -->
  </nav>
</div>
</body>
  </html>
