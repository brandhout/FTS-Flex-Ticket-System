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
     * - Naamgeving onderstaande rechtrekken met database
     * - Logica van onderstaande realiseren (query's etc)
     * - Klanten toevoegen
     * - Laptops toevoegen
     */
    session_start();
    require_once 'functies.php'; //Include de functies.
    require_once 'header.php'; // Zet de header bovenaan deze pagina.
?>
<html>
    <header>
        <title> </title>
    </header>
    <body>
         
        <form name="nieuwaccount" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          voornaamaam <br>
          <input type="text" name="voornaam"><br>
          achternaam <br>
          <input type="text" name="acternaam"><br><br>
          
          <input type="checkbox" name="isLeerling" value="isLeerling" checked>Is een leerling<br><br>

                Klassencode (indien leerling!)  <br> <!-- Kan eventueel gescript worden. (indien leerling verschijnt dit) -->
                <input type="text" name="klas" disabled><br><br>
          
            vestiging/lokatie <br> <!-- Moet nog gescript worden! Data moet uit database komen -->
            <select name="vestiging">
              <option>Baarn</option>
              <option>Herman's achtertuinen</option>
              </select><br><br>

          <input type="submit" name="zoeken" value="zoeken"><br>    
        </form>
    </body>  
</html>    
