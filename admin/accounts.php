<?php 
    require_once '../functies.php'; //Include de functies.
    require_once 'headerUp.php'; // Zet de header bovenaan deze pagina.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $connectie = verbinddatabase();
    error_reporting(E_ALL);
    session_start();
    
    $alleenActief = FALSE;
    $alleenNonActief = FALSE;
    
    $accountQuery = "SELECT * FROM account";
        $accountUitkomst = $connectie->query($accountQuery);
        
    $td = '</td><td align="left"></a>';
    
    echo '
        <html>
            <head>
                <h1>Acountlijst</h1>
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
            
            $schoolKlasId = $account['schoolKlasId'];
            
            $schoolKlasQuery = "SELECT * FROM schoolKlassen WHERE schoolKlasId = $schoolKlasId"
            
            echo '<tr><td align=left"><a href=wijzigAccount.php?account='. $account['accountNr'] .' >' .
                $account['accountNr'] . $td .
                $account['gebruikersNaam'] . $td .
                $account['naam'] . $td .
                $account['achterNaam'] . $td .
                $account['schoolKlasId'] . $td .
                $account['isAdmin'] . $td .
                $account['actief'] . $td .
                $account['magInloggen'] . $td .
                $account['lijnNr'] . $td;
                echo '<tr>';
        }
    }       
?>

