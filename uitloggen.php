<html>

    
    <body>
        <header>
          <img class="logo2" src="fts.PNG">
        </header>

    </body>
</html>

<?php

session_start();
unset ($_SESSION['gebruikersNaam']);

session_destroy();
echo" u bent uitgelogd";
//echo ($_POST['gebruikersNaam'] . "is uitgelogd");

header("Refresh:3 ;  URL=acties/inloggen.php");

?>

        
   