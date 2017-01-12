<?php
    
   session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once 'header.php';
    include_once './functies.php';
    $connectie = verbinddatabase();
?>

 
<html>
    <header>
        <title>Nieuw account</title>
    </header>
    <body>
         
        <form name="nieuwaccount" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <h2><strong>Nieuwe accounts</strong></h2>
            
            <input type="checkbox" name="isLeerling" value="isLeerling" />Is een leerling
            <br><br>
            Voornaamaam <br>
            <input type="text" name="voornaam"><br><br>
            Achternaam <br>
            <input type="text" name="acternaam"><br><br>
            
            Lijnnummer<br><!-- moet nog opgeslagen worden in de database net als de rest -->
            <select name="lijnnummer">
              <option>Lijn 1</option>
              <option>Lijn 2</option>
              <option>Lijn 3</option>
              </select><br><br>
                           
            Vestiging/locatie <br> <!-- Moet nog gescript worden! Data moet uit database komen -->
            <select name="vestiging">
              <option>Baarn</option>
              <option>Herman's achtertuinen</option>
              </select><br><br>
              
            Gebruikersnaam <br>
            <input type="text" name="gebruikersnaam"><br><br>
            Wachtwoord <br>
            <input type="text" name="wachtwoord"><br><br>

          <input type="submit" name="opslaan" value="opslaan"><br>    
        </form>
    </body>  
</html>    


