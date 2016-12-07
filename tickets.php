<?php

include_once 'header.php';
include_once 'functies.php';
 ?>

 <!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Tickets</title>
  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
  <link rel="stylesheet" href="Styles.css" type="text/css">
  </head>
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

