<?php 
    session_start();
    require_once '../functies.php'; //Include de functies.
    require_once 'headerUp.php'; // Zet de header in deze pagina.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $connectie = verbinddatabase();
    error_reporting(E_ALL);
    
    
    $alleenActief = FALSE;
    $alleenNonActief = FALSE;
    
    $accountQuery = "SELECT * FROM account";
        $accountUitkomst = $connectie->query($accountQuery);
        
    $td = '</td><td align="left"></a>';
    
    echo '
        <html>
            <head>
                <h1>Accountlijst</h1>
            </head>
            <body>         
                    <table align="left" cellspacing="5" cellpadding="8">
                        <td align="left"><strong>Account nr</strong></td>
                        <td align="left"><strong>Gebruikersnaam</strong></td>
                        <td align="left"><strong>Voornaam</strong></td>
                        <td align="left"><strong>Achternaam</strong></td>
                        <td align="left"><strong>Schoolklas</strong></td>
                        <td align="left"><strong>Admin</strong></td>
                        <td align="left"><strong>Actief</strong></td>
                        <td align="left"><strong>Mag inloggen</strong></td>
                        <td align="left"><strong>Lijn nr</strong></td></tr>
    ';
    if($accountUitkomst){
        while($account = $accountUitkomst->fetch_assoc()){
            $schoolKlas['schoolKlasCode'] = "NVT";
            $isAdmin = "Nee";
            if($account['schoolKlasId'] > 0){
                $schoolKlasId = $account['schoolKlasId'];            
                    $schoolKlasQuery = "SELECT schoolKlasCode FROM schoolKlassen WHERE schoolKlasId = $schoolKlasId";
                    $schoolKlasUitkomst = $connectie->query($schoolKlasQuery);
                    if(!$schoolKlas = $schoolKlasUitkomst->fetch_assoc()){
                        echo "Schoolklas query mislukt..." . mysqli_error($connectie);
                    }
            }
            if($account['isAdmin'] === "1"){
                $isAdmin = "Ja";
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
                $account['lijnNr'] . $td ;            
            echo '
                <form action="wijzigAccount.php">
                    <button name="accountActie" type="submit" value="Wijzig'. $account['accountNr'] .'">Wijzigen</button>' . 
                    //<button name="accountActie" type="submit" value="Verwijder'. $account['accountNr'] .'">Verwijderen</button>
                '</form>';
            
            echo '<td>    
                <form action="verwijderAccount.php">
                    <button name="verwijderActie" type="submit" value="Verwijder'. $account['accountNr'] .'">Verwijderen</button>' .
                '<tr>
                </form>';
        }
    }       
?>

