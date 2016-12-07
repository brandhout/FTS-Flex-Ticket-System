<?php
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; // Zet de header bovenaan deze pagina.
?>

<form name="nieuwaccount" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          voornaamaam <br>
          <input type="text" name="voornaam"><br>
          achternaam <br>
          <input type="text" name="acternaam"><br><br>
          
          <input type="checkbox" name="isLeerling" value="isLeerling" checked>Is een leerling<br><br>

                Klassencode (indien leerling!)  <br>
                <input type="text" name="klas" disabled><br><br>
          
            vestiging/lokatie <br> <!-- Moet nog gescript worden! Data moet uit database komen -->
            <select name="vestiging">
              <option>Baarn</option>
              <option>Herman's achtertuin</option>
              </select><br><br>

          <input type="submit" name="zoeken" value="zoeken"><br>    
      </form>
