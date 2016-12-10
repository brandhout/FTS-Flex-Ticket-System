<html>
<?php
require_once '../functies.php'; //Include de functies.
require_once '../header.php'; // Zet de header bovenaan deze pagina.
?>

    
    <body>
        
        <div class="algemeen1">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="text" name="accountNr" required placeholder="Vul hier uw leerlingnummer in*"><span id="message1" ></span><br>
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
$accountNr = mysqli_real_escape_string(stripcslashes($POST['accountNr']));
$wachtwoord = mysqli_real_escape_string(stripcslashes($POST['wachtwoord']));

//Database kwerrie (NIET KLAAR!!!)
$uitkomst = mysqli_query("select * from gebruikers where accountNr = '$accountNr' and wachtwoord = '$wachtwoord'")
        or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
$row = mysqli_fetch_array($uitkomst);

if ($row['accountNr'] == $accountNr && $row[wachtwoord] == $wachtwoord){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens
    
    // Inloggen succes, hier moet een sessie aangemaakt worden
    session_start();
    $_SESSION["accountNr"] = "$accountNr"; //etc etc
    
    
} else { //Als de gevevens niet gelijk zijn
    
    $foutmelding = "Inloggen mislukt, kloppen uw gegevens?"; //Variabele met foutmelding wordt aangemaakt.
    
}
       
?>