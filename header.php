<html>
<head>
    
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'><!-- KAPOT! -->
  <link rel="stylesheet" href="/ticketsysteem/styles.css" type="text/css"> 
  <script src="/ticketsysteem/navbar.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--bootstrap--> 
  <link rel="stylesheet" type="text/css" href="/ticketsysteem/styles/css/bootstrap.css">
  <script src="/ticketsysteem/styles/js/bootstrap.min.js"></script>
   <!--datepicker -->
     <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="/ticketsysteem/styles/js/bootstrap.min.js"></script>
    <!--menu--> 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
    $( function() {
    $( "#datepicker1" ).datepicker();
  } );
  </script>  
<script>
$(document).ready(function(){
    $(".dropdown").clicked(            
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
<script>

    /* API method to get paging information */

    'use strict';
	var $ = jQuery;
	$.getScript("https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js", function(){
       
            $('#example').DataTable( {
                "language": {
    "url": "http://cdn.datatables.net/plug-ins/1.10.13/i18n/Dutch.json"
  },
                "paging":   true,
                "ordering": true,
                "info":     false
            } );
	});

</script>
</head>
<body>
<div class="container">
  <nav class="navbar navbar-default">
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
  					  <?php
    switch ($_SESSION['isAdmin']) { 
                case "1": echo '                  
                    <li><a href="/ticketsysteem/admin/adminDash.php">Admin Dashboard<span class="glyphicon glyphicon-dashboard"></span></a></li>
                            <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="dash"></span>Admin menu<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">

                                                        <li class="dropdown-header">Admin-menu</li>
                                                        <li class="divider"></li>
							<li><a href="/ticketsysteem/admin/adminDash.php">AdminDash</a></li>
                                                        <li><a href="/ticketsysteem/admin/cms/cmsDash.php">Content Management</a></li>
							<li><a href="/ticketsysteem/admin/accounts.php">Accountbeheer</a></li>
                                                        <li><a href="/ticketsysteem/admin/invoerBedrijf.php">nieuw bedrijf</a></li>
							<li><a href="/ticketsysteem/admin/invoerApparaten.php">invoeren apparaten</a></li>
							<li><a href="/ticketsysteem/admin/invoerCategorie.php">invoeren categorieën</a></li>
							<li><a href="/ticketsysteem/admin/invoerInstantie.php">invoeren instanties</a></li>                                                        
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


            <li class="achter">
    			<a href="/ticketsysteem/index.php">dashboard<i class="fa fa-home"></i>	</a>			
			</li>
		</ul>
        <ul class="nav navbar-nav navbar-right">
                        <li class="achter">
                <a href="/ticketsysteem/acties/nieuwTicketDash.php">Nieuw ticket <i class="fa fa-ticket"></i></a>
            </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
              <li class="dropdown-header">navigeren naar...</li>
                                                        <li class="divider"></li>
            <li><a href="/ticketsysteem/tickets.php">Tickets</a></li>
            <li><a href="/ticketsysteem/klanten.php">Klanten</a></li>
            <li class="divider"></li>
            <li><a href="/ticketsysteem/acties/nieuwTicketDash.php">nieuwe ticket</a></li>
          </ul>
        </li>
        <li class="achter"><a href="/ticketsysteem/acties/uitloggen.php">uitloggen <i class="fa fa-sign-out"></i></a></li>
      </ul>
	</div><!-- /.nav-collapse -->
  </nav>
</div>

    
 <br>
</body>
  </html>
