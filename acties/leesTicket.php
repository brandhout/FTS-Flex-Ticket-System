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

    
    echo '
        <!DOCTYPE html>
        <html>
        <body>
        <h1> Ticketinfo 
         ticketnummer: '. $ticketId . ' </h1><br>
        <h3> Probleem: </h3> '.$ticket['probleem'].'<br>
        <h3> Trefwoorden: </h3> '.$ticket['trefwoorden'].'
        <h3> Opgelosd: </h3> '.$ticket['oplossingId'].'
        <h3> Streefdatum: </h3> '.$ticket['streefdatum'].'
            
        <h2> Klant </h2>
        <h3> Achternaam: </h3> '.$klant['klantAchternaam'].'
        <h3> Voornaam: </h3> '.$klant['klantNaam'].'
        <h3> Telefoon: </h3> '.$klant['klantTel'].'
        <h3> Adres: </h3> '.$klant['klantAdres'].'
        <h3> Postcode: </h3> '.$klant['klantPostc'].'
        <h3> Woonplaats: </h3> '.$klant['klantStad'].'
        <h3> Emailadres: </h3> '.$klant['klantEmail'].'
            
        <h2> Oplossing </h2>



            
        

        '
?>

<!-- Als je op tickets.php een ticket opent, komt de ticket op deze pagina te staan, met de informatie uit de database.
Je kan hier ook nieuw commentaar aanmaken, en oplossingen aandragen. Door de eerste behandelaar kan die definitief verklaard
worden. Er kan dus aan een ticket meerdere stukken commentaar en oplossingen hangen! Mocht de echte ticket aangepast worden
wordt de gebruiker doorgestuurd naar wijzigTicket.php. Dit alleen als er bijvoorbeeld een fout gemaakt is.-->
<form name="leesTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
       
          <input type="checkbox" name="nogBellen" value="nogBellen" disabled>Klant moet nog gebeld worden<br><br>
          
          <h3> Categorieën </h3>
          
          Categorie <!-- Moet uit database komen -->
          <select name="categorie" disabled>
              <option>Software</option>
              <option>Hardware</option>
          </select><br><br>
          
          Subcategorie <!-- Disabled, voor later. -->
          <select name="subCategorie" disabled>
              <option>Fedora Linux</option>
              <option></option>
          </select><br>

          
          <h3> Streefdatum</h3>
          
                Dag <br>
                <select name="dag" disabled>
                <option>1</option>
                <option>2</option>
                </select><br><br>
          
                Maand <br>
                <select name="maand" disabled>
                <option>Januari</option>
                <option>Februari</option>
                </select><br><br>
          
                Jaar (2017) <br>
                <input type="text" name="jaar" disabled><br><br>

                     Binnenkomst type: 
          <select name="binnenkomstType" disabled> <!-- Moet nog gescript worden! Data moet uit database komen -->
              <option>Telefoon</option>
              <option>E-mail</option>
          </select><br><br>

                     Lokatie: 
              <br><select name="binnenkomstType" disabled><br> <!-- Disabled, gaan we nog niets mee doen-->
              <option>Hilversum Soestdijkerstraatweg</option>
              <option></option>
          </select><br>

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
          
          Besturingssysteem
          <br><select name="besturingssysteem" disabled>
              <option>Windows</option>
              <option>Linux</option>
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

            <?php
           if($_SESSION["accountNr"] == $uitkomst['accountNr']) {
                echo '<input type="checkbox" name="lijnOmhoog" value="lijnOmhoog" disabled>Ticket moet naar volgende lijn<br><br>';
                if($uitkomst['lijnNr'] > 1) {
                    echo '<input type="checkbox" name="lijnOmlaag" value="lijnOmlaag" disabled>Ticket moet naar vorige lijn<br><br>';
                }
           }
            ?>       
          <input type="submit" name="nieuwCommentaar" value="nieuwCommentaar"><br>    
</form></body></html>
