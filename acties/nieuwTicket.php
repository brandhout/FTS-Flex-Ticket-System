<?php

require_once '../functies.php'; //Include de functies.
require_once '../header.php'; //Include de functies. 

?>
<!DOCTYPE html>
<html>
<h1> Nieuw ticket </h1>
<body>
<form name="nieuwTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    
          Probleem (korte omschrijving) <br>
          <input type="text" name="Beschrijving"><br>

          trefwoorden (aan elkaar, door komma gescheiden) <br> <!-- Afwijkende gegevensfilter. Trefwoorden moeten in kommagescheiden Array -->
          <input type="text" name="Beschrijving"><br>

          Probleem (korte omschrijving) <br>
          <input type="text" name="Beschrijving"><br>

          <input type="checkbox" name="nogBellen" value="nogBellen">Klant moet nog gebeld worden<br><br>
          
          Categorie <!-- Moet uit database komen -->
          <select name="categorie">
              <option></option>
              <option></option>
          </select><br><br>
          
          <strong>Streefdatum</strong><br>
          
                Dag <br>
                <select name="dag">
                <option>1</option>
                <option>2</option>
                </select><br><br>
          
                Maand <br>
                <select name="maand">
                <option>Januari</option>
                <option>Februari</option>
                </select><br><br>
          
                Jaar (2017) <br>
                <input type="text" name="jaar"><br><br>

                     Binnenkomst type: 
          <select name="binnenkomstType"> <!-- Moet nog gescript worden! Data moet uit database komen -->
              <option>Telefoon</option>
              <option>E-mail</option>
          </select><br><br>

                     Lokatie: 
          <select name="binnenkomstType"> <!-- Helaas moet ook deze uit de database komen :( -->
              <option></option>
              <option></option>
          </select><br><br>

          <strong>Veelvoorkomend laptop:</strong><br> <!-- Ook deze twee zou eigenlijk uit de database moeten komen. Schrappen bij weinig tijd -->
          Merk
          <select name="vVLaptopMerk">
              <option></option>
              <option></option>
          </select><br><br>
          
          Type
          <select name="vVLaptopType">
              <option></option>
              <option></option>
          </select><br><br>

          <input type="checkbox" name="nieuwCommentaar" value="nieuwCommentaar">Nieuw commentaar<br><br>
          <!-- MOET SCRIPT KOMEN! als aangevinkt dan komt er een GROOT tekstvak waarin nieuw commentaar gegeven kan worden -->

    
<input type="submit" name="invoeren" value="invoeren"><br>    
</form></body></html>

<?php

verbinddatabase();
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


$query = mysqli_query("insert into ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = $datumAanmaak,
nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
log = $log, verlopen = $verlopen, streefdatum = $streefdatum, binnenkomstType = $binnenkomstType,
lokatie = $lokatie, klantTevreden = $klantTevreden, vVLaptopMerk = $vVLaptopMerk,
vVLaptopType = $vVlaptopType, besturingssysteem = $besturingssysteem");    


if (!$query) {
    $error =TRUE;
}
    
?>