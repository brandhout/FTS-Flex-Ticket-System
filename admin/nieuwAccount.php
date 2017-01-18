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
                        <br>';
                    echo '<div class="containert2">'
                    . '<form name="wijzigaccount" action="';
                    echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"<br>';

                    echo '<table cellspacing="0" cellpading="5"width="90%">
                        <tr><td>Indien leerling: Klassencode<br>
                        <select name="klassencode">
                        <option value ="">---Select---</option>';

                        $ophaalKlas = "SELECT * FROM schoolKlassen "; //selecteerd alle klassen 
                        $resultsKlas = mysqli_query($connectie, $ophaalKlas);
                        while ($v = mysqli_fetch_assoc($resultsKlas)) {
                            echo "<option value='" . $v['schoolKlasId'] . "'>" . $v['schoolKlasId'] . " " . $v['schoolKlasOmschrijving'] . "</option>";
                        }
                        echo '</select></td></tr>';
                        
                    echo '<tr><td>Voornaam<br>
                        <input type="text" name="naam"></td></tr>
                        <tr><td>Achternaam<br>
                        <input type="text" name="achterNaam"</td></tr>

                        <tr><td>Lijnnummer<br>
                        <select name="lijnNr">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          </select></td></tr>

                        <tr><td>Vestiging<br>
                        <select name="vestigingId">
                        <option value = "">---Select---</option>';

                        $ophaalVes = "SELECT * FROM vestigingen ";
                        $resultsVes = mysqli_query($connectie, $ophaalVes);
                        while ($v = mysqli_fetch_assoc($resultsVes)) {
                            echo "<option value='" . $v['vestigingId'] . "'>" . $v['vestigingId'] . " " . $v['vesOmschrijving'] . "</option>";
                        }
                        echo '</select></td></tr>';
                                                                       
                        echo '<tr><td>Admin: <input type="checkbox" name="isAdmin" value=1 ></td></tr>
                            <tr><td>Gebruikersnaam<br>
                            <input type="text" name="gebruikersNaam"></td></tr>
                            <tr><td>Wachtwoord<br>
                            <input type="password" name="wachtwoord"></td></tr>
                            
                            <tr><td><input type="submit" name="opslaan" value="opslaan"></td></tr> 
                    </table></form></div>
            </body>  
     </html> ';   

    }
    if ( !empty($_POST) ){
        if ( $_POST["isAdmin"] == 1 ) {
            $admin = 1;
        } else { 
            $admin = 0;
        }
            
        $hashin = password_hash($_POST["wachtwoord"], PASSWORD_BCRYPT);
        
        $insertAccount = $connectie->prepare('INSERT INTO account (accountNr, lijnNr, isAdmin, naam, achterNaam, laasteKeerIngelogd, actief, vestigingId, gebruikersNaam, wachtwoord)
                                 VALUES (0, "'  . $_POST["lijnNr"] . '","' . $admin . '","' . $_POST["naam"] . '","' . $_POST["achterNaam"] . '","' . $datum . '","' . "1" . '","' . $_POST["vestigingId"] . '","' .  $_POST["gebruikersNaam"] . '","' . $_POST["wachtwoord"] . '")');
                                if ($insertAccount) {
                                    if ($insertAccount->execute()) {
                                         header("Refresh:1; url=accounts.php", true, 303);
                                    }
                                }
        
        
        
        echo 'submit uitgevoerd';
       
    }
    ?>

