<html>
<?php
require_once '../functies.php'; //Include de functies.
?>
<head>
    <meta charset="UTF-8">
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="styles.css" type="text/css">
  <link rel="stylesheet" href="../styles.css" type="text/css"> <!-- Tijdelijke oplossing voor het includen van de style in hogere mappen -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  </head>
<header>

        <img src="fts.PNG" class="logo2">
</header>
  <br><br><br>    
    <body>
        
        <div class="inlogalgemeen1">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input id="inlog1" type="text" name="accountNr" required placeholder="Vul hier uw leerlingnummer in*"><span id="message1" ></span><br>
                    <input type="password" name="wachtwoord" required placeholder="Vul hier uw wachtwoord in*"><span id="message2" ></span><br>
                <input type="submit" value="Submit" onclick="checkinlog()">  
                
            </form>
            <?php if (!$foutmelding == "") {                
                echo $foutmelding; //Als foutmelding niet leeg is word hij weergegeven
            } ?>
        </div>
                
    </body>

</html>

<?php
verbinddatabase();

//verkrijg de variabele uit het forum hieronder, de functies voorkommen SQL injectie
$naam = mysqli_real_escape_string(stripcslashes(trim($POST['naam'])));
$wachtwoord = mysqli_real_escape_string(stripcslashes(trim($POST['wachtwoord'])));

//Database kwerrie (NIET KLAAR!!!)
$query = mysqli_query("select * from gebruikers where naam = '$naam' and wachtwoord = '$wachtwoord'")
        or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
$uitkomst = mysqli_fetch_array($uitkomst);

if ($uitkomst['naam'] == $naam && $uitkomst[wachtwoord] == $wachtwoord){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens
    
    // Inloggen succes, hier moet een sessie aangemaakt worden
    session_start();
    $_SESSION["naam"] = "naam"; //etc etc
    
    
} else { //Als de gevevens niet gelijk zijn
    
    $foutmelding = "Inloggen mislukt, kloppen uw gegevens?"; //Variabele met foutmelding wordt aangemaakt.
    
}
       
?>