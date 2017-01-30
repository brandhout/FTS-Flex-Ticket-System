<?php
session_start();
require_once 'AJAX/zoekKlant.php';
require_once '../functies.php'; //Include de functies.
ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//ALLE VARIABELEN
$connectie = verbinddatabase(); // connectie database

$ftsAccountNr = $_SESSION["accountNr"]; //sessie gebruiker
//ticket id
$klantID = $_SESSION['klantId'];

//ticket
$trefwoorden = $_POST["trefwoorden"];
$prioriteit = $_POST["prioriteit"];
$nogbellen = $_POST["NogBellen"];
if(isset($_POST["categorie"])){
    $categorie = $_POST["categorie"];
    if(isset($_POST["subCategorie"])){
        $scategorie = $_POST["subCategorie"];
    }
}

$streefdatum = $_POST["datepicker"];
$sdate = date('Y-m-d', strtotime(str_replace('-', '/', $streefdatum)));

$commentaar = $_POST["nieuwComment"];
$probleem = $_POST["probleem"];
$oplossing = $_POST["oplossing"];
if($_POST['laptopType'] != ""){
    $merktype = leesLaptopTypeId($_POST['laptopType']);
} else {
    $merktype = 0;
}
$besturingsysteem = $_POST["besturingssysteem"];
$binnenkomstT = $_POST["binnenkomstType"];
$check = (isset($_POST['nogBellen'])) ? 1 : 0;

if(isset($_SESSION['bedrijfsId'])){
$bedrijfsId = $_SESSION['bedrijfsId'];
} else {
    $bedrijfsId = 0;
}

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

//BIND_PARAM INVOEREN TICKET IN DATABASE 
if (isset($_POST['submit0'])) {
//TICKET WORDT VOORBEREID // BIJ VALUES LATEN WE WETEN WAT BIJ WAT HOORT
$insertticket = $connectie->prepare("INSERT INTO ticket (ticketId, inBehandeling, probleem, trefwoorden, prioriteit, aantalXterug,
                        terugstuurLock, lijnNr, datumAanmaak, nogBellen, streefdatum, redenTeLaat, klantTevreden, fstAccountNr, aangewAccountNr, klantId, subCategorieId, 
                        binnenkomstId, vVLaptopTypeId, besturingssysteemId)         
                        VALUES ('','$inbehandeling',?,?,?, '$aantalXterug','$terugstuurLock','$lijnNr','$datumAanmaak','$check',?,'$redentelaat','$klanttevreden','$ftsAccountNr',
                        '$aangewAccountNr','$klantID',?,?,?,?)");
//BIND_PARAM HIER WORD ALLES AAN ELKAAR GEWEZEN EN WORDT ZO GEFILTERD ZODAT ER DAADWERKELIJK ALLEEN MAAR INTEGERS EN STRINGS ERAAN GEKOPPELD WORDEN
            if ($insertticket) {
                $insertticket->bind_param('ssisiiii', $probleem, $trefwoorden, $prioriteit, $sdate, $scategorie, $binnenkomstT, $merktype, $besturingsysteem);
// HIER WORDT HET INVOEREN GEACTIVEERD
                if ($insertticket->execute()) {
                    //header("Refresh:5; url=../index.php", true, 303);
                }else {echo "Error : " . mysqli_error($connectie);}
            }else {echo "Error : " . mysqli_error($connectie);}

//ophalen tickedID
$ophaalticket = "SELECT * FROM ticket WHERE klantId='$klantID'";
    $resultticket = $connectie->query($ophaalticket);
    if (mysqli_num_rows($resultticket) == 0) {
        echo "ticketid niet gevonden";
    }
// HIER WORDT GEKEKEN OF RIJ ID GELIJK IS AAN TICKET ID EN ZET TICKET ID IN VAR
    while ($rowt = $resultticket->fetch_assoc()) {
        if ($rowt['klantId'] === $klantID) {
            echo 'ticketID:' . $rowt['ticketId'];
            $ticketID = $rowt['ticketId'];
        }
    }
//OMDAT WE NU TICKETID HEBBEN OPGEHAALD KUNNEN WE NU INSERTEN NAAR COMMENTAAR    
    if(!empty($tcom)){
        $insertcomment= $connectie->prepare("INSERT INTO commentaar(commentaarID, commOmschrijving, typeCommentaar, datum, accountNr, ticketId)
            VALUES ('',?,'$tcom','$datumAanmaak','$ftsAccountNr','$ticketID'  )");
            if ($insertcomment){
                $insertcomment->bind_param('s',$commentaar);
                if ($insertcomment->execute()){
                    //header("Refresh:5; url=../index.php", true, 303);
                }else {echo "Error : " . mysqli_error($connectie);}
    }else {echo "Error : " . mysqli_error($connectie);}}
            
            
if (!empty($oplossing)) {
//DATA WORDT INGEVOERD IN OPLOSSINGEN
$insertoplossing=$connectie->prepare("INSERT INTO oplossingen(oplossingId, definitief, oplossOmschrijving, datumFix, accountNr, ticketId)
        VALUES ('','$def', ?,'$datumAanmaak','$ftsAccountNr','$ticketID')");
        if($insertoplossing){
            $insertoplossing->bind_param('s', $oplossing);
            if ($insertoplossing->execute()){
            }else{echo "Error : " . mysqli_error($connectie);}
        }else{echo "Error : " . mysqli_error($connectie);}
} 
//ALS FILE GROTER IS DAN 1 DAN MOETEN DE BENODIGDE DINGEN IN VAR GEZET WORDEN ZODAT HET INGEVOERD KAN WORDEN
if ($_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];

    $fp      = fopen($tmpName, 'r');
    $bijlage = addslashes(fread($fp, $fileSize));
    fclose($fp);
    
    $fileQuery = "INSERT INTO bijlage (id, naam, lengte, type, bijlage, ticketId)
        VALUES ('', '$fileName', '$fileSize', '$fileType', '$bijlage', '$ticketID')";
    
    if(!$connectie->query($fileQuery)){
        echo "bijlageError : " . mysqli_error($connectie);
    }
        
}

header("Refresh:0; url=../index.php", true, 303);  
}
          
?>
<!DOCTYPE html>
<html>
    <head>
        <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    </head>

    <body>
        <!--  alle scripts  -->
            <script>
//AJAX REALTIME ZOEKFUNCTIE, DATA WORDT OPGEHAALD IN ZOEKKLANT IN KAN ZOEKEN DOOR DE INGETYPTE WOORDEN/CIJFERS IN INPUT ZOEK EN LAAT DAT ZIEN IN OUTPUT                
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
//VERWIJST NAAR #MESSAGE 1 OM DE TINYMCE VELD TE GEBRUIKEN               
                tinymce.init({
                    selector: '#message1',
                    menubar: false
                });
                
                function getSubcategorie(str){
                    // Het volgende stukje code ziet er op het eerste gezicht erg ingewikkeld uit
                    // Dit omdat het AJAX is zonder jquery, gemaakt om AJAX beter te begrijpen
                    // Onder het mom van 'eerst basis'
                    if (str === "") {
                        // Als hij leeg is laten we de innterHTML ook leeg
                        document.getElementById("subCategorieContent").innerHTML="";
                        return;
                    }
                    
                    if (window.XMLHttpRequest){
                        // Code voor recente browsers (IE7+, Chromium(chrome, safari, opera etc.), Firefox(iceweasel) etc
                        // Schept een nieuwe XML http aanvraag die naar de backend pagina gaat
                        xmlhttp=new XMLHttpRequest();
                    } else {
                        // Zelfde idee maar dan met ActiveX.
                        // Dit als uitval voor oudere (MICRO$OFT) browsers
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }               
                    // Bij statusverandering
                    xmlhttp.onreadystatechange=function()
                    {
                    // Bij een positieve terugkoppeling van de webpagina, geef de output weer
                    if (xmlhttp.readyState===4 && xmlhttp.status===200){
                        document.getElementById("subCategorieContent").innerHTML=xmlhttp.responseText;
                    }
                    }
                xmlhttp.open("GET","AJAX/getSubcategorie.php?cat="+str, true);
                xmlhttp.send();
                }
            </script>
<div class="container">
<div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                    <form name="nieuwTicket" action="nieuwTicketBestKlant.php" method="POST" enctype="multipart/form-data">
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
                        <select class="form" name="categorie" onchange ="getSubcategorie(this.value)">
                        <option value = "">---categorie---</option>
                            <?php
                            $ophaalcat = "SELECT * FROM categorie ";
                            $resultcat = mysqli_query($connectie, $ophaalcat);
                            while ($c = mysqli_fetch_assoc($resultcat)) {
                            echo "<option value='" . $c['categorieId'] . "'>" . $c['catOmschrijving'] . "</option>";
                            }
                            ?>
                        </select>	
                        <div id="subCategorieContent">
                            <!-- Hier wordt de tweede drop down ingezet -->
                        </div>
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
                        klant moet nog gebeld worden:
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionDefault" name="nogBellen" type="checkbox"/>
                            <label for="someSwitchOptionDefault" class="label-default"></label>
                        </div>
                    </li>
					</div></div>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                           <input name="userfile" type="file" id="userfile" class="form">
					
					<div class="row">
						<div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
                            <!-- Message -->
                            <textarea name="probleem" id="message1" class="form textarea">Probleem</textarea>
						</div>
						<div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
                            <!-- Message -->
                            <textarea name="nieuwComment" id="message2" class="form textarea">Commentaar</textarea>
                        </div>
						<div class="col-md-4 wow animated slideInRight" data-wow-delay=".5s">
                            <!-- Message -->
                            <textarea name="oplossing" id="message3" class="form textarea" >potentiele oplossing</textarea>
                                                </div><br>
                        <!-- Bottom Submit -->
                        <div class="relative fullwidth col-xs-12">
                            <!-- Send Button -->
                            <button type="submit" id="submit0" name="submit0" class="form-btn semibold">invoeren</button> 
                        </div><!-- End Bottom Submit -->
                        <!-- Clear -->
                        <div class="clear"></div></div></div>
                    </form>



                </div><!-- End Contact Form Area -->
            </div><!-- End Inner --></div>
            
            
    </body>
</html>
