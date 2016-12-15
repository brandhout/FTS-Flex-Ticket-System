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
         
        <div class="a1">            
            <p>Nieuwe klant (Voornaam)
                <input type="text" name="klantNaam" disabled></p></div>
         
        <div class="a2">     
            <p>Categorie <!-- Moet uit database komen -->
                <select name="categorie" disabled>
                    <option>Software</option>
                    <option>Hardware</option>
                        </select><br>
                            Subcategorie <!-- Disabled, voor later. -->
                                <select name="subCategorie" disabled>
                                    <option>Fedora Linux</option>
                                    <option></option>
                                </select></p></div>
         
        <div class="a3">           
            <p>telefoonnummer klant:<input type="text" name="klantTel">
            Klant moet nog gebeld worden:<input type="checkbox" name="nogBellen" value="nogBellen">
          </p>
</div>


<div class="a1">
    <p>Nieuwe klant (Achternaam)
        <input type="text" name="klantAchterNaam" disabled></p></div>

          
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
                <input type="text" name="jaar" disabled></div><br><br>
<div class="a4">
                     Binnenkomst type: 
          <select name="binnenkomstType" disabled> <!-- Moet nog gescript worden! Data moet uit database komen -->
              <option>Telefoon</option>
              <option>E-mail</option>
          </select><br><br>


 <div class="a2">  
          <p> <!-- Disabled, weinig tijd -->
          Merk:
          <select name="vVLaptopMerk" disabled>
              <option></option>
              <option></option>
          </select>     
      Type
          <select name="vVLaptopType" disabled>
              <option></option>
              <option></option>
          </select></p></div>
<div class="a3">
    <p>ontvangen via:
          <select name="binnenkomstType" disabled> <!-- Moet nog gescript worden! Data moet uit database komen -->
              <option>Telefoon</option>
              <option>E-mail</option>
          </select><br>
     Lokatie: 
              <select name="binnenkomstType" disabled> <!-- Disabled, gaan we nog niets mee doen-->
              <option>Hilversum Soestdijkerstraatweg</option>
              <option>uy</option>
              </select></p>
</div>

<div class="a1">  
     <p>Nieuwe klant (Adres)
         <input type="text" name="klantAdres" disabled></p></div>
  <div class="a2">            
     <p>Besturingssysteem
          <br><select name="besturingssysteem" disabled>
              <option>Windows</option>
              <option></option>
          </select></p></div>   
         <div class="a3"> 
     <p>Probleem (korte omschrijving)
         <textarea id="probleem"></textarea></p></div>
         
 <div class="a1">            
     <p>Nieuwe klant (Postcode)
         <input type="text" name="klantPostc" disabled></p></div>

 <div class="a2">            
           <p> Commentaar
               <textarea id="nieuwComment"></textarea></p>
            </div>
          <div class="a3">
          <p> Potentiele oplossing
              <textarea id="oplossing"></textarea></p></div>    
         
 <div class="a1">  
     <p>Nieuwe klant (Woonplaats)</p>
          <input type="text" name="klantStad" disabled></div>
       
<div class="a3">
    <input type="submit" name="submit" value="invoeren"></div>   

 </div>

</body>
</html>
