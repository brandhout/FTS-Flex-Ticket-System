<?php
    
   session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'headerUp.php';
    include_once '../functies.php';
    $connectie = verbinddatabase();

//$leerling = FALSE;
    
    //if (isset($_POST["isLeerling"])){
        //if($_POST['isLeerling'] === "leerlingw" ){
               // $leerling = TRUE;
            //}       
       
    //}  
    if (empty($_POST)){
       echo ' <html>
                <header>
                    <title>Nieuw account</title>
                </header>
                <body>';

                    echo '<form name="wijzigaccount" action="';
                    echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"';

                    echo '<h2><strong>Nieuwe accounts</strong></h2>
                        <br><br>
                        <input type="checkbox" name="isLeerling" value="isLeerling" />Is een leerling
                        <br><br>
                        Voornaamaam <br>
                        <input type="text" name="naam"><br><br>
                        Achternaam <br>
                        <input type="text" name="achterNaam"><br><br>

                        Lijnnummer<br><!-- moet nog opgeslagen worden in de database net als de rest -->
                        <select name="lijnNr">
                          <option>Lijn 1</option>
                          <option>Lijn 2</option>
                          <option>Lijn 3</option>
                          </select><br><br>

                        Vestiging <br> <!-- Moet nog gescript worden! Data moet uit database komen -->
                        <select name="vestigingId">
                        <option value = "">---Select---</option>';

                        $ophaalVes = "SELECT * FROM vestigingen ";
                        $resultsVes = mysqli_query($connectie, $ophaalVes);
                        while ($v = mysqli_fetch_assoc($resultsVes)) {
                            echo "<option value='" . $v['vestigingId'] . "'>" . $v['vestigingId'] . " " . $v['vesOmschrijving'] . "</option>";
                        }
                        echo '</select><br><br>
                            Gebruikersnaam <br>
                            <input type="text" name="gebruikersNaam"><br><br>
                            Wachtwoord <br>
                            <input type="text" name="wachtwoord"><br><br>

                            <input type="submit" name="opslaan" value="opslaan"><br> 
                    </form>
            </body>  
     </html> ';   

    }
    if ( !empty($_POST)){ 
        $insertAccount = $connectie->prepare('INSERT INTO account (accountNr, lijnNr, naam, achterNaam, vestigingId, gebruikersNaam, wachtwoord)
                                 VALUES (0, "'  . $_POST["lijnNr"] . '","' . $_POST["naam"] . '","' . $_POST["achterNaam"] . '","' . $_POST["vestigingId"] . '","' .  $_POST["gebruikersNaam"] . '","' . $_POST["wachtwoord"] . '")');
                                if ($insertAccount) {
                                    if ($insertAccount->execute()) {
                                        echo ' klant gemaakt!';
                                         header("Refresh:5; url=accounts.php", true, 303);
                                    }
                                }
        
        echo 'submit uitgevoerd';
    }
    ?>
