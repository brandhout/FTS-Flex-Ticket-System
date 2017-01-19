<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.

?>

<!DOCTYPE html>
<html>
    <body>

        <div style="margin: 0 auto; width: 656px; text-align: center;">
        <div id="links">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="but1" class="form-btn semibold" value="nieuwe klant">
        </form></div>
<div id="rechts">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="but2" class="form-btn semibold" value="bestaande klant">
        </form></div></div>
        
        
<?php



if (isset($_POST['but1'])) {
    include 'nieuwTicketNieuwKlant.php';
    
}


if (isset($_POST['but2'])) {
    include 'nieuwTicketBestKlant.php';
}



?>

    </body>
</html>
