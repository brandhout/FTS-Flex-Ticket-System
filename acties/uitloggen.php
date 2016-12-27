<html>

    
    <body>
        <header>
          <img class="logo2" src="../fts.PNG">
        </header>

    </body>
</html>

<?php

session_start();
unset ($_SESSION['gebruikersNaam']);

session_destroy();
echo" u bent uitgelogd" . $uitkomst['gebruikersNaam'];
//echo ($_POST['gebruikersNaam'] . "is uitgelogd");

header("Refresh:2 ;  URL=inloggen.php");

?>

        
   