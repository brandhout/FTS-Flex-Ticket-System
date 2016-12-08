<?php

include_once 'header.php';
include_once 'functies.php';




 ?>

 <!DOCTYPE html>
 <html>
  <body>
      
      <h2> Gevanceerd sorteren </h2>
      <form name="filterfunctie" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          Naam <br>
          <input type="text" name="Titel"><br>
          Beschrijving <br>
          <input type="text" name="Beschrijving"><br>
          <input type="submit" name="zoeken" value="zoeken"><br>    
      </form>
      
      
  </body>
</html>

