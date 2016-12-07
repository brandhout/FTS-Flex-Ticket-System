<?php
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; // Zet de header bovenaan deze pagina.
?>

<form name="nieuwaccount" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          Naam <br>
          <input type="text" name="Naam"><br>
          Beschrijving <br>
          <input type="text" name="Wachtwoord"><br>
          <input type="submit" name="zoeken" value="zoeken"><br>    
      </form>
