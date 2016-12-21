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

require_once '../functies.php'; //Include de functies.
require_once 'headertwee.php'; //Include de header.

?>

<!-- Als je op tickets.php een ticket opent, komt de ticket op deze pagina te staan, met de informatie uit de database.
Je kan hier ook nieuw commentaar aanmaken, en oplossingen aandragen. Door de eerste behandelaar kan die definitief verklaard
worden. Er kan dus aan een ticket meerdere stukken commentaar en oplossingen hangen! Mocht de echte ticket aangepast worden
wordt de gebruiker doorgestuurd naar wijzigTicket.php. Dit alleen als er bijvoorbeeld een fout gemaakt is.-->
<!DOCTYPE html>
<html>
<h1> Ticketinfo </h1>
<body>
<form name="leesTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    
          trefwoorden (aan elkaar, door komma gescheiden) <br> <!-- Afwijkende gegevensfilter. Trefwoorden moeten in kommagescheiden Array -->
          <input type="text" name="Beschrijving" disabled><br><br>
          
          Probleem (korte omschrijving) <br>
          <textarea id="probleem" rows="10" cols="90" disabled></textarea><br><br>

          <h3> Klant </h3>
                    
          klant (Achternaam) <br>
          <input type="text" name="klantAchterNaam" disabled><br><br>
          
          klant (Voornaam) <br>
          <input type="text" name="klantNaam" disabled><br><br>

          klant (Adres) <br>
          <input type="text" name="klantAdres" disabled><br><br>
          
          klant (Postcode) <br>
          <input type="text" name="klantPostc" disabled><br><br>

          klant (Woonplaats) <br>
          <input type="text" name="klantStad" disabled><br><br>

          
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
