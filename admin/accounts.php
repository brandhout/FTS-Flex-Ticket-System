<?php 
    session_start();
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
        die();
    }
    
    require_once '../functies.php'; //Include de functies.
    require_once '../header.php'; //Include de header.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $connectie = verbinddatabase();
    error_reporting(E_ALL);
    
    
    $alleenActief = FALSE;
    $alleenNonActief = FALSE;
    // query voor het selecteren van alles van account
    $accountQuery = "SELECT * FROM account";
        $accountUitkomst = $connectie->query($accountQuery);
        
    $td = '</td><td align="left">';
    
    echo '
        <html>
            <head>
                <h1>Accountlijst</h1>
            </head>
            <body>
<a href="/ticketsysteem/admin/nieuwAccount.php">nieuw account</a><br><br>
<table id="example" class="display" cellspacing="0" width="100%">
<thead><tr>
                        <td align="left"><strong>Account nr</strong></td>
                        <td align="left"><strong>Gebruikersnaam</strong></td>
                        <td align="left"><strong>Voornaam</strong></td>
                        <td align="left"><strong>Achternaam</strong></td>
                        <td align="left"><strong>Schoolklas</strong></td>
                        <td align="left"><strong>Admin</strong></td>
                        <td align="left"><strong>Actief</strong></td>
                        <td align="left"><strong>Laatste inlogdatum</strong></td>
                        <td align="left"><strong>Lijn nr</strong></td>
                            <td><strong>Actie</strong><td></tr></thead>
                        <tfoot><tr>
                        <td align="left"><strong>Account nr</strong></td>
                        <td align="left"><strong>Gebruikersnaam</strong></td>
                        <td align="left"><strong>Voornaam</strong></td>
                        <td align="left"><strong>Achternaam</strong></td>
                        <td align="left"><strong>Schoolklas</strong></td>
                        <td align="left"><strong>Admin</strong></td>
                        <td align="left"><strong>Actief</strong></td>
                        <td align="left"><strong>Laatste inlogdatum</strong></td>
                        <td align="left"><strong>Lijn nr</strong></td>    
                        <td><strong>Actie</strong><td></tr></tfoot><tbody>
    ';
    //als u=accountuitkomst is uitgevoerd dan zet ie accountuitkomst in account
    if($accountUitkomst){
        while($account = $accountUitkomst->fetch_assoc()){
            $schoolKlas['schoolKlasCode'] = "NVT";
            $isAdmin = "Nee";
            if($account['schoolKlasId'] > 0){//als schoolklasid groter is dan nul dan neem var over van db
                $schoolKlasId = $account['schoolKlasId'];            
                    $schoolKlasQuery = "SELECT schoolKlasCode FROM schoolKlassen WHERE schoolKlasId = $schoolKlasId";
                    $schoolKlasUitkomst = $connectie->query($schoolKlasQuery);
                    if(!$schoolKlas = $schoolKlasUitkomst->fetch_assoc()){
                        echo "Schoolklas query mislukt..." . mysqli_error($connectie);
                    }
            }//controleerd of admin is
            if($account['isAdmin'] === "1"){
                $isAdmin = "Ja";
            } else {
                $isAdmin = "Nee";
            }
            // controlleert of atief account is
            if($account['actief'] === '1'){
                $actief = "Ja";
            } else {
                $actief = "Nee!";
            }
            //controleert of diegene mag inloggen
            if($account['magInloggen'] === '1'){
                $magInloggen = "Ja";
            } else {
                $magInloggen = "Nee";
            }
            
            echo '<tr><td align=left">' .
                $account['accountNr'] . $td .
                $account['gebruikersNaam'] . $td .
                $account['naam'] . $td .
                $account['achterNaam'] . $td .
                $schoolKlas['schoolKlasCode'] . $td .
                $isAdmin . $td .
                $actief . $td .
                datumOmzet($account['laasteKeerIngelogd']) . $td .
                $account['lijnNr'] . $td ;            
            echo '
                <form action="wijzigAccount.php">
                    <button name="accountActie" type="submit" value="Wijzig'. $account['accountNr'] .'">Wijzigen</button>' . 
                    //<button name="accountActie" type="submit" value="Verwijder'. $account['accountNr'] .'">Verwijderen</button>
                '</form></td>';
            
            echo '<td>    
                <form action="verwijderAccount.php">
                    <button name="verwijderActie" type="submit" value="Verwijder'. $account['accountNr'] .'">Verwijderen</button>' .
                '
                </form></td></tr>';
        }
    }
    echo'</tbody></table>';
?>

