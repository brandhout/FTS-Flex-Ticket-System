<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
require_once 'zoek.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connectie = verbinddatabase();
$output = '';


$fstAccountNr= $_SESSION['gebruikersNaam'];
$probleem= $_POST['probleem'];
$trefwoorden=$_POST['trefwoorden'];
$aantalXterug=NULL;
$terugstuurLock=FALSE;
$lijnNr=1;
$datumAanmaak= mysqldatum();
$nogBellen=FALSE;
$log=NULL;
$verlopen=FALSE;
$streefdatum=FALSE;
$binnenkomstType="tel";
$lokatie="standaard";
$klantTevreden=NULL;
$vVLaptopMerk=NULL;
$vVlaptopType=NULL;
$besturingssysteem="standaard";
$factuurNr=NULL;

    $OSQuery= 'select * from besturingssysteem';
    $OSLijst= mysqli_query($connectie, $OSQuery);
        //or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
    
if (!$_POST['submit1'] === "") {
    
    /*
     * Als submit niet leeg is wordt dit script uitgevoerd. Eerst word de ticketQuery
     * gedeclareerd. Daarna een if die uitgevoerd wordt als er een nieuwe klant is,
     * daarna eentje als er een bestaande klant gekozen is (niet leeg).
     * In beide statements wordt de klantId opgevraagd, of die nu van een bestaande
     * klant of nieuwe klant is, deze is namelijk nodig in de ticket.
     */
    
    $ticketQuery = "insert into ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
        probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
        aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = $datumAanmaak,
        nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
        log = $log, verlopen = $verlopen, streefdatum = $streefdatum,
        lokatie = $lokatie, klantTevreden = $klantTevreden"; 
    $nieuweKlantQuery = "insert into klant klantAchterNaam = $klantAchterNaam,
                klantNaam = $klantNaam, klantTel = $klantTel, klantAdres = $klantAdres, klantPostc = $klantPostc,
                klantStad = $klantStad, klantEmail = $klantEmail";
    echo 'ticket aangemaakt en registratie gelukt!';
}
else {
    echo 'niet gelukt';
}
 if (!$_POST['submit2'] === "") {
    
    /*
     * Als submit niet leeg is wordt dit script uitgevoerd. Eerst word de ticketQuery
     * gedeclareerd. Daarna een if die uitgevoerd wordt als er een nieuwe klant is,
     * daarna eentje als er een bestaande klant gekozen is (niet leeg).
     * In beide statements wordt de klantId opgevraagd, of die nu van een bestaande
     * klant of nieuwe klant is, deze is namelijk nodig in de ticket.
     */
    
    $ticketQuery = "insert into ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
        probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
        aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = $datumAanmaak,
        nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
        log = $log, verlopen = $verlopen, streefdatum = $streefdatum,
        lokatie = $lokatie, klantTevreden = $klantTevreden";                
               // $klantIdQuery = "select klantId from klant where $klantEmail = klantEmail";
               // $klantId = mysqli_query($connectie, $klantIdQuery);
 echo 'gelukt';}
 else {
     echo 'niet gelukt';
 }
      //  }
        
       // if (!$_POST['bestaandeKlant'] === "") {
            
                /*
                 * Als er een bestaande klant is (niet leeg)
                 * dan gaan we de klantid ophalen vanuit de achternaam.
                 */
            
               // $klantIdQuery = "select klantId from klant where $klantAchterNaam = klantAchterNaam";
               // $klantId = mysqli_query($connectie, $klantIdQuery);
        //}

            //$uitkomst= mysqli_query($connectie, $ticketQuery);
                //or die("Kan aangevraagde actie niet verwerken:" .mysql_error());  


            
            
  
            ?>


<!DOCTYPE html>
<html>

    <body>
        <h1> Nieuw ticket </h1>
        
        <!--  alle scripts  -->
            <script>
                function nieuwek(){
                                $(".hidden").toggle(300);
                }
                function bestaandek(){
                                $(".hidden2").toggle(300);
                }
                
                function zoekf(){
                    var zoektxt = $("input[name='zoek']").val();
                    $.post("zoek.php", {zoekval: zoektxt}, function(output){
                        $("#output").text(output);
                    });
                    
                }
            </script>

            <style>
                .hidden {
                    display:none;
                }
                .hidden2{
                    display:none;
                }
            </style>    
     
            <form name="nieuwTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <button onclick="nieuwek()" type="button" id="nk" >nieuwe klant </button>
                           
                    <label class="hidden">naam:</label><input id="text1" type="text" name="klantNaam" class="hidden"/><br>
                    <label class="hidden">achternaam:</label><input id="text1" type="text" name="klantAchterNaam" class="hidden"/><br>
                    <label class="hidden">adres:</label><input id="text1" type="text" name="klantAdres" class="hidden"/><br>
                    <label class="hidden">postcode:</label><input id="text1" type="text" name="klantPostc" class="hidden"/><br>			
                    <label class="hidden">woonplaats:</label><input id="text1" type="text" name="klantStad" class="hidden"/><br>
                    <label class="hidden">telefoonnummer:</label><input id="text1" type="text" name="klantTel" class="hidden"/><br>
                    <label class="hidden">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" value="nogBellen" class="hidden"/><br>
					
                    <label class="hidden">binnengekomen via:</label>
                        <select name="binnenkomstType" class="hidden"> <!-- Moet nog gescript worden! Data moet uit database komen -->
                            <option>Telefoon</option>
                            <option>E-mail</option>
                        </select><br>
                    <label class="hidden">locatie:</label>
                        <select name="locatie" class="hidden"> <!-- Disabled, gaan we nog niets mee doen-->
                            <option>Hilversum Soestdijkerstraatweg</option>
                            <option>uy</option>
                        </select><br>
                    <label class="hidden">trefwoorden (aan elkaar, door komma gescheiden)</label><input id="text1" type="text" name="trefwoorden" class="hidden"/></p>
			
                    <label class="hidden">categorie:</label>
                        <select name="categorie" class="hidden">
                            <option>Software</option>
                            <option>Hardware</option>
                        </select><br>
                    <label class="hidden">sub-categorie:</label>
                        <select name="subCategorie" class="hidden">
                            <option>Fedora Linux</option>
                            <option></option>
                        </select><br>
                    <label class="hidden">merk:</label>
                        <select name="vVLaptopMerk" class="hidden">
                            <option>1</option>
                            <option>2</option>
                        </select><br>
                    <label class="hidden">type:</label>
                        <select name="vVLaptopType" class="hidden">
                            <option>2</option>
                            <option>1</option>
                        </select><br>
                    <label class="hidden">besturingsysteem:</label>
                        <select name="besturingssysteem" class="hidden">
                            <?php
                                if ($OSLijst){
                                    while($OSrij = mysqli_fetch_array($OSLijst)) {
                                        echo '<option>' . $OSrij[besturingssysteem] . '</option>';
                                    }}
                            ?>
                            <option></option>
                        </select><br>

                    <label class="hidden">probleem(korte omschrijving:)</label>
                        <textarea id="probleem" class="hidden"></textarea>
                    <label class="hidden">commentaar:</label>
                        <textarea id="nieuwComment" class="hidden"></textarea>
                    <label class="hidden">potentieele oplossing:</label>
                        <textarea id="oplossing" class="hidden"></textarea>
                    <!--datepicker-->
                    <label class="hidden">streefdatum:</label>
                        <input type="date" id="datepicker" class="hidden"/></p>       
                        <input type="submit" name="submit1" value="invoeren" class="hidden" />
            </form>
  
  
            
            
            <form name="nieuwTicket2" action="nieuwTicket.php" method="POST">
                <button type="button" onclick="bestaandek()" id="bk">bestaandeklant</button><br>
                <input name='zoek' type="text" placeholder="zoeken in Achternaam"  onkeydown="zoekf();" class='hidden2'/><br>
                <label class="hidden2">klant ID:</label><textfield  type="text" id="output" name="klantId" class="hidden2"/></textfield><br>
                    <label class="hidden2">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" value="nogBellen" class="hidden2"/><br>
                
                     <label class="hidden2">binnengekomen via:</label>
                        <select name="binnenkomstType" class="hidden2"> <!-- Moet nog gescript worden! Data moet uit database komen -->
                            <option>Telefoon</option>
                            <option>E-mail</option>
                        </select><br>
                    <label class="hidden2">locatie:</label>
                        <select name="locatie" class="hidden2"> <!-- Disabled, gaan we nog niets mee doen-->
                            <option>Hilversum Soestdijkerstraatweg</option>
                            <option>uy</option>
                        </select><br>
                    <label class="hidden2">trefwoorden (aan elkaar, door komma gescheiden)</label><input id="text1" type="text" name="trefwoorden" class="hidden2"/></p>
			
                    <label class="hidden2">categorie:</label>
                        <select name="categorie" class="hidden2">
                            <option>Software</option>
                            <option>Hardware</option>
                        </select><br>
                    <label class="hidden2">sub-categorie:</label>
                        <select name="subCategorie" class="hidden2">
                            <option>Fedora Linux</option>
                            <option></option>
                        </select><br>
                    <label class="hidden2">merk:</label>
                        <select name="vVLaptopMerk" class="hidden2">
                            <option>1</option>
                            <option>2</option>
                        </select><br>
                    <label class="hidden2">type:</label>
                        <select name="vVLaptopType" class="hidden2">
                            <option>2</option>
                            <option>1</option>
                        </select><br>
                    <label class="hidden2">besturingsysteem:</label>
                        <select name="besturingssysteem" class="hidden2">
                            <?php
                                if ($OSLijst){
                                    while($OSrij = mysqli_fetch_array($OSLijst)) {
                                        echo '<option>' . $OSrij[besturingssysteem] . '</option>';
                                    }}
                            ?>
                            <option></option>
                        </select><br>

                    <label class="hidden2">probleem(korte omschrijving:)</label>
                        <textarea id="probleem" class="hidden2"></textarea>
                    <label class="hidden2">commentaar:</label>
                        <textarea id="nieuwComment" class="hidden2"></textarea>
                    <label class="hidden2">potentieele oplossing:</label>
                        <textarea id="oplossing" class="hidden2"></textarea>
                    <!--datepicker-->
                    <label class="hidden2">streefdatum:</label>
                        <input type="date" id="datepicker" class="hidden2"/></p>  
                    
                    
                    
                    <input type="submit"value=">>" name="submit2" class='hidden2' />
                    
                </form>
    </body>
</html>
