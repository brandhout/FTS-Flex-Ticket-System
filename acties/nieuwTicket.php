<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connectie = verbinddatabase();
$output = '';
$fstAccountNr= $_SESSION['gebruikersNaam'];
$aantalXterug=NULL;
$terugstuurLock=FALSE;
$lijnNr=1;
$datumAanmaak= mysqldatum();
$log=NULL;
$verlopen=FALSE;
$binnenkomstType="tel";
$lokatie="standaard";
$klantTevreden=NULL;
$vVLaptopMerk=NULL;
$vVlaptopType=NULL;
$besturingssysteem="standaard";
$factuurNr=NULL;
$typeCommentaar=NULL;
$aangewAccountNr=NULL;
//variablen forms
$klantAchternaam = $_POST["klantAchternaam"]; 
$klantNaam = $_POST["klantNaam"]; 
$klantTel = $_POST["klantTel"]; 
$klantAdres = $_POST["klantAdres"]; 
$klantPostc = $_POST["klantPostc"]; 
$klantStad = $_POST["klantStad"]; 
$klantEmail = $_POST["klantEmail"]; 
$probleem = $_POST["probleem"]; 
$trefwoorden = $_POST["trefwoorden"]; 
$klantid = $_POST["klantid"]; 
$prioriteit = $_POST["prioriteit"]; 
$NogBellen = $_POST["NogBellen"]; 
$categorieNaam = $_POST["categorieNaam"]; 
$streefdatum = $_POST["streefdatum"];
$nieuwComment = $_POST["nieuwComment"];
    $OSQuery= 'SELECT besturingssysteemOm FROM besturingssysteem';
        $OSLijst= $connectie->query($OSQuery);
            //or die("Kan aangevraagde actie niet verwerken:" .mysql_error());
       
    if(!$_POST['besturingssysteem'] === ""){
        $besturingssysteemOm = $_POST['besturingssysteem'];
        $OSQueryTerug= "SELECT besturingssysteemId FROM besturingssysteem WHERE besturingssysteemOm= '$besturingssysteemOm'";
    }
    
if (!$_POST['submit1'] === "") {
        $nieuweKlantQuery =mysqli($connectie, "insert into klant klantAchternaam = $klantAchternaam,
                klantNaam = $klantNaam, klantTel = $klantTel, klantAdres = $klantAdres, klantPostc = $klantPostc,
                klantStad = $klantStad, klantEmail = $klantEmail");   
        $ophaalKlantQuery =mysqli($connectie, "SELECT klantId, klantNaam FROM klant WHERE klantNaam='$klantNaam'");     
            $result=mysqli_fetch_array($ophaalKlantQuery);
            $teller = mysqli_num_rows($ophaalKlantQuery);
                if ($teller == 1 && $result['klantnaam'] === $klantNaam ){
                    $_SESSION["klantId"] = $result['klantId'];
                    $klantId= $_SESSION["klantId"];
                }
                
        $ticketQuery = mysqli($connectie, "INSERT INTO ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
            probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
            aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = CURRENT_DATE,
            nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
            log = $log, verlopen = $verlopen, streefdatum = $streefdatum,
            lokatie = $lokatie, klantTevreden = $klantTevreden, commentaarId=$commentaarId, oplossingId=$oplossingId ");
        $ophaalticketQuery =mysqli($connectie, "SELECT ticketId, klantId FROM ticket WHERE klantid='$klantId'");     
            $result0=mysqli_fetch_array($ophaalticketQuery);
            $teller0 = mysqli_num_rows($ophaalticketQuery);
                if ($teller0 == 1 && $result0['klantId'] === $klantId ){
                    $_SESSION["ticketId"] = $result0['ticketId'];
                    $ticketId= $_SESSION["ticketId"];
                }                
                
        $CommentaarQuery = mysqli($connectie, "insert into commentaar commOmscrijving = $nieuwComment, typeCommentaar=$typeCommentaar, datum =$datumAanmaak, accountNr=$fstAccountNr,
            ticketId= $ticketId");
        $ophaalCommentaarQuery =mysqli($connectie, "SELECT commentaarId, ticketId FROM commentaar WHERE ticketId='$tickerId'");
            $result1= mysqli_fetch_array($ophaalCommentaarQuery);
            $teller1= mysqli_num_rows($ophaalCommentaarQuery);
                if ($teller1 == 1 && $result1['ticketId'] === $ticketId){
                    $_SESSION["commentaarId"] =$result1['commentaarId'];
                    $commentaarID=$_SESSION['commentaarId'];
                }
        
        $oplossingQuery= mysqli($connectie, "INSERT INTO oplossingen definitief=$definitief, oplossOmschrijving=$oplossOmschrijving,
            datumFIX=$datumFIX, accountNr=$ftsAccountNr, ticketId=$ticketId");
        $ophaalOplossingQuery=mysli($connectie, "SELECT oplossingId, ticketId FROM oplossingen WHERE ticketId='$ticketId'");
            $result2= mysqli_fetch_array($ophaalOplossingQuery);
            $teller2= mysqli_num_rows($ophaalOplossingQuery);
                if ($teller2 == 1 && $result1['ticketId'] === $ticketId){
                    $_SESSION["oplossingId"] =$result2['oplossingId'];
                    $oplossingId=$_SESSION['oplossingId'];
                }            
                
                
    
    if(!$connectie->query($ticketQuery)){
        echo "Ticket query mislukt..." . $connectie->error();
    }
    
    if(!$connectie->query($nieuweKlantQuery)){
        echo "Nieuwe Klant query mislukt..." . $connectie->error();
    }
}
        
 if (!$_POST['submit2'] === "") {  
        $ticketQuery = mysqli($connectie, "INSERT INTO ticket (fstAccountNr = $fstAccountNr, inBehandeling = TRUE, 
            probleem = $probleem, trefwoorden = $trefwoorden, klantId = $klantId, prioriteit = $prioriteit,
            aantalXterug = NULL terugstuurLock = FALSE, lijnNr = $lijnNr, datumAanmaak = CURRENT_DATE,
            nogBellen = $nogBellen, categorieNaam = $categorieNaam, factuurNr = $factuurNr,
            log = $log, verlopen = $verlopen, streefdatum = $streefdatum,
            lokatie = $lokatie, klantTevreden = $klantTevreden, commentaarId=$commentaarId, oplossingId=$oplossingId ");
        $ophaalticketQuery =mysqli($connectie, "SELECT ticketId, klantId FROM ticket WHERE klantid='$klantId'");     
            $result0=mysqli_fetch_array($ophaalticketQuery);
            $teller0 = mysqli_num_rows($ophaalticketQuery);
                if ($teller0 == 1 && $result0['klantId'] === $klantId ){
                    $_SESSION["ticketId"] = $result0['ticketId'];
                    $ticketId= $_SESSION["ticketId"];
                }                
                
        $CommentaarQuery = mysqli($connectie, "insert into commentaar commOmscrijving = $nieuwComment, typeCommentaar=$typeCommentaar, datum =$datumAanmaak, accountNr=$fstAccountNr,
            ticketId= $ticketId");
        $ophaalCommentaarQuery =mysqli($connectie, "SELECT commentaarId, ticketId FROM commentaar WHERE ticketId='$tickerId'");
            $result1= mysqli_fetch_array($ophaalCommentaarQuery);
            $teller1= mysqli_num_rows($ophaalCommentaarQuery);
                if ($teller1 == 1 && $result1['ticketId'] === $ticketId){
                    $_SESSION["commentaarId"] =$result1['commentaarId'];
                    $commentaarID=$_SESSION['commentaarId'];
                }
        
        $oplossingQuery= mysqli($connectie, "INSERT INTO oplossingen definitief=$definitief, oplossOmschrijving=$oplossOmschrijving,
            datumFIX=$datumFIX, accountNr=$ftsAccountNr, ticketId=$ticketId");
        $ophaalOplossingQuery=mysli($connectie, "SELECT oplossingId, ticketId FROM oplossingen WHERE ticketId='$ticketId'");
            $result2= mysqli_fetch_array($ophaalOplossingQuery);
            $teller2= mysqli_num_rows($ophaalOplossingQuery);
                if ($teller2 == 1 && $result1['ticketId'] === $ticketId){
                    $_SESSION["oplossingId"] =$result2['oplossingId'];
                    $oplossingId=$_SESSION['oplossingId'];
                }     
 }
?>


<!DOCTYPE html>
<html>

    <body>
        <h1> Nieuw ticket </h1>
        
        <!--  alle scripts  -->
            <script>
                function nieuwek(){
                                $(".hidden").toggle(300);
                                $(".hidden01").toggle(300);
                }
                function bestaandek(){
                                $(".hidden2").toggle(300);
                                $(".hidden02").toggle(300);
                }
                
                function zoekf(){
                    var zoektxt = $("input[name='zoek']").val();
                    $.post("AJAX/zoekKlant.php", {zoekval: zoektxt}, function(output){
                        $("#output").text(output);
                    });
                    
                }
            </script>

            <form name="nieuwTicket" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <button onclick="nieuwek()" type="button" id="nk" >nieuwe klant </button>
                           
                    <label class="hidden01">naam:</label><input id="text1" type="text" name="klantNaam" class="hidden"/><br>
                    <label class="hidden01">achternaam:</label><input id="text1" type="text" name="klantAchternaam" class="hidden"/><br>
                    <label class="hidden01">adres:</label><input id="text1" type="text" name="klantAdres" class="hidden"/><br>
                    <label class="hidden01">postcode:</label><input id="text1" type="text" name="klantPostc" class="hidden"/><br>			
                    <label class="hidden01">woonplaats:</label><input id="text1" type="text" name="klantStad" class="hidden"/><br>
                    <label class="hidden01">telefoonnummer:</label><input id="text1" type="text" name="klantTel" class="hidden"/><br>
                    <label class="hidden01">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" value="nogBellen" class="hidden"/><br>
					
                    <label class="hidden01">binnengekomen via:</label>
                        <select name="binnenkomstType" class="hidden"> <!-- Moet nog gescript worden! Data moet uit database komen -->
                            <option>Telefoon</option>
                            <option>E-mail</option>
                        </select><br>
                    <label class="hidden01">locatie:</label>
                        <select name="locatie" class="hidden"> <!-- Disabled, gaan we nog niets mee doen-->
                            <option>Hilversum Soestdijkerstraatweg</option>
                            <option>uy</option>
                        </select><br>
                    <label class="hidden01">trefwoorden (aan elkaar, door komma gescheiden)</label><input id="text1" type="text" name="trefwoorden" class="hidden"/></p>
			
                    <label class="hidden01">categorie:</label>
                        <select name="categorie" class="hidden">
                            <option>Software</option>
                            <option>Hardware</option>
                        </select><br>
                    <label class="hidden01">sub-categorie:</label>
                        <select name="subCategorie" class="hidden">
                            <option>Fedora Linux</option>
                            <option></option>
                        </select><br>
                    <label class="hidden01">merk:</label>
                        <select name="vVLaptopMerk" class="hidden">
                            <option>1</option>
                            <option>2</option>
                        </select><br>
                    <label class="hidden01">type:</label>
                        <select name="vVLaptopType" class="hidden">
                            <option>2</option>
                            <option>1</option>
                        </select><br>
                    <label class="hidden01">besturingsysteem:</label>
                        <select name="besturingssysteem" class="hidden">
                            <?php
                                while($OSrij = $OSLijst->fetch_assoc()) {
                                    echo '<option>' . $OSrij[besturingssysteemOm] . '</option>';
                                }
                            ?>
                            <option></option>
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
  
  
            
            
            <form name="nieuwTicket2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <button type="button" onclick="bestaandek()" id="bk">bestaandeklant</button><br>
                <input name='zoek' type="text" placeholder="zoeken in Achternaam"  onkeydown="zoekf();" class='hidden2'/><br>
                <label class="hidden02">klant ID:</label><textfield  type="text" id="output" name="fstAccountNr" class="hidden2"/></textfield><br>
                    <label class="hidden02">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" value="nogBellen" class="hidden2"/><br>
                
                     <label class="hidden02">binnengekomen via:</label>
                        <select name="binnenkomstType" class="hidden2"> <!-- Moet nog gescript worden! Data moet uit database komen -->
                            <option>Telefoon</option>
                            <option>E-mail</option>
                        </select><br>
                    <label class="hidden02">locatie:</label>
                        <select name="locatie" class="hidden2"> <!-- Disabled, gaan we nog niets mee doen-->
                            <option>Hilversum Soestdijkerstraatweg</option>
                            <option>uy</option>
                        </select><br>
                    <label class="hidden02">trefwoorden (aan elkaar, door komma gescheiden)</label><input id="text1" type="text" name="trefwoorden" class="hidden2"/></p>
			
                    <label class="hidden02">categorie:</label>
                        <select name="categorie" class="hidden2">
                            <option>Software</option>
                            <option>Hardware</option>
                        </select><br>
                    <label class="hidden02">sub-categorie:</label>
                        <select name="subCategorie" class="hidden2">
                            <option>Fedora Linux</option>
                            <option></option>
                        </select><br>
                    <label class="hidden02">merk:</label>
                        <select name="vVLaptopMerk" class="hidden2">
                            <option>1</option>
                            <option>2</option>
                        </select><br>
                    <label class="hidden02">type:</label>
                        <select name="vVLaptopType" class="hidden2">
                            <option>2</option>
                            <option>1</option>
                        </select><br>
                    <label class="hidden02">besturingsysteem:</label>
                        <select name="besturingssysteem" class="hidden2">
                            <?php
                                while($OSrij = $OSLijst->fetch_assoc()) {
                                    echo '<option>' . $OSrij[besturingssysteemOm] . '</option>';
                                }
                            ?>
                            <option></option>
                        </select><br>

                        <label class="hidden02">probleem(korte omschrijving:)</label><br>
                        <textarea id="probleem" class="hidden2"></textarea><br>
                        <label class="hidden02">commentaar:</label><br>
                        <textarea id="nieuwComment" class="hidden2"></textarea><br>
                        <label class="hidden02">potentieele oplossing:</label><br>
                        <textarea id="oplossing" class="hidden2"></textarea><br>
                    <!--datepicker-->
                    <label class="hidden02">streefdatum:</label>
                        <input type="date" id="datepicker" class="hidden2"/></p>  
                    
                    
                    
                    <input type="submit"value=">>" name="submit2" class='hidden2' />
                    
                </form>
    </body>
</html>
