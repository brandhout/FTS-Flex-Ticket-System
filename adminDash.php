<?php
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; // Zet de header bovenaan deze pagina.
?>

<form name="nieuwaccount" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          voornaamaam <br>
          <input type="text" name="voornaam"><br>
          achternaam <br>
          <input type="text" name="acternaam"><br>
          Klas <br>
          <input type="text" name="klas"><br>

          <input type="submit" name="zoeken" value="zoeken"><br>    
      </form>
