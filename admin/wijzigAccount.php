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
                $_SESSION['wActief'] = $account['actief'];
                echo '<p><strong>Wijzig accounts</strong></p>
                    <hr>
                        <div class="container">
                            <div class="inner contact">  
                                <div class="grid">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>
                                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                                        ';
                                        echo '<form name="wijzigaccount" action="';
                                        echo htmlspecialchars($_SERVER["PHP_SELF"]) . '"method="POST"';
                                        //echo 'wijzigAccount.php' . '" method="POST"';

                                        echo '<br>';

                                        echo 'Accountnummer <br><input type="text" class="form" name="accountNr" value="';
                                        echo htmlspecialchars($account["accountNr"]) . '" readonly /><br><br>';

                                        echo 'Voornaam <br><input type="text" class="form" name="naam"value="';
                                        echo htmlspecialchars($account["naam"]) . '"/><br><br>';

                                        echo 'Achternaam <br><input type="text" class="form" name="achterNaam"value="';
                                        echo htmlspecialchars($account["achterNaam"]) . '"/><br><br>';



                                        echo 'Lijnnummer<br><!-- moet nog opgeslagen worden in de database net als de rest -->
                                                <select class="form" name="lijnNr">
                                                  <option>1</option>
                                                  <option>2</option>
                                                  <option>3</option>
                                                  </select><br><br></div>';


                                        echo '<div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                                            Vestiging <br> <!-- Moet nog gescript worden! Data moet uit database komen -->
                                            <select class="form" name="vestigingId">
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

                                        echo 'Gebruikersnaam <br><input type="text" class="form" name="gebruikersNaam" value="';
                                        echo htmlspecialchars($account["gebruikersNaam"]) . '"/><br><br>';

                                        echo 'Wachtwoord <br><input class="form" type="password" name="wachtwoord" value="';
                                        echo '"pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$"/><br><br>';

                                        if($account['actief'] === '0'){
                                            echo '<button name="actief" type="submit" class="form-btn semibold" value="">Account op actief zetten</button><br><br>';
                                        }    


                                         if($account['actief'] === '1'){
                                            echo '<button name="nonActief" type="submit" class="form-btn semibold" value="">Account op on-actief zetten</button><br><br>';

                                        }    

                                        echo' <input type="submit" class="form-btn semibold" name="accountActie" value="Opslaan">
                        
                    </form></div><div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div></div></div></div></div><hr>';
            }
        }
    }
    if ( !empty($_POST)){
        //echo $_POST["isAdmin"];
        if (isset($_POST["isAdmin"]))  {
            $admin = 1;
        } else { 
            $admin = 0;
        }

        $wActief = $_SESSION['wActief'];

        if(isset($_POST['actief'])){
            $wActief = 1;
        }    
        if(isset($_POST['nonActief'])){
            $wActief = 0;
        }

        $accountNr = $connectie->real_escape_string($_POST['accountNr']);
        $naam = $connectie->real_escape_string($_POST['naam']);
        $achterNaam = $connectie->real_escape_string($_POST['achterNaam']);
        $gebruikersNaam = $connectie->real_escape_string($_POST['gebruikersNaam']);

        if(is_numeric($_POST['lijnNr'])){
            $lijnNr = $_POST['lijnNr'];
        }
        
        if(is_numeric($_POST['accountNr'])){
            $accountNr = $_POST['accountNr'];
        }

        if(!empty($_POST["wachtwoord"])){
            $hashin = password_hash($_POST["wachtwoord"], PASSWORD_BCRYPT);
            $updateAccount = "UPDATE account SET accountNr='{$accountNr}', lijnNr='{$lijnNr}', isAdmin='$admin', actief='$wActief', naam='{$naam}', achterNaam='{$achterNaam}', vestigingId='{$_POST['vestigingId']}', gebruikersNaam='{$gebruikersNaam}', wachtwoord='$hashin' WHERE accountNr='{$accountNr}' ";
        } else {
            $updateAccount = "UPDATE account SET accountNr='{$accountNr}', lijnNr='{$lijnNr}', isAdmin='$admin', actief='$wActief', naam='{$naam}', achterNaam='{$achterNaam}', vestigingId='{$_POST['vestigingId']}', gebruikersNaam='{$gebruikersNaam}' WHERE accountNr='{$accountNr}' ";

        }     

    //echo $updateAccount;
    $prep = $connectie->prepare($updateAccount);
        if ($prep) {
            if ($prep->execute()) {
                echo '
                 <script> location.replace("accounts.php"); </script>';
                die();
            }
       }
    } 
?>
