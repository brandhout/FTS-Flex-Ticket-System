<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$connectie = verbinddatabase(); // connectie database

$ftsAccountNr = $_SESSION["accountNr"]; //sessie gebruiker
//naw
$naam = $_POST["klantNaam"];
$achternaam = $_POST["klantAchternaam"];
$tel = $_POST["klantTel"];
$adres = $_POST["klantAdres"];
$postcode = $_POST["klantPostc"];
$stad = $_POST["klantStad"];
$email = $_POST["klantEmail"];
$instantie = $_POST["instantie"];
$bedrijf = $_POST["bedrijf"];

//ticket
$trefwoorden = $_POST["trefwoorden"];
$prioriteit = $_POST["prioriteit"];
$nogbellen = $_POST["NogBellen"];
$categorie = $_POST["categorie"];

$streefdatum = $_POST["datepicker"];
$sdate = date('Y-m-d', strtotime(str_replace('-', '/', $streefdatum)));

$commentaar = $_POST["nieuwComment"];
$probleem = $_POST["probleem"];
$oplossing = $_POST["oplossing"];
if(isset($_POST['laptopType'])){
    $merktype = leesLaptopTypeId($_POST['laptopType']);
} else {
    $merklaptop = 0;
}

$scategorie = $_POST["subCategorie"];
$besturingsysteem = $_POST["besturingssysteem"];
$binnenkomstT = $_POST["binnenkomstType"];
$check = (isset($_POST['nogBellen'])) ? 1 : 0;

//overig
$aantalXterug = NULL;
$terugstuurLock = NULL;
$lijnNr = 1;
$datumAanmaak = mysqldatum();
$verlopen = FALSE;
$klantTevreden = NULL;
$factuurNr = NULL;
$typeCommentaar = NULL;
$aangewAccountNr = NULL;
$redentelaat = NULL;
$inbehandeling = 1;
$tcom=NULL;
$def=NULL;




if (isset($_POST['submit1'])) {


// nieuwe klant	
    $insertklant = $connectie->prepare("INSERT INTO klant (klantId, klantAchternaam, klantNaam, klantTel,
    klantAdres, klantPostc, klantStad, klantEmail, instantieId, bedrijfsId)
    VALUES ('',?,?,?,?,?,?,?,?,?)");
    if ($insertklant) {
        $insertklant->bind_param('sssssssii', $achternaam, $naam, $tel, $adres, $postcode, $stad, $email, $instantie, $bedrijf);
        if ($insertklant->execute()) {
            echo ' klant gemaakt!';
        }
    }
    
//ticket maken    
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
        }
    }
$insertticket = $connectie->prepare("INSERT INTO ticket (ticketId, inBehandeling, probleem, trefwoorden, prioriteit, aantalXterug,
                        terugstuurLock, lijnNr, datumAanmaak, nogBellen, instantieId, streefdatum, redenTeLaat, klantTevreden, fstAccountNr, aangewAccountNr, klantId, subCategorieId, 
                        binnenkomstId, vVLaptopTypeId, besturingssysteemId)
                        VALUES ('','$inbehandeling',?,?,?, '$aantalXterug','$terugstuurLock','$lijnNr','$datumAanmaak','$check','$instantie',?,'$redentelaat','$klanttevreden','$ftsAccountNr',
                        '$aangewAccountNr','$klantID',?,?,?,?)");
            if ($insertticket) {
                $insertticket->bind_param('ssisiiii', $probleem, $trefwoorden, $prioriteit, $sdate, $scategorie, $binnenkomstT, $merktype, $besturingsysteem);
                if ($insertticket->execute()) {
                    echo 'ticket aangemaakt';
                    //header("Refresh:5; url=../index.php", true, 303);
                }else {echo "Error : " . mysqli_error($connectie);}
            }else {echo "Error : " . mysqli_error($connectie);}

//ophalen tickedID
$ophaalticket = "SELECT * FROM ticket WHERE klantId='$klantID'";
    $resultticket = $connectie->query($ophaalticket);
    if (mysqli_num_rows($resultticket) == 0) {
        echo "ticketid niet gevonden";
    }
    while ($rowt = $resultticket->fetch_assoc()) {
        if ($rowt['klantId'] === $klantID) {
            echo 'ticketID:' . $rowt['ticketId'];
            $ticketID = $rowt['ticketId'];
           


        }
    }
    $insertcomment= $connectie->prepare("INSERT INTO commentaar(commentaarID, commOmschrijving, typeCommentaar, datum, accountNr, ticketId)
            VALUES ('',?,'$tcom','$datumAanmaak','$ftsAccountNr','$ticketID'  )");
            if ($insertcomment){
                $insertcomment->bind_param('s',$commentaar);
                if ($insertcomment->execute()){
                    echo 'alles is gelukt';
                    //header("Refresh:5; url=../index.php", true, 303);
                }else {echo "Error : " . mysqli_error($connectie);}
            }else {echo "Error : " . mysqli_error($connectie);} 
            
            
if (!empty($oplossing)) {

$insertoplossing=$connectie->prepare("INSERT INTO oplossingen(oplossingId, definitief, oplossOmschrijving, datumFix, accountNr, ticketId)
        VALUES ('','$def', ?,'$datumAanmaak','$ftsAccountNr','$ticketID')");
        if($insertoplossing){
            $insertoplossing->bind_param('s', $oplossing);
            if ($insertoplossing->execute()){
                echo '!';
            }else{echo "Error : " . mysqli_error($connectie);}
        }else{echo "Error : " . mysqli_error($connectie);}
} 
//header("Refresh:5; url=../index.php", true, 303);  
}
           

?>
<html><body>
    <script>
            function laptop(){
                var zoektxt = $("input[name='laptopType']").val();
                $.post("AJAX/getLaptopMerkId.php", {zoekval: zoektxt}, function(laptop){
                $("#laptop").text(laptop);
                });                 
            }
    </script>

    <div class="containert">
        <form name="nieuwTicket" action="nieuwTicketNieuwKlant.php" method="POST">
            <table cellspacing="0" cellpading="5"width="90%">
                <tr>
                    <td>
                        naw gegevens
                    </td>
                    <td colspan="2"> ticketgegevens
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" required placeholder="voornaam" name="klantNaam"/>
                    </td>
                    <td>
                        <label>instantie</label>
                        <select name="instantie"> <!-- Disabled, gaan we nog niets mee doen-->
                        <option value = "">---Select---</option>
                            <?php
                            $ophaali = "SELECT * FROM instantie ";
                            $resulti = mysqli_query($connectie, $ophaali);
                            while ($l = mysqli_fetch_assoc($resulti)) {
                            echo "<option value='" . $l['instantieId'] . "'>" . $l['instantieNaam'] . "</option>";
                            }
                            ?> 
                        </select>
                    </td>
                    <td>
                        <input id="text1"  type="text" required name="trefwoorden" placeholder="trefwoorden (scheiden met , ) "/>
                    </td>
                </tr>
		<tr>
                    <td>
                        <input type="text" required placeholder="tussenv & achternaam" name="klantAchternaam"/>
                    </td>
                    <td>
                        <label>bedrijf:</label>
                        <select class="drop" name="bedrijf"> <!-- Disabled, gaan we nog niets mee doen-->
                        <option value = "">---Select---</option>
                            <?php
                            $ophaalv = "SELECT * FROM bedrijf ";
                            $resultv = mysqli_query($connectie, $ophaalv);
                            while ($v = mysqli_fetch_assoc($resultv)) {
                            echo "<option value='" . $v['bedrijfsId'] . "'> " . $v['naam'] . "</option>";
                            }
                            ?> 
                        </select>
                    </td>
                    <td>
                        <label>categorie:</label>   
                        <select class="drop" name="categorie">
                        <option value = "">---Select---</option>
                            <?php
                            $ophaalcat = "SELECT * FROM categorie ";
                            $resultcat = mysqli_query($connectie, $ophaalcat);
                            while ($c = mysqli_fetch_assoc($resultcat)) {
                            echo "<option value='" . $c['categorieId'] . "'>" . $c['categorieId'] . " " . $c['catOmschrijving'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
		<tr>
                    <td>
                        <input type="text" required placeholder="adres" name="klantAdres"/>
                    </td>
                    <td>
                        <label class="check">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen"/>
                    </td>
                    <td>
                        <label>sub-categorie:</label>
                        <select class="drop" name="subCategorie">
                        <option value = "">---Select---</option>
                            <?php
                            $ophaalscat = "SELECT * FROM subCategorie ";
                            $resultscat = mysqli_query($connectie, $ophaalscat);
                            while ($s = mysqli_fetch_assoc($resultscat)) {
                            echo "<option value='" . $s['subCategorieId'] . "'>" . $s['subCategorieId'] . " " . $s['subCatomschrijving'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
		<tr>
                    <td>
                        <input type="text" required placeholder="postcode" name="klantPostc"/>
                    </td>
                    <td>
                        <label>binnengekomen via:</label>
                        <select class="drop" name="binnenkomstType" > <!-- Moet nog gescript worden! Data moet uit database komen -->
                        <option value = "">---Select---</option>
                            <?php
                            $ophaalb = "SELECT * FROM binnenkomstType ";
                            $resultb = mysqli_query($connectie, $ophaalb);
                            while ($bt = mysqli_fetch_assoc($resultb)) {
                            echo "<option value='" . $bt['binnenkomstId '] . "'>" . $bt['binnenkomstTypeOm'] . "</option>";
                            }
                            ?> 
                        </select>
                    </td>
                    <td>
                        <label class="zoekveld">Zoek laptoptype:</label><input name='laptopType' type="text" placeholder="Voer laptoptype in"  onblur="laptop();"/>
                    </td>
                </tr>
		<tr>
                    <td>
                        <input type="text" required placeholder="woonplaats" name="klantStad"/>
                    </td>
                    <td 
                        colspan="2"><label class="textfieldc">laptop:</label><textfield type="text" id="laptop" name="laptop"></textfield>
                    </td>
		</tr>
		<tr>
                    <td>
                        <input type="text" placeholder="telefoonnummer" name="klantTel"/>
                    </td>
                    <td> 
                    </td>
                    <td>   
                        <label>besturingsysteem:</label>     
                        <select class="drop" name="besturingssysteem">
                        <option value = "">---Select---</option>
                            <?php
                            $ophaalbs = "SELECT * FROM besturingssysteem ";
                            $resultbs = mysqli_query($connectie, $ophaalbs);
                            while ( $bs=mysqli_fetch_assoc($resultbs)) {
                            echo "<option value='".$bs['besturingssysteemId']."'>".$bs['besturingssysteemId']." ".$bs['besturingssysteemOm']."</option>";
                            }
                            ?>           
                        </select>
                    </td>
                </tr>
		<tr>
                    <td>
                        <input type="text" required placeholder="e-mail" name="klantEmail"/>
                    </td>
                    <td>
			<label>prioriteit</label>	
                        <select class="drop"name="prioriteit"> <!-- Disabled, gaan we nog niets mee doen-->
                            <option value = "">---Select---</option>
                            <option value = "1">laag</option>
                            <option value = "2">middel</option>
                            <option value = "3">hoog</option>
                        </select>   
                    </td>
                    <td><!--datepicker-->
                        <label>streefdatum:</label>
                        <input type="text" name="datepicker" id="datepicker">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        tekstvelden          (potentiele oplossing, commentaar niet verplicht)
                    </td>
                </tr>
		<tr>
                    <td>
                        <label class="textl1">probleem(korte omschrijving:)</label><br>
                        <textarea name="probleem" class="texta"></textarea>
                    </td>
                    <td>        
                        <label class="textl2">commentaar:</label><br>
                        <textarea name="nieuwComment" class="texta"></textarea>
                    </td>
                    <td>        
                        <label class="textl3">potentiele oplossing:</label><br>
                        <textarea name="oplossing" class="texta"></textarea><br>
                    </td>
                </tr>
		<tr>
                    <td colspan="3">    
                        <input class="sub" type="submit" name="submit1" value="invoeren"/>
                    </td>
                </tr>
            </table> 
</form>

</div>
</body>



</html>
