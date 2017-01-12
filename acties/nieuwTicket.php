<?php
session_start();
require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connectie = verbinddatabase();// connectie database

$output = '';//laat bestaande klant zien

$fstAccountNr= $_SESSION['gebruikersNaam'];//sessie gebruiker

//naw
$naam = $_POST["klantNaam"];
$achternaam = $_POST["klantAchternaam"];  
$tel = $_POST["klantTel"]; 
$adres =$_POST["klantAdres"]; 
$postcode = $_POST["klantPostc"]; 
$stad = $_POST["klantStad"]; 
$email = $_POST["klantEmail"];
$lok=0;// tijdelijk
$lok1=1;//tijdelijk

//ticket
$locatie =$_POST["locatie"];
$btype =$_POST["binnenkomstType"];	
$trefwoorden =$_POST["trefwoorden"]; 
$prioriteit =$_POST["prioriteit"]; 
$nogbellen =$_POST["NogBellen"]; 
$categorie =$_POST["categorie"];	 
$streefdatum =$_POST["datepicker"];
$commentaar =$_POST["nieuwComment"];	
$probleem =$_POST["probleem"]; 	
$oplossing =$_POST["oplossing"];	
$merklaptop=NULL;
$merktype=NULL;
$scategorie=NULL;
$besturingsysteem=NULL;


//bullshit denk ik
$aantalXterug=NULL;
$terugstuurLock=FALSE;
$lijnNr=1;
$datumAanmaak= mysqldatum();
$log=NULL;
$verlopen=FALSE;
$klantTevreden=NULL;
$factuurNr=NULL;
$typeCommentaar=NULL;
$aangewAccountNr=NULL;


    
if (isset($_POST['submit1'])) {
// nieuwe klant	
    $insertklant = $connectie->prepare("INSERT INTO klant (klantId, klantAchternaam, klantNaam, klantTel,
    klantAdres, klantPostc, klantStad, klantEmail, instantieId, locatieId)
    VALUES ('',?,?,?,?,?,?,?,'$lok','$lok1')");      
	if ($insertklant){
            $insertklant->bind_param('sssssss', $achternaam, $naam, $tel, $adres, $postcode, $stad, $email);
            if($insertklant->execute()) {
		echo 'gelukt!';
            }
	}
// ophalen klant ID
    $ophaalKlantQuery = "SELECT * FROM klant WHERE klantNaam='$naam'";
    $result= $connectie->query($ophaalKlantQuery);
        if (mysqli_num_rows($result) ==0){
            echo "klant niet gevonden";
        }
            while($row= $result->fetch_assoc()) {
                if ($row['klantNaam'] === $naam ){
                    echo $row['klantNaam'];
                    $klantID= $row['klantId'];
                    echo $klantID;
                }
            }

    $insertTicket = $connectie->prepare("INSERT INTO ticket (");
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
                           
                    <label class="hidden01">naam:</label><input type="text" name="klantNaam" class="hidden"/><br>
                    <label class="hidden01">achternaam:</label><input type="text" name="klantAchternaam" class="hidden"/><br>
                    <label class="hidden01">adres:</label><input type="text" name="klantAdres" class="hidden"/><br>
                    <label class="hidden01">postcode:</label><input type="text" name="klantPostc" class="hidden"/><br>			
                    <label class="hidden01">woonplaats:</label><input type="text" name="klantStad" class="hidden"/><br>
                    <label class="hidden01">telefoonnummer:</label><input type="text" name="klantTel" class="hidden"/><br>
                    <label class="hidden01">email:</label><input type="text" name="klantEmail" class="hidden"/><br>
                    
                    
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