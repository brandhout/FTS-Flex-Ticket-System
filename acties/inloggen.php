<?php
    /* 
     * This program is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 3 of the License, or
     * (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License
     * along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    /*
     * TODO:
     * - Opmaak fixen
     * - (EVENTUEEL) versleuteling
     */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../functies.php'; //Include de functies.
    
    $connectie = verbinddatabase();
     


?>
<html>    
    <head>
        <meta charset="UTF-8">
        <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        
            <!--bootstrap--> 
  <link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">
  <script src="../styles/js/bootstrap.min.js"></script>
  <!-- inloggen -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../styles.css">
    </head>
    
    <body>
        <div class='inlogg'>   
        
        <div class="container">
        <div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">

							<div class="col-lg-12">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>

						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="gebruikersNaam" autocomplete="off" id="username" tabindex="1" class="form-control" placeholder="vul uw gebruikersnaam in"><span id="message1" ></span>
									</div>
									<div class="form-group">
										<input type="password" name="wachtwoord" id="password" tabindex="2" class="form-control" placeholder="vul uw wachtwoord in"><span id="message2" ></span>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="inloggen">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="#" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
            <?php
            
     if(isset($_POST['gebruikersNaam']) && isset($_POST['wachtwoord'])){
        //verkrijg de variabele uit het forum hieronder, de functies voorkomen SQL injectie
        $gebruikersNaam = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['gebruikersNaam'])));
        $wachtwoord = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['wachtwoord'])));
   
        $query = mysqli_query($connectie, "SELECT gebruikersNaam, wachtwoord, isAdmin, actief, accountNr, lijnNr, laasteKeerIngelogd FROM account WHERE gebruikersNaam = '$gebruikersNaam'");
        $uitkomst = mysqli_fetch_array($query);
        $teller = mysqli_num_rows($query);
        
        $hashdb = $uitkomst['wachtwoord'] ;

        if ($teller == 1 && password_verify($wachtwoord, $hashdb) && $uitkomst['actief'] == 1){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens
            $laatsteKeerIngelogd = strtotime($uitkomst['laasteKeerIngelogd']);
            
            session_start();
            $accountNr = $uitkomst['accountNr'];
           
            if($laatsteKeerIngelogd < strtotime('-30 days')){
                $_SESSION["uitlogReden"] = "Om misbruik te voorkomen,<br> heeft FTS uw account op non-actief gezet, u heeft te lang niet ingelogd. Raadpleeg uw beheerder.";
                $nonActiefQuery = "UPDATE account SET actief = 0 WHERE accountNr = $accountNr";
                $connectie->query($nonActiefQuery);
                header("refresh:2;url= uitloggen.php");
                echo '
                <br><p>Welkom bij FTS!<br>Data wordt ingelezen<p>';
            } else {

                // Inloggen succes, hier moet een sessie aangemaakt worden
                $_SESSION["gebruikersNaam"] = $uitkomst['gebruikersNaam'];
                $_SESSION["accountNr"] = $uitkomst['accountNr'];
                $_SESSION["isAdmin"] = $uitkomst['isAdmin'];
                $_SESSION["lijnNr"] = $uitkomst['lijnNr'];
                $datum_query= "UPDATE account SET laasteKeerIngelogd = CURRENT_DATE WHERE accountNr = $accountNr";
                $connectie->query($datum_query);
                header("refresh:2;url= ../index.php");
                echo '
                <br><p>Welkom bij FTS!<br>systeem wordt gestart</p>';
            
            }
        } else {
            echo "FTS heeft uw account niet gevonden, kloppen uw gegevens?";
            return FALSE;
        }}           
            
            ?>
            
        </div></div>
        
    </body>
    <footer>
        <p>Made with: html/PHP/css/bootstrap/jQuery/mariaDB/javascript
            Made by: Naomi B, Rick H, Robby M. <br>
            <i>FTS is beschikbaar onder GPL, ROC logo is © ROC van Amsterdam</i></p>
    </footer>
</html>

