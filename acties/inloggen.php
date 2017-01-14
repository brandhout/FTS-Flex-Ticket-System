<?php
    /* 
     * This program is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 3 of the License, or
     * (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     * GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License
     * along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    /*
     * TODO:
     * - Opmaak fixen
     * - (EVENTUEEL) versleuteling
     */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../functies.php'; //Include de functies.
    
    $connectie = verbinddatabase();
     

    if(isset($_POST['gebruikersNaam']) && isset($_POST['wachtwoord'])){
        //verkrijg de variabele uit het forum hieronder, de functies voorkommen SQL injectie
        $gebruikersNaam = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['gebruikersNaam'])));
        $wachtwoord = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['wachtwoord'])));
   
        $query = mysqli_query($connectie, "SELECT gebruikersNaam, wachtwoord, isAdmin, magInloggen, accountNr, lijnNr FROM account WHERE gebruikersNaam = '$gebruikersNaam'");
        $uitkomst = mysqli_fetch_array($query);
        $teller = mysqli_num_rows($query);

        if ($teller == 1 && $uitkomst['wachtwoord'] == $wachtwoord && $uitkomst['magInloggen'] == 1){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens

            // Inloggen succes, hier moet een sessie aangemaakt worden
            session_start();
            $_SESSION["gebruikersNaam"] = $uitkomst['gebruikersNaam'];
            $_SESSION["accountNr"] = $uitkomst['accountNr'];
            $_SESSION["isAdmin"] = $uitkomst['isAdmin'];
            $_SESSION["lijnNr"] = $uitkomst['lijnNr'];
            header('Location: ../index.php'); 
            
        } else {
            echo "foute gegevens!";
            return FALSE;
        }}
?>
<html>    
    <head>
        <meta charset="UTF-8">
        <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
        <link rel="stylesheet" href="../styles.css" type="text/css"> <!-- Tijdelijke oplossing voor het includen van de style in hogere mappen -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        
            <!--bootstrap--> 
  <link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">
  <script src="../styles/js/bootstrap.min.js"></script>
    </head>
    <header>
        <img src="../fts.PNG" class="logo2">
    </header>
    
    <body>
        <br><br><br>    
        
        <div class="inlogalgemeen1">
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <input id="inlog1" type="text" name="gebruikersNaam" required placeholder="Vul hier uw gebruikersnaam in*"><span id="message1" ></span><br>
                <input type="password" name="wachtwoord" required placeholder="Vul hier uw wachtwoord in*"><span id="message2" ></span><br>
                <input type="submit" value="Submit">                  
            </form>
        </div>
        
    </body>
</html>

