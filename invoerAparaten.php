<?php
    
    session_start();
    require_once 'functies.php'; //Include de functies.
    require_once 'header.php'; // Zet de header bovenaan deze pagina.
?>

 
<html>
    <header>
        <title> </title>
    </header>
    <body>
         
        <form name="nieuwaccount" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <h2><strong>Aparaten invoer</strong></h2>
            
            Categorie <br>
            <input type="text" name="categorie"><br><br>
            Subcategorie<br>
            <input type="text" name="subCategorie"><br><br>
            Veelvoorkomende laptop merken <br>
            <input type="text" name="VvLaptopMerken"><br><br>
            Veelvoorkomende laptop types <br>
            <input type="text" name="VvLaptopTypes"><br><br>
            Besturingssysteem <br>
            <input type="text" name="besturingssysteem"><br><br>

          <input type="submit" name="toevoegen" value="toevoegen"><br>    
        </form>
    </body>  
</html>   