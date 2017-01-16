
<?php
session_start();
require_once 'AJAX/zoekKlant.php';
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connectie = verbinddatabase(); // connectie database

$ftsAccountNr = $_SESSION["accountNr"]; //sessie gebruiker
//ticket id
$klantID = $_POST["klantID"];

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
echo $merktype;
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


if (isset($_POST['submit0'])) {
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
<!DOCTYPE html>
<html>

    <body>
        <div class="containert">
        <h1> Nieuw ticket </h1>
        
        <!--  alle scripts  -->
            <script>
                function zoekf(){
                    var zoektxt = $("input[name='zoek']").val();
                    $.post("AJAX/zoekKlant.php", {zoekval: zoektxt}, function(output){
                        $("#output").text(output);
                    });
                    
                }
                
                function laptop(){
                    var zoektxt = $("input[name='laptopType']").val();
                    $.post("AJAX/getLaptopMerkId.php", {zoekval: zoektxt}, function(laptop){
                        $("#laptop").text(laptop);
                    });
                    
                }
            </script>

<form name="nieuwTicket1" action="nieuwTicketBestKlant.php" method="POST">
                <input name='zoek' type="text" placeholder="zoeken in Achternaam"  onkeydown="zoekf();" class='hidden2'/><br>
                <label class="hidden02">klant ID:</label><textfield  type="text" id="output" name="klantID" class="hidden2"/></textfield><br>
            <label class="hidden01">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" class="hidden"/><br>

            <label class="hidden01">binnengekomen via:</label>
            <select name="binnenkomstType" class="hidden"> <!-- Moet nog gescript worden! Data moet uit database komen -->
            <option value = "">---Select---</option>
<?php
$ophaalb = "SELECT * FROM binnenkomstType ";
$resultb = mysqli_query($connectie, $ophaalb);
while ($bt = mysqli_fetch_assoc($resultb)) {
    echo "<option value='" . $bt['binnenkomstId '] . "'>" . $bt['binnenkomstTypeOm'] . "</option>";
}
?> 
                
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
        <label class="hidden01">Zoek laptoptype:</label>
            <input name='laptopType' type="text" placeholder="Voer laptoptype in"  onblur="laptop();" class='hidden2'/><br>
            <label class="hidden02">Laptop: </label><textfield type="text" id="laptop" name="laptop" class="hidden2"/></textfield><br>



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
        <textarea name="probleem" class="hidden"></textarea><br>
        <label class="hidden01">commentaar:</label><br>
        <textarea name="nieuwComment" class="hidden"></textarea><br>
        <label class="hidden01">potentieele oplossing:</label><br>
        <textarea name="oplossing" class="hidden"></textarea><br>
        
                    <label class="hidden02">prioriteit:</label>
                        <select name="prioriteit" class="hidden2"> <!-- Disabled, gaan we nog niets mee doen-->
            <option value = "">---Select---</option>
            <option value = "1">laag</option>
            <option value = "2">middel</option>
            <option value = "3">hoog</option>

                        </select><br>
        <!--datepicker-->
        <label class="hidden01">streefdatum:</label>
        <input type="date" name="datepicker" id="datepicker" class="hidden"/></p>       
    <input type="submit" name="submit0" value="invoeren" class="hidden" />
</form></div>
    </body>
</html>
