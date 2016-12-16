<?php

require_once '../functies.php'; //Include de functies.
require_once '../header.php'; //Include de functies. 
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

    
if (!$_POST['submit'] === "") {
    
    $leesKlantQuery= 'select * from klant';
    $klantenLijst= mysqli_query($connectie, $leesKlantQuery)
        or die("Kan aangevraagde actie niet verwerken:" .mysql_error());

    
    $uitkomst= mysqli_query($connectie, $ticketQuery)
        or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
    
        if (isset($_POST['nieuweKlant'])) {
                $nieuweKlantQuery = "insert into klant klantAchterNaam = $klantAchterNaam,
                klantNaam = $klantNaam, klantTel = $klantTel, klantAdres = $klantAdres, klantPostc = $klantPostc,
                klantStad = $klantStad, klantEmail = $klantEmail";
    


        }
        
        if (isset($_POST['bestaandeKlant'])) {
                $ticketQuery = "insert into ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
                probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
                aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = $datumAanmaak,
                nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
                log = $log, verlopen = $verlopen, streefdatum = $streefdatum,
                lokatie = $lokatie, klantTevreden = $klantTevreden"; 
                
                $uitkomst= mysqli_query($connectie, $ticketQuery)
                or die("Kan aangevraagde actie niet verwerken:" .mysql_error());


        }

        
        

    
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
                    <select name="dag">
                        <option>Herman</option>
                        <option>Milad</option>
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
                        <option>Windows</option>
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
