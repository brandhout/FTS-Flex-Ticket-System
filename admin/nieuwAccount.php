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
    }
    
    $datum = mysqldatum();
    
        
   if (empty($_POST)){
       echo ' <html>
                <header>
                    <title>Nieuw account</title>
                </header>
                ';                  
                    echo '<div class="container"> <body> <h2> Nieuw account </h1>'
                    . '<form name="wijzigaccount" action="';
                    echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"<br>';

                    echo '<table cellspacing="0" cellpading="5"width="90%">
                        <tr><td>Klassencode (indien leerling)<br>
                        <select name="klassencode">
                        <option value ="">---Select---</option>';

                        $ophaalKlas = "SELECT * FROM schoolKlassen "; //selecteerd alle klassen 
                        $resultsKlas = mysqli_query($connectie, $ophaalKlas);
                        while ($v = mysqli_fetch_assoc($resultsKlas)) {
                            echo "<option value='" . $v['schoolKlasId'] . "'>" . $v['schoolKlasId'] . " " . $v['schoolKlasOmschrijving'] . "</option>";
                        }
                        echo '</select></td></tr>';
                        
                    echo '<tr><td>Voornaam<br>
                        <input type="text" name="naam" required></td></tr>
                        <tr><td>Achternaam<br>
                        <input type="text" name="achterNaam" required></td></tr>

                        <tr><td>Lijnnummer<br>
                        <select name="lijnNr"required>
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
                            <input type="text" name="gebruikersNaam" required></td></tr>
                            <tr><td>Wachtwoord<br>
                            <input type="password" name="wachtwoord" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$"></td></tr>
                            
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
        
        $_POST["naam"] = $connectie->escape_string($_POST["naam"]);
        $_POST["achterNaam"] = $connectie->escape_string($_POST["achterNaam"]);
        $_POST["gebruikersNaam"] = $connectie->escape_string($_POST["gebruikersNaam"]);
        $_POST["wachtwoord"] = $connectie->escape_string($_POST["wachtwoord"]);
        
        $hash = password_hash($_POST["wachtwoord"], PASSWORD_BCRYPT);
        
        $insertAccount = $connectie->prepare('INSERT INTO account (accountNr, lijnNr, isAdmin, naam, achterNaam, laasteKeerIngelogd, actief, vestigingId, gebruikersNaam, wachtwoord)
            VALUES (0, "'  . $_POST["lijnNr"] . '","' . $admin . '","' . $_POST["naam"] . '","' . $_POST["achterNaam"] . '","' . $datum . '","' . "1" . '","' . $_POST["vestigingId"] . '","' .  $_POST["gebruikersNaam"] . '","' . $hash . '")');
        if ($insertAccount) {
            if ($insertAccount->execute()) {
                header("Refresh:1; url=accounts.php", true, 303);
            }
        }
    }
    ?>

