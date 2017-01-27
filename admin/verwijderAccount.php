<html>
    <body>

        
    <?php
        session_start();
        require_once '../functies.php'; //Include de functies.
        require_once '../header.php'; //Include de header.
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        $connectie = verbinddatabase();
        error_reporting(E_ALL);
        
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
    }
        
        if(isset($_GET['verwijderActie'])){

            $accountNr = filter_var($_GET['verwijderActie'], FILTER_SANITIZE_NUMBER_INT);
            
            $wAccountQuery = "SELECT * FROM account WHERE accountNr = $accountNr";
            $wAccountUitkomst = $connectie->query($wAccountQuery);
            if( $wAccountUitkomst ){
                while($account = $wAccountUitkomst->fetch_assoc()){
                    
                    $verwijderstring = 'Wilt u onderstaand account verwijderen? <br><br>' .
                            '<table><tr><td>Accountnummer: </td><td>' . $account["accountNr"] . '</td><tr>' . 
                            '<td>Voornaam: </td><td>' . $account["naam"] . '</td><tr>' . 
                            '<td>Achternaam: </td><td>' . $account["achterNaam"] . '</td><tr>' . 
                            '<td>Gebruikersnaam: </td><td>' . $account["gebruikersNaam"] . '</td></table><br>';
                    
                    echo $verwijderstring;
                    echo '
                        <form action="verwijderAccount.php">
                            <tr>
                            <button name="accountActie" type="submit" value="ja' . $account['accountNr'] .'">JA</button>
                            <button name="accountActie" type="submit" value="nee' . $account['accountNr'] . '">NEE</button>
                            </tr>
                        </form>'; 
                }
            }
  
        }  
        if(isset($_GET['accountActie'])){
            $delete = FALSE;
            if(strpos($_GET['accountActie'],'ja') !== FALSE){
                $delete = TRUE;
            }
            if(strpos($_GET['accountActie'],'nee') !== FALSE){
                $delete = FALSE;
                header("Refresh:0; url=accounts.php", true, 303);

            }
            $accountNr = filter_var($_GET['accountActie'], FILTER_SANITIZE_NUMBER_INT);

            if( $delete == TRUE ){
                $verwijderQuery = "DELETE FROM account WHERE accountNr = " . $accountNr;
                $verwijderResult = $connectie->query($verwijderQuery);
                echo "Account verwijderd";
                header("Refresh:3; url=accounts.php", true, 303);
                
            }
        }

    ?>

    </body>
</html>

