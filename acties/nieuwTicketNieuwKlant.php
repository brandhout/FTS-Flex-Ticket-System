<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connectie = verbinddatabase(); // connectie database

$output = ''; //laat bestaande klant zien

$fstAccountNr = $_SESSION['gebruikersNaam']; //sessie gebruiker
//naw
$naam = $_POST["klantNaam"];
$achternaam = $_POST["klantAchternaam"];
$tel = $_POST["klantTel"];
$adres = $_POST["klantAdres"];
$postcode = $_POST["klantPostc"];
$stad = $_POST["klantStad"];
$email = $_POST["klantEmail"];
$locatie = $_POST["locatie"];
$vestiging = $_POST["vestiging"];

//ticket
$btype = $_POST["binnenkomstType"];
$trefwoorden = $_POST["trefwoorden"];
$prioriteit = $_POST["prioriteit"];
$nogbellen = $_POST["NogBellen"];
$categorie = $_POST["categorie"];
$streefdatum = $_POST["datepicker"];
$commentaar = $_POST["nieuwComment"];
$probleem = $_POST["probleem"];
$oplossing = $_POST["oplossing"];
$merklaptop = NULL;
$merktype = NULL;
$scategorie = NULL;
$besturingsysteem = NULL;


//bullshit denk ik
$aantalXterug = NULL;
$terugstuurLock = FALSE;
$lijnNr = 1;
$datumAanmaak = mysqldatum();
$log = NULL;
$verlopen = FALSE;
$klantTevreden = NULL;
$factuurNr = NULL;
$typeCommentaar = NULL;
$aangewAccountNr = NULL;
$redentelaat = NULL;
$inbehandeling = 1;


if (isset($_POST['submit1'])) {
// nieuwe klant	
    $insertklant = $connectie->prepare("INSERT INTO klant (klantId, klantAchternaam, klantNaam, klantTel,
    klantAdres, klantPostc, klantStad, klantEmail, instantieId, locatieId)
    VALUES ('',?,?,?,?,?,?,?,?,?)");
    if ($insertklant) {
        $insertklant->bind_param('sssssssii', $achternaam, $naam, $tel, $adres, $postcode, $stad, $email, $locatie, $vestiging);
        if ($insertklant->execute()) {
            echo ' klant gemaakt!';
        }
    }
    
// ophalen klant ID
    $ophaalKlantQuery = "SELECT * FROM klant WHERE klantNaam='$naam'";
    $result = $connectie->query($ophaalKlantQuery);
    if (mysqli_num_rows($result) == 0) {
        echo "klant niet gevonden";
    }
    while ($row = $result->fetch_assoc()) {
        if ($row['klantNaam'] === $naam) {
            echo $row['klantNaam'];
            $klantID = $row['klantId'];






            $insertticket = $connectie->prepare("INSERT INTO ticket (ticketId, inBehandeling, probleem, trefwoorden, prioriteit, aantalXterug,
                        terugstuurLock, lijnNr, datumAanmaak, nogBellen, log, streefdatum, redenTeLaat, klantTevreden, ftsAccountNr, aangewAccountNr, klantId, categorieId, 
                        binnenkomstId, vVLaptopTypeId, besturingssysteemId)
                        VALUES ('','$inbehandeling',?,?,?, '$aantalXterug','$terugstuurLock',?,'$datumAanmaak',?,'$log',?,'$redentelaat','$klanttevreden','$fstAccountNr',
                        '$aangewAccountNr','$klantID','$cID','$bID','$vID','$bID')");
            if ($insertticket) {
                $insertticket->bind_param('ssiiis', $probleem, $trefwoorden, $prioriteit, $lijnNr, $nogbellen, $streefdatum);
                if ($insertticket->execute()) {
                    echo 'ticket aangemaakt';
                    header("Refresh:5; url=../index.php", true, 303);
                }
            }
        }
    }

    $insertTicket = $connectie->prepare("INSERT INTO ticket (");

}
?>
<html>
    <h1> Nieuw ticket </h1>
    <body>

        <form name="nieuwTicket" action="nieuwTicketNieuwKlant.php" method="POST">

            <label class="hidden01">naam:</label><input type="text" name="klantNaam" class="hidden"/><br>
            <label class="hidden01">achternaam:</label><input type="text" name="klantAchternaam" class="hidden"/><br>
            <label class="hidden01">adres:</label><input type="text" name="klantAdres" class="hidden"/><br>
            <label class="hidden01">postcode:</label><input type="text" name="klantPostc" class="hidden"/><br>			
            <label class="hidden01">woonplaats:</label><input type="text" name="klantStad" class="hidden"/><br>
            <label class="hidden01">telefoonnummer:</label><input type="text" name="klantTel" class="hidden"/><br>
            <label class="hidden01">email:</label><input type="text" name="klantEmail" class="hidden"/><br>
            
            <label class="hidden02">locatie:</label>
                        <select name="locatie" class="hidden2"> <!-- Disabled, gaan we nog niets mee doen-->
            <option value = "">---Select---</option>
<?php
$ophaall = "SELECT * FROM locatie ";
$resultl = mysqli_query($connectie, $ophaall);
while ($l = mysqli_fetch_assoc($resultl)) {
    echo "<option value='" . $l['locatieId'] . "'>" . $l['locatieId'] . " " . $l['locOmschrijving'] . "</option>";
}
?> 
                        </select><br>
            <label class="hidden02">vestiging:</label>
                        <select name="vestiging" class="hidden2"> <!-- Disabled, gaan we nog niets mee doen-->
            <option value = "">---Select---</option>
<?php
$ophaalv = "SELECT * FROM vestigingen ";
$resultv = mysqli_query($connectie, $ophaalv);
while ($v = mysqli_fetch_assoc($resultv)) {
    echo "<option value='" . $v['vestigingId'] . "'>" . $v['vestigingId'] . " " . $v['vesOmschrijving'] . "</option>";
}
?> 
                        </select><br>

            <label class="hidden01">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" value="nogBellen" class="hidden"/><br>

            <label class="hidden01">binnengekomen via:</label>
            <select name="binnenkomstType" class="hidden"> <!-- Moet nog gescript worden! Data moet uit database komen -->
                <option>Telefoon</option>
                <option>E-mail</option>
            </select><br>

            <label class="hidden01">trefwoorden (aan elkaar, door komma gescheiden)</label><input id="text1" type="text" name="trefwoorden" class="hidden"/></p>

        <label class="hidden01">categorie:</label>
        <select name="categorie" class="hidden">
            <option value = "">---Select---</option>
<?php
$ophaalcat = "SELECT * FROM categorie ";
$resultcat = mysqli_query($connectie, $ophaalcat);
while ($c = mysqli_fetch_assoc($resultcat)) {
    echo "<option value='" . $c['categorieId'] . "'>" . $c['categorieId'] . " " . $c['catOmschrijving'] . "</option>";
}
?>
        </select><br>
        <label class="hidden01">sub-categorie:</label>
        <select name="subCategorie" class="hidden">
            <option value = "">---Select---</option>
<?php
$ophaalscat = "SELECT * FROM subCategorie ";
$resultscat = mysqli_query($connectie, $ophaalscat);
while ($s = mysqli_fetch_assoc($resultscat)) {
    echo "<option value='" . $s['subCategorieId'] . "'>" . $s['subCategorieId'] . " " . $s['subCatomschrijving'] . "</option>";
}
?>
        </select><br>
        <label class="hidden01">merk:</label>
        <select name="vVLaptopMerk" class="hidden">
            <option value = "">---Select---</option>
<?php
$ophaalmerk = "SELECT * FROM veelVoorkomendelaptopMerken ";
$resultmerk = mysqli_query($connectie, $ophaalmerk);
while ($rm = mysqli_fetch_assoc($resultmerk)) {
    echo "<option value='" . $rm['vVLaptopMerkId'] . "'>" . $rm['vVLaptopMerkId'] . " " . $rm['vVLaptopMerkOm'] . "</option>";
}
?>                         


        </select><br>
        <label class="hidden01">type:</label>
        <select name="vVLaptopType" class="hidden">
            <option value = "">---Select---</option>

                            <?php
    $ophaaltype = "SELECT * FROM veelVoorkomendeLaptopTypes ";
    $resulttype = mysqli_query($connectie, $ophaaltype);
while ( $rt=mysqli_fetch_assoc($resulttype)) {
  echo "<option value='".$rt['vVLaptopTypeId']."'>".$rt['vVLaptopTypeId']." ".$rt['vVLaptopTypeOm']."</option>";
}
    ?>


        </select><br>
        <label class="hidden01">besturingsysteem:</label>
        <select name="besturingssysteem" class="hidden">
            <option value = "">---Select---</option>
                             <?php
    $ophaalbs = "SELECT * FROM besturingssysteem ";
    $resultbs = mysqli_query($connectie, $ophaalbs);
while ( $bs=mysqli_fetch_assoc($resultbs)) {
  echo "<option value='".$bs['besturingssysteemId']."'>".$bs['besturingssysteemId']." ".$bs['besturingssysteemOm']."</option>";
}
    ?>           
            
        </select><br>

        <label class="hidden01">probleem(korte omschrijving:)</label><br>
        <textarea id="probleem" class="hidden"></textarea><br>
        <label class="hidden01">commentaar:</label><br>
        <textarea id="nieuwComment" class="hidden"></textarea><br>
        <label class="hidden01">potentieele oplossing:</label><br>
        <textarea id="oplossing" class="hidden"></textarea><br>
        <!--datepicker-->
        <label class="hidden01">streefdatum:</label>
        <input type="date" id="datepicker" class="hidden"/></p>       
    <input type="submit" name="submit1" value="invoeren" class="hidden" />
</form>


</body>



</html>
