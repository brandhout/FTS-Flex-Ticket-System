<?php

    
   session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'headerUp.php';
    include_once '../functies.php';
    $connectie = verbinddatabase();
    
    $datum = mysqldatum();
        
   if (empty($_POST)){
       echo ' <html>
                <header>
                    <title>Nieuw account</title>
                </header>
                <body>';
                    echo '<h2><strong>Nieuwe accounts</strong></h2>
                        <br><br>';
                    echo '<form name="wijzigaccount" action="';
                    echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"<br>';

                    echo 'Indien leerling: Klassencode <br><br> 
                        <select name="klassencode">
                        <option value ="">---Select---</option>';

                        $ophaalKlas = "SELECT * FROM schoolKlassen "; //selecteerd alle klassen 
                        $resultsKlas = mysqli_query($connectie, $ophaalKlas);
                        while ($v = mysqli_fetch_assoc($resultsKlas)) {
                            echo "<option value='" . $v['schoolKlasId'] . "'>" . $v['schoolKlasId'] . " " . $v['schoolKlasOmschrijving'] . "</option>";
                        }
                        echo '</select><br><br>';
                        
                    echo 'Voornaam: <br>
                        <input type="text" name="naam"><br><br>
                        Achternaam: <br><br>
                        <input type="text" name="achterNaam"><br><br>

                        Lijnnummer: <br>
                        <select name="lijnNr">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          </select><br><br>

                        Vestiging: <br>
                        <select name="vestigingId">
                        <option value = "">---Select---</option>';

                        $ophaalVes = "SELECT * FROM vestigingen ";
                        $resultsVes = mysqli_query($connectie, $ophaalVes);
                        while ($v = mysqli_fetch_assoc($resultsVes)) {
                            echo "<option value='" . $v['vestigingId'] . "'>" . $v['vestigingId'] . " " . $v['vesOmschrijving'] . "</option>";
                        }
                        echo '</select><br><br>';
                                                                       
                        echo 'Admin: <br>
                            <input type="checkbox" name="isAdmin" value=1 ><br>
                            Gebruikersnaam: <br>
                            <input type="text" name="gebruikersNaam"><br><br>
                            Wachtwoord: <br>
                            <input type="password" name="wachtwoord"><br><br>
                            
                            <input type="submit" name="opslaan" value="opslaan"><br> 
                    </form>
            </body>  
     </html> ';   

    }
    if ( !empty($_POST) ){ 
        if ( $_POST["isAdmin"] == 1 ) {
            $admin = 1;
        } else { 
            $admin = 0;
        }
            
        $insertAccount = $connectie->prepare('INSERT INTO account (accountNr, lijnNr, isAdmin, naam, achterNaam, laasteKeerIngelogd, actief, magInloggen, vestigingId, gebruikersNaam, wachtwoord)
                                 VALUES (0, "'  . $_POST["lijnNr"] . '","' . $admin . '","' . $_POST["naam"] . '","' . $_POST["achterNaam"] . '","' . $datum . '","' . "1" . '","' . "1" . '","' . $_POST["vestigingId"] . '","' .  $_POST["gebruikersNaam"] . '","' . $_POST["wachtwoord"] . '")');
                                if ($insertAccount) {
                                    if ($insertAccount->execute()) {
                                         header("Refresh:1; url=accounts.php", true, 303);
                                    }
                                }
        
        
        
        echo 'submit uitgevoerd';
       
    }
    ?>

