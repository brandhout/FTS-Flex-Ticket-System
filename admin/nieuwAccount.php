<?php

    
   session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../header.php'; //Include de header.
    include_once '../functies.php';
    $connectie = verbinddatabase();
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
        die();
    }
    
    $datum = mysqldatum();
    
        
   if (empty($_POST)){
       echo ' <html>
                <body>
                    <header>
                        <title>Nieuw account</title>
                    </header>';                  
       echo '      <hr>
           
                        <div class="container">
                            <div class="inner contact">  
                                <div class="grid">
                                    <div class="row">                                       
                                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>
                                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">                     
                                            <form name="wijzigaccount" action="';
                                            echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"<br>';
                                            echo '
                                                Klassencode (indien leerling)<br>
                                                <select class="form" name="klassencode">
                                                <option value ="">---Select---</option>';
                                                $ophaalKlas = "SELECT * FROM schoolKlassen "; //selecteerd alle klassen 
                                                $resultsKlas = mysqli_query($connectie, $ophaalKlas);
                                                    while ($v = mysqli_fetch_assoc($resultsKlas)) {
                                                        echo "<option value='" . $v['schoolKlasId'] . "'>" . $v['schoolKlasId'] . " " . $v['schoolKlasOmschrijving'] . "</option>";
                                                    }
                                                echo '</select>';
                                                echo 'Voornaam<br>
                                                <input class="form" type="text" name="naam" required>
                                                Achternaam<br>
                                                <input class="form" type="text" name="achterNaam" required>';
                                                
                                                echo 'Lijnnummer<br>
                                                <select class="form" name="lijnNr">                                                   
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">   
                                                Vestiging<br>
                                                <select class="form" name="vestigingId">
                                                    <option value = "">---Select---</option>';
                                                        $ophaalVes = "SELECT * FROM vestigingen ";
                                                        $resultsVes = mysqli_query($connectie, $ophaalVes);
                                                            while ($v = mysqli_fetch_assoc($resultsVes)) {
                                                                echo "<option value='" . $v['vestigingId'] . "'>" . $v['vestigingId'] . " " . $v['vesOmschrijving'] . "</option>";
                                                            }
                                                echo '</select>';
                                                echo '<br>Admin: <input class="form" type="checkbox" name="isAdmin" value=1 >
                                                <br><br>Gebruikersnaam<br>
                                                <input type="text" class="form" name="gebruikersNaam" required>
                                                Wachtwoord<br>
                                                <input type="password" class="form" name="wachtwoord" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$">
                                                <input type="submit" name="opslaan" class="form-btn semibold" value="opslaan">
                                            </div>
                                            <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>
                                            </form>
                                        </div></div></div></div><hr>
            </body>  
     </html> ';   

    }
    if ( !empty($_POST) && $_SESSION['isAdmin'] === '1'){
        if ( $_POST["isAdmin"] === '1' ) {
            $admin = 1;
        } else { 
            $admin = 0;
        }
    
    if(is_numeric($_POST["vestigingId"])){
        $vestigingId = $_POST["vestigingId"];
    }
        
    $naam = $connectie->escape_string($_POST["naam"]);
    $achterNaam = $connectie->escape_string($_POST["achterNaam"]);
    $gebruikersNaam = $connectie->escape_string($_POST["gebruikersNaam"]);

    $hash = password_hash($_POST["wachtwoord"], PASSWORD_BCRYPT);

    $insertAccount = $connectie->prepare('INSERT INTO account (accountNr, lijnNr, isAdmin, naam, achterNaam, laasteKeerIngelogd, actief, vestigingId, gebruikersNaam, wachtwoord)
        VALUES (0, "'  . $_POST["lijnNr"] . '","' . $admin . '","' . $naam . '","' . $achterNaam . '","' . $datum . '","' . "1" . '","' . $vestigingId . '","' .  $gebruikersNaam . '","' . $hash . '")');
    if ($insertAccount) {
        if ($insertAccount->execute()) {
            echo '
                <script> location.replace("accounts.php"); </script>';
            die();
        }
    }
}
?>