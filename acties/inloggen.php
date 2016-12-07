<?php
require_once '../functies.php'; //Include de functies.
require_once '../header.php'; // Zet de header bovenaan deze pagina.
verbinddatabase();

//verkrijg de variabele uit het forum hieronder, de functies voorkommen SQL injectie
$accountNr = mysqli_real_escape_string(stripcslashes($POST['accountNr']));
$wachtwoord = mysqli_real_escape_string(stripcslashes($POST['wachtwoord']));

//Database kwerrie (NIET KLAAR!!!)
$uitkomst = mysql_query()
        or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
$row = mysql_fetch_array($uitkomst);

if ($row['accountNr'] == $accountNr && $row[wachtwoord] == $wachtwoord){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens
    
    // Inloggen succes, hier moet een sessie aangemaakt worden
    $_SESSION["accountNr"] = "$accountNr"; //etc etc
    
    
} else {
    
    $foutmelding = "Inloggen mislukt, kloppen uw gegevens?";
    
}
       
?>

<html>

<header>
<img src="../fts.PNG">
<style>
img {
    display: block;
    margin: auto;
}
</style>
</header>
    
    <body>
        
        <div class="login1">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="text" name="accountNr" onblur="checkAccountNr()" required placeholder="Vul hier uw leerlingnummer in*"><span id="message1" ></span><br>
                    <input type="password" name="wachtwoord" onblur="checkww()" required placeholder="Vul hier uw wachtwoord in*"><span id="message2" ></span><br>
                <input type="submit" value="Submit" onclick="checkinlog()">  
                
                <!-- vraagje! Zijn die onblur/onclick functies wel nodig (zie php hierboven) zo ja, dan moeten ze geschreven worden. GEEN JAVASCRIPT -->
            </form>
            <?php if (!$foutmelding == "") {                
                echo $foutmelding; //Als foutmelding niet leeg is word hij weergegeven
            } ?>
        </div>
                
    </body>


</html>