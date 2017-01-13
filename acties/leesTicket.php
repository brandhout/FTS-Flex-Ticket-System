<?php
    /* 
     * This program is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 3 of the License, or
     * (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License
     * along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

     /*
      * TODO:
      * - Nieuw commentaar
      * - Nieuwe oplossing
      * - Oplossing definitief kunnen zetten (mits eerste behandelaar)
      */

    session_start();
    require_once 'headerUp.php'; //Include de header.
    require_once '../functies.php'; //Include de functies.
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    $connectie = verbinddatabase();
    $opgelost = FALSE;
    $fstAccount = FALSE;
    $status = "Open";
    
    if (is_numeric($_GET['ticket'])) {
        $ticketId = $_GET['ticket'];
    }
    
    $ticketQuery = "SELECT * FROM ticket WHERE ticketId = '$ticketId'";
        $ticketUitkomst = $connectie->query($ticketQuery);
        $ticket = $ticketUitkomst->fetch_assoc();
        
    $doorstuurLogQuery = "SELECT * FROM doorsturing WHERE ticketId = '$ticketId'";
        $doorstuurLogUitkomst = $connectie->query($doorstuurLogQuery);
        
    $klantId = $ticket['klantId'];
        $klantQuery ="SELECT * FROM klant WHERE klantId = '$klantId'";
        $klantUitkomst = $connectie->query($klantQuery);             
        $klant = $klantUitkomst->fetch_assoc();
        
    $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
        $oplossingUitkomst = $connectie->query($oplossingQuery);
        
    $commentaarQuery = "SELECT * FROM commentaar WHERE ticketId = '$ticketId'";
        $commentaarUitkomst = $connectie->query($commentaarQuery);
        
    if(checkDefinitief($ticketId)){
        $opgelost = TRUE;
        $status = "Gesloten";
    }
    
    if(overDatum($ticket['streefdatum'])){
        $overDatum = TRUE;
        $status = '<p style="color:red">
                    Te laat,';
        if (!$opgelost){
            $status .= 'Open</p>';
        } else {
            $status .= 'Gesloten</p>';
        }
        if ($ticket['redenTeLaat'] === NULL){
            $status .= '
                        <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
                            <input type="text" name="redenTekst" value="Reden ticket te laat" maxlength="70" required>
                            <button name="reden" type="redenSubmit" value="lijnDwn">Bevestig</button>';
        }
    }
   
    $accountNr = $_SESSION["accountNr"]; 
    
        if($_POST['lijnUp'] === "lijnUp" && $ticket['lijnNr'] <= 3 ){
            $opmerking = $_POST['opmerking'];
            $vanLijn = $ticket['lijnNr'];
            $naarLijn = $vanLijn+1;           
            updateLijn($vanLijn, $naarLijn, $opmerking, $ticketId, $accountNr);                               
        }
        
        if($_POST['lijnDwn'] === "lijnDwn" && $ticket['lijnNr'] >1){
            $opmerking = $_POST['opmerking'];
            $vanLijn = $ticket['lijnNr'];
            $naarLijn = $vanLijn-1;
            updateLijn($vanLijn, $naarLijn, $opmerking, $ticketId, $accountNr);
        }
        
        if(isset($_POST['nogBellen'])){
            if($_POST['nogBellen'] === "0"){
                updateNogBellen("0",$ticketId);
            }
            if($_POST['nogBellen'] === "1"){
                updateNogBellen("1",$ticketId);
            }            
            header("Location: ../index.php");
        }
        
        if(isset($_POST['redenTekst'])){
            $ticketId = $ticket['ticketId'];
            $redenTekst = $_POST['redenTekst'];
            $teLaatRedenQuery = "UPDATE ticket SET redenTeLaat = '$redenTekst' WHERE ticketId = '$ticketId'";
            if(!$connectie->query($teLaatRedenQuery)){
                echo "teLaatReden query mislukt..." . mysqli_error($connectie);
            }
            header("Location: ../tickets.php");
        }
           
    echo '
        <!DOCTYPE html>
        <html>
        <head>
        <title>Ticket Informatie FTS</title>
        <body>
        <h1> Ticketinfo 
         ticketnummer: '. $ticketId . ' </h1><br>
        <h3> Probleem: </h3> '.$ticket['probleem'].'<br>
        <h3> Trefwoorden: </h3> '.$ticket['trefwoorden'].'
        <h3> Status: </h3> '.$status.'
        <h3> Streefdatum: </h3> '.$ticket['streefdatum'].'';  
            
    if($ticket['lijnNr'] === $_SESSION['lijnNr'] or $_SESSION['isAdmin'] === "1"){
        echo '
            <h3> Doorsturing: </h3>
            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
            <p><strong> Lijn '.$ticket['lijnNr'].' </strong></p>
            <input type="text" name="opmerking" value="Reden doorsturing" maxlength="70" required>     
            ';

        if($ticket['lijnNr'] > 1 && $ticket['lijnNr'] <= 3) {
            echo '
                <button name="lijnDwn" type="submit" value="lijnDwn">Lijnomlaag</button> ';
            }
            
        if($ticket['lijnNr'] < 3) {
            echo '
                <button name="lijnUp" type="submit" value="lijnUp">Lijnomhoog</button> ';
            }            
            echo'
                </form>';            
    } else {
        echo '
        <h3> Behandelaar </h3><strong>
        '.leesAccountAchterNaam($ticket['fstAccountNr']).'</strong><br>
        Accountnummer <strong>'.$ticket['fstAccountNr'].'</strong>';
        
    }
        
        echo '
        <h2> Klant </h2>
        <h3> Achternaam: </h3> '.$klant['klantAchternaam'].'
        <h3> Voornaam: </h3> '.$klant['klantNaam'].'
        <h3> Telefoon: </h3> '.$klant['klantTel'].'';
        
        echo '<form action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';
        
        if($ticket['nogBellen'] === "1"){
            echo '<br>Klant <strong>moet nog</strong> gebeld worden! <br>
                <button name="nogBellen" type="submit" value="0">Klant is gebeld</button>';

        } else {
            echo '
                Klant <strong>hoeft niet</strong> gebeld te worden <br>
                <button name="nogBellen" type="submit" value="1">Klant moet gebeld worden</button>
                </form>
                ';
        }
        echo'
        <h3> Adres: </h3> '.$klant['klantAdres'].'
        <h3> Postcode: </h3> '.$klant['klantPostc'].'
        <h3> Woonplaats: </h3> '.$klant['klantStad'].'
        <h3> Emailadres: </h3> '.$klant['klantEmail'].'<br><br>
        <h2> Logboek: </h2>
        Ticket is op <strong>'.$ticket['datumAanmaak'].'</strong> aangemaakt door <strong>'.leesAccountAchterNaam($ticket['fstAccountNr']).'</strong><br><br>';
        
        if($overDatum){
            echo'
                Sinds <strong>'.$ticket['streefdatum'].'</strong> is deze ticket te laat,';
            if($ticket['redenTeLaat'] === NULL){
                echo '
                    reden nog niet ingevuld<br>';
            } else {
                echo '<br>reden: <i> '.$ticket['redenTeLaat'].'</i><br>';
            }
        }
       
        
        echo '<h3> Doorsturingen </h3>';
        
        while($doorstuurLog = $doorstuurLogUitkomst->fetch_assoc()){
            echo '- Ticket is op <strong>'.$doorstuurLog['datum'].'</strong> doorgestuurd
                    van Lijn <strong>'.$doorstuurLog['vanLijn'].'</strong>
                    naar Lijn <strong>'.$doorstuurLog['naarLijn'].'</strong>
                    door <strong>'.leesAccountAchterNaam($doorstuurLog['accountNr']).'</strong><br>
                    met <strong>accountnr: '.$doorstuurLog['accountNr'].'</strong> reden: <i>'.$doorstuurLog["opmerking"].'
                    </i><br><br>';
                
        }
        
        echo '<h3> Oplossingen </h3>';
        
        while($oplossingen = $oplossingUitkomst->fetch_array()){
            echo '
                - Er is op <strong>'.$oplossingen['datumFix'].'</strong>
                een oplossing aangedragen
                door <strong>'.leesAccountAchterNaam($oplossingen['accountNr']).'</strong>
                <br>met <strong>accountnr: '.$oplossingen['accountNr'].'
                </strong><br><br>
                De oplossing luidt:<br><i>
                '.$oplossingen['oplossOmschrijving'].'
                </i><br>';
            
                if($oplossingen['definitief'] === "1"){
                    echo 'Deze oplossing is <strong>definitief</strong>,
                     de ticket is afgesloten<br>';                 
                } else {
                    echo 'Deze oplossing is <strong>niet</strong> definitief.<br>';
                    if($_SESSION['accountNr'] === $ticket['fstAccountNr']){
                        echo '
                            <p>
                            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                                <button type="submit" value="def">Definitief</button></p><br>                           
                        ';
                    }
                }

        }
        
        while($commentaar = $commentaarUitkomst->fetch_assoc()){
            echo'
                <h3> Commentaar </h3>
                - Er is op <strong>'.$commentaar['datum'].'</strong>
                commentaar aangeleverd door <strong>'.leesAccountAchterNaam($commentaar['accountNr']).'<br></strong>
                met <strong>accountnr: '.$commentaar['accountNr'].'</strong><br><br>
                Het commentaar luidt:<br><i>'.$commentaar['commOmschrijving'].'
                </i></strong><br>    
                ';
        }
      
        echo '<form name="leesTicket" action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';
      
?>
