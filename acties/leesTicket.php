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
      * - Oplossing definitief kunnen zetten (mits eerste behandelaar
      */

    session_start();
    require_once 'headerUp.php'; //Include de header.
    require_once '../functies.php'; //Include de functies.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $connectie = verbinddatabase();
    $opgelost = "Nee";
    
    if (is_numeric($_GET['ticket'])) {
        $ticketId = $_GET['ticket'];
    }
    
    $ticketQuery = "SELECT * FROM ticket WHERE ticketId = '$ticketId'";
        $ticketUitkomst = $connectie->query($ticketQuery);
        $ticket = $ticketUitkomst->fetch_assoc();
        
    $klantId = $ticket['klantId'];
        $klantQuery ="SELECT * FROM klant WHERE klantId = '$klantId'";
        $klantUitkomst = $connectie->query($klantQuery);             
        $klant = $klantUitkomst->fetch_assoc();
        
    $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
        $oplossingUitkomst = $connectie->query($oplossingQuery);
            while($oplossing = $oplossingUitkomst->fetch_assoc()){
                if($oplossing['definitief'] === "1"){
                    $opgelost = "Ja";
                }
            }

        
    $accountNr = $_SESSION["accountNr"]; 
       
    echo '
        <!DOCTYPE html>
        <html>
        <body>
        <h1> Ticketinfo 
         ticketnummer: '. $ticketId . ' </h1><br>
        <h3> Probleem: </h3> '.$ticket['probleem'].'<br>
        <h3> Trefwoorden: </h3> '.$ticket['trefwoorden'].'
        <h3> Opgelosd: </h3> '.$opgelost.'
        <h3> Streefdatum: </h3> '.$ticket['streefdatum'].'';  
            
    if($_SESSION['accountNr'] === $ticket['fstAccountNr']){
        echo '
            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
            <p><strong> Doorsturingssysteem: </strong></p>';

        if($ticket['lijnNr'] > 1) {
            echo '
                <button name="lijnDwn" type="submit" value="lijnDwn">Lijnomlaag</button> ';
            }
            
        if($ticket['lijnNr'] < 2) {
            echo '
                <button name="lijnUp" type="submit" value="lijnUp">Lijnomhoog</button> ';
            }            

            echo'
                </form>';
            
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
                Klant <strong>hoeft niet</strong> gebeld te worden
                <button name="nogBellen" type="submit" value="1">Klant moet gebeld worden</button>
                </form>
                ';
        }
        echo'
        <h3> Adres: </h3> '.$klant['klantAdres'].'
        <h3> Postcode: </h3> '.$klant['klantPostc'].'
        <h3> Woonplaats: </h3> '.$klant['klantStad'].'
        <h3> Emailadres: </h3> '.$klant['klantEmail'].'
        ';
        

        if(isset($_POST['lijnUp'])){
            // De query om de lijn omhoog te gooien
            $lijnUpQuery = "INSERT INTO doorsturing (vanLijn = $vanLijn, accountNr = $accountNr
                datum = CURRENT_DATE, naarLijn = $naarLijn, ticketId = $ticketId";
            
            if(!$connectie->query($lijnUpQuery)){
                echo "LijnUP query mislukt..." . $connectie->error();
            }
        }
        
        if(isset($_POST['lijnDwn'])){
            // De query om de lijn omlaag te werpen
            $lijnDwnQuery = "INSERT INTO terugsturing (vanLijn = $vanLijn, accountNr = $accountNr
                datum = CURRENT_DATE, naarLijn = $naarLijn, ticketId = $ticketId";
         
            if(!$connectie->query($lijnDwnQuery)){
                echo "LijnDwn query mislukt..." . $connectie->error();
            }           
        }
        
        if(isset($_POST['nogBellen'])){
            if($_POST['nogBellen'] === "0"){
                updateNogBellen("0",$ticketId);
            }
            if($_POST['nogBellen'] === "1"){
                updateNogBellen("1",$ticketId);
            }            
               header("Refresh:0");
        }               
        
        echo '<form name="leesTicket" action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';
      
?>

<!-- Als je op tickets.php een ticket opent, komt de ticket op deze pagina te staan, met de informatie uit de database.
Je kan hier ook nieuw commentaar aanmaken, en oplossingen aandragen. Door de eerste behandelaar kan die definitief verklaard
worden. Er kan dus aan een ticket meerdere stukken commentaar en oplossingen hangen! Mocht de echte ticket aangepast worden
wordt de gebruiker doorgestuurd naar wijzigTicket.php. Dit alleen als er bijvoorbeeld een fout gemaakt is.-->

                 
          <h3>Veelvoorkomende laptop:</h3><br> <!-- Disabled, weinig tijd -->
          Merk
          <select name="vVLaptopMerk" disabled>
              <option></option>
              <option></option>
          </select><br><br>
          
          Type
          <select name="vVLaptopType" disabled>
              <option></option>
              <option></option>
          </select><br><br>
          
          
          <h3> Potentiele oplossing </h3>
            <textarea id="oplossing" rows="10" cols="90" ></textarea><br><br>
            
            <input type="checkbox" name="definitief" value="definitief">Oplossing is definitief<br><br>
        
            <h3> Eerder commentaar </h3>
            <p><strong> Bert Bartsen commenteerd op (datum):</strong><br>
                    Mevrouw van der berg heeft waarschijnlijk geen stroom in huis. </p>
            
              <p><strong> Jasper Mijnkipema commenteerd op (datum):</strong><br>
                      Doorsturen naar energie?? </p>

            
           <h3> Nieuw Commentaar </h3>
            <textarea id="nieuwComment" rows="10" cols="90"></textarea><br><br>
             
          <input type="submit" name="submit" value="submit">Doorvoeren<br>    
</form></body></html>
