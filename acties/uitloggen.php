<html>

    
    <body>
        <header>
          <img class="logo2" src="../fts.png">
        </header>

    </body>
</html>

<?php

session_start();
if (isset($_SESSION["uitlogReden"])){
    $uitlogReden = $_SESSION["uitlogReden"];
    $refresh = "refresh:9";
} else {
    $refresh = "refresh:2";
}
unset ($_SESSION['gebruikersNaam']);

session_destroy();
echo "u bent uitgelogd<br><strong><p style='color:red'>" . $uitlogReden . "</strong><p>";
//echo ($_POST['gebruikersNaam'] . "is uitgelogd");

header("$refresh ;  URL=inloggen.php");

?>

        
   