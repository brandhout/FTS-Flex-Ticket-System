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
    </head>
        <style>
        body{
            background-image:url("../back.jpg");
        }
        
    </style>  
    <body>
        <header>
          <img class="logo2" src="../fts.png">
        </header>
        <div class="container"><div class='inlogg'> 
        <div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">

							<div class="col-lg-12">
								<h3>uitloggen</h3>
							</div>

						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
	

									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
                                                                                                    <?php

session_start();
if (isset($_SESSION["uitlogReden"])){
    $uitlogReden = $_SESSION["uitlogReden"];
    $refresh = "refresh:9";
} else {
    $refresh = "refresh:2";
}
unset ($_SESSION['gebruikersNaam']);

session_destroy();
echo "u bent uitgelogd<br><strong><p style='color:red'>" . $uitlogReden . "</strong><p>";
//echo ($_POST['gebruikersNaam'] . "is uitgelogd");

header("$refresh ;  URL=inloggen.php");

?>
                                                                                                </div>        												</div>
											</div>
										</div>
									</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

            
        </div></div>
    </body>
</html>



        
   