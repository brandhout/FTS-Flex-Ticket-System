<html>

    
    <body>
<header>
  <img class="logo2" src="fts.PNG">
</header>





<?php

session_start();
unset ($_SESSION['gebruikersNaam']);
session_destroy();
echo 'u bent uitgelogd';
header("Refresh:3 ;  URL=inloggen.php");
?>

        
    </body>
</html>