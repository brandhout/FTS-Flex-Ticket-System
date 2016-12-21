<?php

require_once '../functies.php'; //Include de functies.
require_once '../headertwee.php'; //Include de functies. 
//verbinddatabase();


$fstAccountNr= $_SESSION["accountNr"];
$probleem= $_POST[probleem];
$trefwoorden=$_POST[trefwoorden];
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
    
    $leesKlantQuery= 'select klantAchterNaam from klant';
    $klantenLijst= mysqli_query($connectie, $leesKlantQuery);
        //or die("Kan aangevraagde actie niet verwerken:" .mysql_error())



if (!$_POST['submit'] === "") {
    
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
                
    
        if (isset($_POST['nieuweKlant'])) {
            
                /*
                 * Als er een nieuwe klant is, hebben we eerst een query die de klant aanmaakt.
                 * In de database word er een primary key gemaakt, die zien wij nog niet.
                 * Vandaar de query eronder die op basis van de (net aangemaakte) klant 
                 * email de primary key zoekt, van de klant die we zojuist hebben aangemaakt.
                 */
            
                $nieuweKlantQuery = "insert into klant klantAchterNaam = $klantAchterNaam,
                klantNaam = $klantNaam, klantTel = $klantTel, klantAdres = $klantAdres, klantPostc = $klantPostc,
                klantStad = $klantStad, klantEmail = $klantEmail";
                
                $klantIdQuery = "select klantId from klant where $klantEmail = klantEmail";
                $klantId = mysqli_query($connectie, $klantIdQuery);
    
        }
        
        if (!$_POST['bestaandeKlant'] === "") {
            
                /*
                 * Als er een bestaande klant is (niet leeg)
                 * dan gaan we de klantid ophalen vanuit de achternaam.
                 */
            
                $klantIdQuery = "select klantId from klant where $klantAchterNaam = klantAchterNaam";
                $klantId = mysqli_query($connectie, $klantIdQuery);
        }

            $uitkomst= mysqli_query($connectie, $ticketQuery);
                //or die("Kan aangevraagde actie niet verwerken:" .mysql_error());

        
        

    
}  

?>
<!DOCTYPE html>
<html>

    <body>
        <h1> Nieuw ticket </h1>


    
        <div class="form1">
     
            <form name="nieuwTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
<!--rij 1-->       
                <div class="a1"><p>Bestaande klant <!-- Moet uit database komen!! -->
                    <select name="bestaandeKlant">
                        <?php
                        if ($klantenLijst){
                            while($rij = mysqli_fetch_array($klantenlijst)) {
                                echo '<option>' . $rij[klantAchterNaam] . '</option>';
                        }}
                        ?>
                    </select>Nieuwe klant <!-- Als nieuwe klant aangevinkt is dan kunnen NAW gegevens ingevuld worden -->
                        <input type="checkbox" name="nieuwKlant" value="nieuwKlant"></p>
                </div>
                         
                <div class="a2"><p>trefwoorden (aan elkaar, door komma gescheiden)<!-- Afwijkende gegevensfilter. Trefwoorden moeten in kommagescheiden Array -->
                    <input id="text1" type="text" name="trefwoorden"></p>
                </div>
        
                <div class="a3"><p>streefdatum: 
                    <input id="datum1" type="date" id="datepicker"></p>
                </div>
                
<!--rij 2-->                
                <div class="a1"><p>Nieuwe klant (Voornaam)
                    <input id="text1" type="text" name="klantNaam" disabled></p>
                </div>
         
                <div class="a2"><p>Categorie <!-- Moet uit database komen -->
                    <select name="categorie" disabled>
                        <option>Software</option>
                        <option>Hardware</option>
                    </select><br>
                    Subcategorie <!-- Disabled, voor later. -->
                    <select name="subCategorie" disabled>
                        <option>Fedora Linux</option>
                        <option></option>
                    </select></p>
                </div>
         
                <div class="a3"><p>telefoonnummer klant:
                    <input id="text1" type="text" name="klantTel">Klant moet nog gebeld worden:
                    <input type="checkbox" name="nogBellen" value="nogBellen"></p>
                </div>
<!--rij 3-->  

                <div class="a1"><p>Nieuwe klant (Achternaam)
                    <input id="text1" type="text" name="klantAchterNaam" disabled></p>
                </div>

                <div class="a2"><p> <!-- Disabled, weinig tijd -->Merk:
                    <select name="vVLaptopMerk" disabled>
                        <option></option>
                        <option></option>
                    </select>
                    Type
                    <select name="vVLaptopType" disabled>
                        <option></option>
                        <option></option>
                    </select></p>
                </div>

                <div class="a3"><p>ontvangen via:
                    <select name="binnenkomstType" disabled> <!-- Moet nog gescript worden! Data moet uit database komen -->
                        <option>Telefoon</option>
                        <option>E-mail</option>
                    </select><br>
                    Locatie: 
                    <select name="binnenkomstType" disabled> <!-- Disabled, gaan we nog niets mee doen-->
                        <option>Hilversum Soestdijkerstraatweg</option>
                        <option>uy</option>
                    </select></p>
                </div>
<!--rij 4--> 
                <div class="a1"><p>Nieuwe klant (Adres)
                    <input id="text1" type="text" name="klantAdres" disabled></p>
                </div>

                <div class="a2"><p>Besturingssysteem<br>
                    <select name="besturingssysteem" disabled>
                        <?php
                        if ($OSLijst){
                            while($OSrij = mysqli_fetch_array($OSLijst)) {
                                echo '<option>' . $OSrij[besturingssysteem] . '</option>';
                        }}
                        ?>
                        <option></option>
                    </select></p>
                </div>  

                <div class="a3"><p>Probleem (korte omschrijving)
                    <textarea id="probleem"></textarea></p>
                </div>
 <!--rij 5-->         

                <div class="a1"><p>Nieuwe klant (Postcode)
                    <input id="text1" type="text" name="klantPostc" disabled></p>
                </div>

                <div class="a2"><p> Commentaar
                    <textarea id="nieuwComment"></textarea></p>
                </div>
 
                <div class="a3"><p> Potentiele oplossing
                    <textarea id="oplossing"></textarea></p>
                </div>    
<!--rij 6-->          
                <div class="a1"><p>Nieuwe klant (Woonplaats)</p>
                    <input id="text1" type="text" name="klantStad" disabled>
                </div>
       
                <div class="a3">
                    <input type="submit" name="submit" value="invoeren">
                </div>   
            </form>
        </div>

    </body>
</html>
