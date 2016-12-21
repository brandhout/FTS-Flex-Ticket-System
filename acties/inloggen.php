<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../functies.php'; //Include de functies.
    
    $connectie = verbinddatabase();
     

    if(isset($_POST['gebruikersNaam']) && isset($_POST['wachtwoord'])){
        //verkrijg de variabele uit het forum hieronder, de functies voorkommen SQL injectie
        $gebruikersNaam= stripcslashes(trim($_POST['gebruikersNaam']));
        $wachtwoord = stripcslashes(trim($_POST['wachtwoord']));

        $query = mysqli_query($connectie, "SELECT gebruikersNaam, wachtwoord FROM account WHERE gebruikersNaam = '$gebruikersNaam'");
            //or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
        $uitkomst = mysqli_fetch_array($query);
        $teller = mysqli_num_rows($query);

        if ($teller == 1 && $uitkomst['wachtwoord'] == $wachtwoord){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens

            // Inloggen succes, hier moet een sessie aangemaakt worden
            session_start();
            $_SESSION["gebruikersNaam"] = "gebruikersNaam"; //etc etc
            echo " sessie gestart";
            header('Location: ../index.php'); 

            } else { //Als de gevevens niet gelijk zijn

                echo"Inloggen mislukt, kloppen uw gegevens?"; //Variabele met foutmelding wordt aangemaakt.
            }   
    
    }
?>
<html>    
    <head>
        <meta charset="UTF-8">
        <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
        <link rel="stylesheet" href="../styles.css" type="text/css"> <!-- Tijdelijke oplossing voor het includen van de style in hogere mappen -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>
    <header>
        <img src="fts.PNG" class="logo2">
    </header>
    <body>
        <br><br><br>    
        
        <div class="inlogalgemeen1">
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input id="inlog1" type="text" name="gebruikersNaam" required placeholder="Vul hier uw gebruikersnaam in*"><span id="message1" ></span><br>
                <input type="password" name="wachtwoord" required placeholder="Vul hier uw wachtwoord in*"><span id="message2" ></span><br>
                <input type="submit" value="Submit" onclick="checkinlog()">                  
            </form>
            <?php 
                if (!$foutmelding == "") {                
                    echo $foutmelding; //Als foutmelding niet leeg is word hij weergegeven
                }
            ?>
        </div>
                
    </body>

</html>

