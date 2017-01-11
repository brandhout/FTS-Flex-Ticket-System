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
    if(!$accountNr = $wAccountUitkomst->fetch_assoc ){
      echo "Wijzig account query mislukt..." . mysqli_error($connectie); 
    }
    echo '<tr><td align=left">' .
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
        
?>