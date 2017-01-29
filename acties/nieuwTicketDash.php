<?php
session_start();
require_once '../header.php'; //Include de header.
require_once '../functies.php'; //Include de functies.

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Nieuw Ticket</title>
    </head>
    <body>
    <div class="container-fluid2">    
<div class="border row">
    <div class="border col-sm-3"></div>
        <div class="border col-sm-3">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="but1" class="btna2" value="nieuwe klant">
        </form></div>
        <div class="border col-sm-3">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="but2" class="btna2" value="bestaande klant">
        </form></div>
    <div class="border col-sm-3"></div>
</div></div>
        
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
