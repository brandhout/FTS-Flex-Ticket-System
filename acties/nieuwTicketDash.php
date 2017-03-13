<?php
session_start();
require_once '../header.php'; //Include de header.
require_once '../functies.php'; //Include de functies.

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Nieuw Ticket</title>
        <script>
            function nieuwBedrijf(){
                window.open('/ticketsysteem/admin/invoerBedrijf.php?popup=1','Nieuwbedrijf', 'width=400,height=525,scrollbars=yes,toolbar=no,location=no');
            }
            
            function nieuwKlant(){
                window.open('/ticketsysteem/acties/nieuwKlant.php?popup=1','Nieuweklant', 'width=400,height=525,scrollbars=yes,toolbar=no,location=no');
            }

        </script>

    </head>
    <body>
    <div class="container-fluid2">    
<div class="border row">
    <div class="border col-sm-3"></div>
        <div class="border col-sm-3">
            <input type="submit" name="but1" class="w3-button w3-large w3-blue w3-ripple" value="nieuwe klant" onclick="nieuwKlant()">
        </div>
        <div class="border col-sm-3">
            <input type="submit" name="but2" class="w3-button w3-large w3-blue w3-ripple" value="nieuw bedrijf" onclick="nieuwBedrijf()">
        </div>
    <div class="border col-sm-3"></div>
</div></div><br>
        
<?php
include 'nieuwTicketBestKlant.php';
?>

    </body>
</html>
