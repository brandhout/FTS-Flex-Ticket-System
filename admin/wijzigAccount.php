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
                echo '<h2><strong>Wijzig accounts</strong></h2>';
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
                
                echo 'Admin: <input type="checkbox" name="isAdmin" value="';
                if($account["isAdmin"] == 1){
                    echo htmlspecialchars($account["isAdmin"]) . '" checked /><br><br>';
                } else {
                    echo htmlspecialchars($account["isAdmin"]) . '" /><br><br>';
                }

                echo 'Gebruikersnaam <br><input type="text" name="gebruikersNaam" value="';
                echo htmlspecialchars($account["gebruikersNaam"]) . '"/><br><br>';

                echo 'Wachtwoord <br><input type="password" name="wachtwoord" value="';
                echo '"/><br><br>';

                echo'<input type="submit" name="accountActie" value="Opslaan"><br>';
                //<button name="accountActie" type="submit" value="Wijzig'. $account['accountNr'] .'">Wijzigen</button>
                echo'</form>';
            }
        }
    }
    if ( !empty($_POST)){
            //echo $_POST["isAdmin"];
            if ( isset($_POST["isAdmin"]))  {
                $admin = 1;
            } else { 
                $admin = 0;
            }
            if(!empty($_POST["wachtwoord"])){
                $hashin = password_hash($_POST["wachtwoord"], PASSWORD_BCRYPT);
                $updateAccount = "UPDATE account SET accountNr='{$_POST['accountNr']}', lijnNr='{$_POST['lijnNr']}', isAdmin='$admin', naam='{$_POST['naam']}', achterNaam='{$_POST['achterNaam']}', vestigingId='{$_POST['vestigingId']}', gebruikersNaam='{$_POST['gebruikersNaam']}', wachtwoord='$hashin' WHERE accountNr='{$_POST['accountNr']}' ";
            } else {
                $updateAccount = "UPDATE account SET accountNr='{$_POST['accountNr']}', lijnNr='{$_POST['lijnNr']}', isAdmin='$admin', naam='{$_POST['naam']}', achterNaam='{$_POST['achterNaam']}', vestigingId='{$_POST['vestigingId']}', gebruikersNaam='{$_POST['gebruikersNaam']}' WHERE accountNr='{$_POST['accountNr']}' ";
                
            }     
        
        echo $updateAccount;
        $prep = $connectie->prepare($updateAccount);
            if ($prep) {
                if ($prep->execute()) {
                    echo 'Wijziging opgeslagen';
                    header("Refresh:5; url=accounts.php", true, 303);
                }
           }
        }
        
    
    
    
?>