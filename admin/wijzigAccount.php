<?php
    
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'headerUp.php';
    include_once '../functies.php';
    $connectie = verbinddatabase();
    
       $wijzigen = FALSE;
    $verwijderen = FALSE;

    if (empty($_POST)){
        if(isset($_GET['accountActie'])){
            if(strpos($_GET['accountActie'],'Wijzig') !== FALSE){
                $wijzigen = TRUE;
            }
            if(strpos($_GET['accountActie'],'Verwijder') !== FALSE){
                $verwijderen = TRUE;
            }
            $accountNr = filter_var($_GET['accountActie'], FILTER_SANITIZE_NUMBER_INT);
        }        

        $wAccountQuery = "SELECT * FROM account WHERE accountNr = $accountNr";
        $wAccountUitkomst = $connectie->query($wAccountQuery);
        if( $wAccountUitkomst ){
            while($account = $wAccountUitkomst->fetch_assoc()){

                echo '<form name="wijzigaccount" action="';
                echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"';
                //echo 'wijzigAccount.php' . '" method="POST"';
                
                echo '<br>';

                echo 'Accountnummer <br><input type="text" name="accountNr" value="';
                echo htmlspecialchars($account["accountNr"]) . '" readonly /><br><br>';
                
                echo 'Voornaam <br><input type="text" name="naam"value="';
                echo htmlspecialchars($account["naam"]) . '"/><br><br>';

                echo 'Achternaam <br><input type="text" name="achterNaam"value="';
                echo htmlspecialchars($account["achterNaam"]) . '"/><br><br>';



                echo 'Lijnnummer<br><!-- moet nog opgeslagen worden in de database net als de rest -->
                        <select name="lijnNr">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          </select><br><br>';


                echo 'Vestiging <br> <!-- Moet nog gescript worden! Data moet uit database komen -->
                    <select name="vestigingId">
                    <option value = "">---Select---</option>';

                $ophaalVes = "SELECT * FROM vestigingen ";
                $resultsVes = mysqli_query($connectie, $ophaalVes);
                while ($v = mysqli_fetch_assoc($resultsVes)) {
                    echo "<option value='" . $v['vestigingId'] . "'>" . $v['vestigingId'] . " " . $v['vesOmschrijving'] . "</option>";
                }
                echo '</select><br><br>';

                echo 'Gebruikersnaam <br><input type="text" name="gebruikersNaam"value="';
                echo htmlspecialchars($account["gebruikersNaam"]) . '"/><br><br>';

                echo 'Wachtwoord <br><input type="text" name="wachtwoord"value="';
                echo htmlspecialchars($account["wachtwoord"]) . '"/><br><br>';

                echo'<input type="submit" name="accountActie" value="Opslaan"><br>';
                //<button name="accountActie" type="submit" value="Wijzig'. $account['accountNr'] .'">Wijzigen</button>
                echo'</form>';
            }
        }
    }
    if ( !empty($_POST)){
        //$updateAccount = $connectie->prepare('UPDATE account (accountNr, lijnNr, naam, achterNaam, vestigingId, gebruikersNaam, wachtwoord)
        //               VALUES ("' . filter($_POST["accountNr"]) . '","' . filter($_POST["lijnNr"]) . '","' . filter($_POST["naam"]) . 
        //                        '","' . filter($_POST["achterNaam"]) . '","' . filter($_POST["vestigingId"]) . 
        //                        '","' . filter($_POST["gebruikersNaam"]) . '","' . filter($_POST["wachtwoord"]) . '")');
        echo 'er is gepost.';
        
        $updateAccount = "UPDATE account SET accountNr='{$_POST['accountNr']}', lijnNr='{$_POST['lijnNr']}', naam='{$_POST['naam']}', achterNaam='{$_POST['achterNaam']}', vestigingId='{$_POST['vestigingId']}', gebruikersNaam='{$_POST['gebruikersNaam']}', wachtwoord='{$_POST['wachtwoord']}' WHERE accountNr='{$_POST['accountNr']}' ";
        //$updateAccount = "UPDATE account SET accountNr={$_POST['accountNr']}, lijnNr={$_POST['lijnNr']}, naam={$_POST['naam']}, achterNaam={$_POST['achterNaam']}, vestigingId={$_POST['vestigingId']}, gebruikersNaam={$_POST['gebruikersNaam']}, wachtwoord={$_POST['wachtwoord']} ";
        echo $updateAccount;
        $prep = $connectie->prepare($updateAccount);
            if ($prep) {
                if ($prep->execute()) {
                    echo 'Wijziging opgeslagen';
                    header("Refresh:5; url=accounts.php", true, 303);
                }
           }
        //echo 'er is gepost.';
        //echo $_POST['accountNr'];
    }
    //}
    /*echo '<tr><td align=left">' .
                $account['accountNr'] . $td .
                $account['gebruikersNaam'] . $td .
                $account['naam'] . $td .
                $account['achterNaam'] . $td .
                $schoolKlas['schoolKlasCode'] . $td .
                $isAdmin . $td .
                $account['actief'] . $td .
                $account['magInloggen'] . $td .
                $account['lijnNr'] . $td;
                echo '<tr>';
    }   */ 
    
    
?>