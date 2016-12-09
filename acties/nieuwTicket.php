<?php

require_once '../functies.php'; //Include de functies.
require_once '../header.php'; //Include de functies. 

$fstAccountNr= "";
$probleem=NULL;
$trefwoorden=NULL;
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


?>
<!DOCTYPE html>
<html>
<h1> Nieuw ticket </h1>
<body>
 <div class="algemeen1">
     <form name="nieuwTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
 <div class="a1">  
          trefwoorden (aan elkaar, door komma gescheiden) <br> <!-- Afwijkende gegevensfilter. Trefwoorden moeten in kommagescheiden Array -->
          <input type="text" name="Beschrijving"><br><br>
          
          Probleem (korte omschrijving) <br>
          <textarea id="probleem" rows="10" cols="90"></textarea><br><br></div>
<div class="a2">
          <h3> Klant </h3>
          
          Bestaande klant <br> <!-- Moet uit database komen!! -->
          <select name="dag">
          <option>Herman</option>
          <option>Milad</option>
          </select><br><br>
          
          <input type="checkbox" name="nieuwKlant" value="nieuwKlant">Nieuwe klant<br><br>
         <!-- Als nieuwe klant aangevinkt is dan kunnen NAW gegevens ingevuld worden -->
          Nieuwe klant (Achternaam) <br>
          <input type="text" name="klantAchterNaam" disabled><br><br>
          
          Nieuwe klant (Voornaam) <br>
          <input type="text" name="klantNaam" disabled><br><br>

          Nieuwe klant (Adres) <br>
          <input type="text" name="klantAdres" disabled><br><br>
          
          Nieuwe klant (Postcode) <br>
          <input type="text" name="klantPostc" disabled><br><br>

          Nieuwe klant (Woonplaats) <br>
          <input type="text" name="klantStad" disabled><br><br>

          
          <input type="checkbox" name="nogBellen" value="nogBellen">Klant moet nog gebeld worden<br><br></div>
          
    <div class="a3">     
          <h3> Categorieën </h3>
          
          Categorie <!-- Moet uit database komen -->
          <select name="categorie" disabled>
              <option>Software</option>
              <option>Hardware</option>
          </select><br><br>
          
          Subcategorie <!-- Disabled, voor later. -->
          <select name="subCategorie" disabled>
              <option>Fedora Linux</option>
              <option></option>
          </select><br>

          
          <h3> Streefdatum</h3>
          
                Dag <br>
                <select name="dag" disabled>
                <option>1</option>
                <option>2</option>
                </select><br><br>
          
                Maand <br>
                <select name="maand" disabled>
                <option>Januari</option>
                <option>Februari</option>
                </select><br><br>
          
                Jaar (2017) <br>
                <input type="text" name="jaar" disabled><br><br></div>
<div class="a4">
                     Binnenkomst type: 
          <select name="binnenkomstType" disabled> <!-- Moet nog gescript worden! Data moet uit database komen -->
              <option>Telefoon</option>
              <option>E-mail</option>
          </select><br><br>

                     Lokatie: 
              <br><select name="binnenkomstType" disabled><br> <!-- Disabled, gaan we nog niets mee doen-->
              <option>Hilversum Soestdijkerstraatweg</option>
              <option></option>
          </select><br>

          <h3>Veelvoorkomende laptop:</h3><br> <!-- Disabled, weinig tijd -->
          Merk
          <select name="vVLaptopMerk" disabled>
              <option></option>
              <option></option>
          </select><br><br>
          
          Type
          <select name="vVLaptopType" disabled>
              <option></option>
              <option></option>
          </select><br><br>
          
          Besturingssysteem
          <br><select name="besturingssysteem" disabled>
              <option>Windows</option>
              <option></option>
          </select><br><br></div>
         
          <div class="a5">
          <h3> Potentiele oplossing </h3>
            <textarea id="oplossing" rows="10" cols="90"></textarea><br><br>
          
           <h3> Commentaar </h3>
            <textarea id="nieuwComment" rows="10" cols="90"></textarea><br><br>

            </div>
<div class="a6">
    <input type="submit" name="invoeren" value="invoeren"><br></div>    
</form>
 </div>
</body></html>

<?php

verbinddatabase();

if (!mysqli_real_escape_string(stripcslashes($POST['probleem'])) === "") {

$query = mysqli_query("insert into ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = $datumAanmaak,
nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
log = $log, verlopen = $verlopen, streefdatum = $streefdatum, binnenkomstType = $binnenkomstType,
lokatie = $lokatie, klantTevreden = $klantTevreden, vVLaptopMerk = $vVLaptopMerk,
vVLaptopType = $vVlaptopType, besturingssysteem = $besturingssysteem");    
}

?>