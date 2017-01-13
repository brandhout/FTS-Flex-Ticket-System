<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['but1'])) {
    include 'nieuwTicketNieuwKlant.php';
    
}


if (isset($_POST['but2'])) {
    include 'nieuwTicketBestKlant.php';
}

?>

<!DOCTYPE html>
<html>
    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="but1" value="nieuwe klant">
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="but2" value="bestaande klant">
        </form>


    </body>
</html>
