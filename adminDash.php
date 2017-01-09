<?php
    
    session_start();
    require_once 'functies.php'; //Include de functies.
    require_once 'header.php'; // Zet de header bovenaan deze pagina.
?>
<html>
    <head>
         <link rel="stylesheet" href="styles.css" type="text/css">
        <title> </title>
    </head>
    <body>
                 
        <div class="admindash">    
            <ul>
                <strong><li><a href="accounts.php">Account</a></li></strong>
                <br>
                <strong><li><a href="invoerAparaten.php">Aparaten invoer</a></li></strong>
            </ul>
        </div>
    </body>  
</html>    
