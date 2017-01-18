
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
$klantID = $_SESSION['klantId'];

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
<div class="container">
<div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                    <form name="nieuwTicket" action="nieuwTicketNieuwKlant.php" method="POST">
                        <!-- Left Inputs -->
						<div class="grid">
						<div class="row">
                        <div class="col-md-4 wow animated slideInLeft" data-wow-delay=".5s">
                            <!-- zoek -->
                            <input type="text" name="zoek" id="zoek" required="required" class="form" onkeydown="zoekf();" placeholder="zoeken in achternaam" />
							<p type="text" class="form" id="output" name="klantID" placeholder="resultaat klant ID"></p>
                        </div><!-- End Left Inputs -->
						<!-- mid inputs -->
						<div class="col-md-4 wow animated slideInLeft" data-wow-delay=".5s">
                        <select class="form" name="instantie">
                        <option value = "">---instanties---</option>
                            <?php
                            $ophaali = "SELECT * FROM instantie ";
                            $resulti = mysqli_query($connectie, $ophaali);
                            while ($l = mysqli_fetch_assoc($resulti)) {
                            echo "<option value='" . $l['instantieId'] . "'>" . $l['instantieNaam'] . "</option>";
                            }
                            ?> 
                        </select>						
                        <select class="form" name="bedrijf">
                        <option value = "">---bedrijf---</option>
                            <?php
                            $ophaalv = "SELECT * FROM bedrijf ";
                            $resultv = mysqli_query($connectie, $ophaalv);
                            while ($v = mysqli_fetch_assoc($resultv)) {
                            echo "<option value='" . $v['bedrijfsId'] . "'> " . $v['naam'] . "</option>";
                            }
                            ?> 
                        </select>						
                        <select class="form" name="binnenkomstType" >
                        <option value = "">---binnengekomen via---</option>
                            <?php
                            $ophaalb = "SELECT * FROM binnenkomstType ";
                            $resultb = mysqli_query($connectie, $ophaalb);
                            while ($bt = mysqli_fetch_assoc($resultb)) {
                            echo "<option value='" . $bt['binnenkomstId '] . "'>" . $bt['binnenkomstTypeOm'] . "</option>";
                            }
                            ?> 
                        </select>
                        <select class="form"name="prioriteit">
                            <option value = "">---prioriteit---</option>
                            <option value = "1">laag</option>
                            <option value = "2">middel</option>
                            <option value = "3">hoog</option>
                        </select>   						
                        <select class="form" name="categorie">
                        <option value = "">---categorie---</option>
                            <?php
                            $ophaalcat = "SELECT * FROM categorie ";
                            $resultcat = mysqli_query($connectie, $ophaalcat);
                            while ($c = mysqli_fetch_assoc($resultcat)) {
                            echo "<option value='" . $c['categorieId'] . "'>" . $c['categorieId'] . " " . $c['catOmschrijving'] . "</option>";
                            }
                            ?>
                        </select>	
                        <select class="form" name="subCategorie">
                        <option value = "">---sub-categorie---</option>
                            <?php
                            $ophaalscat = "SELECT * FROM subCategorie ";
                            $resultscat = mysqli_query($connectie, $ophaalscat);
                            while ($s = mysqli_fetch_assoc($resultscat)) {
                            echo "<option value='" . $s['subCategorieId'] . "'>" . $s['subCategorieId'] . " " . $s['subCatomschrijving'] . "</option>";
                            }
                            ?>
                        </select>
                        <select class="form" name="besturingssysteem">
                        <option value = "">---besturingsysteem---</option>
                            <?php
                            $ophaalbs = "SELECT * FROM besturingssysteem ";
                            $resultbs = mysqli_query($connectie, $ophaalbs);
                            while ( $bs=mysqli_fetch_assoc($resultbs)) {
                            echo "<option value='".$bs['besturingssysteemId']."'>".$bs['besturingssysteemId']." ".$bs['besturingssysteemOm']."</option>";
                            }
                            ?>           
                        </select>						

						</div><!-- End Mid Inputs -->
						
						
						
                        <!-- Right Inputs -->

                        <div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
						<!-- zoeklaptop -->
						<input name='laptopType' class="form" type="text" placeholder="Voer laptoptype in"  onblur="laptop();"/>
						<p type="text" class="form" id="laptop" name="laptop" placeholder="resultaat laptop"></p>
                            <!-- trefwoorden -->
                            <input type="text" name="trefwoorden" id="trefwoorden" required="required" class="form" placeholder="trefwoorden (scheiden met , )" />
						     <!-- datepicker -->
                            <input type="text" name="datepicker" id="datepicker" required="required" class="form" placeholder="streef-datum" />
						<!-- checkbox -->
                    <li class="form">
                        klant wilt gebeld worden:
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionDefault" name="nogBellen" type="checkbox"/>
                            <label for="someSwitchOptionDefault" class="label-default"></label>
                        </div>
                    </li>
					</div></div>
					
					
					<div class="row">
						<div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
                            <!-- Message -->
                            <textarea name="probleem" id="message1" class="form textarea"  placeholder="probleem"></textarea>
						</div>
						<div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
                            <!-- Message -->
                            <textarea name="nieuwComment" id="message2" class="form textarea"  placeholder="commentaar"></textarea>
                        </div>
						<div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
                            <!-- Message -->
                            <textarea name="oplossing" id="message3" class="form textarea"  placeholder="potentpiele oplossing"></textarea>
                        </div>
                        <!-- Bottom Submit -->
                        <div class="relative fullwidth col-xs-12">
                            <!-- Send Button -->
                            <button type="submit" id="submit1" name="submit1" class="form-btn semibold">invoeren</button> 
                        </div><!-- End Bottom Submit -->
                        <!-- Clear -->
                        <div class="clear"></div></div></div>
                    </form>



                </div><!-- End Contact Form Area -->
            </div><!-- End Inner --></div>
            
            
    </body>
</html>
