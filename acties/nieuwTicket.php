<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../functies.php'; //Include de functies.
require_once '../header.php'; //Include de functies.


//verbinddatabase();
//$fstAccountNr= Moet gekoppeld worden aan momenteel ingelogde account
$probleem=NULL;
$trefwoorden=NULL;
$aantalXterug=NULL;
$terugstuurLock=FALSE;
$lijnNr=1;
//datumAanmaak erin zetten!!!!!
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

?>
<img src="../fts.PNG">
<h1> Plaatshouder </h1>
<form name="nieuwTicket" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
          Probleem (korte omschrijving) <br>
          <input type="text" name="Beschrijving"><br>

          trefwoorden (aan elkaar, door komma gescheiden ) <br>
          <input type="text" name="Beschrijving"><br>

          Probleem (korte omschrijving) <br>
          <input type="text" name="Beschrijving"><br>

          <input type="checkbox" name="nogBellen" value="nogBellen">Klant moet nog gebeld worden<br>
          
          Categorie 
          <select name="categorie">
              <option></option>
              <option></option>
          </select><br>
          
          Streefdatum <br>
          
                Dag (17) <br>
                <input type="text" name="Beschrijving"><br>
          
                Maand (2) <br>
                <input type="text" name="Beschrijving"><br>
          
                Jaar (2017) <br>
                <input type="text" name="Beschrijving"><br>



    
<input type="submit" name="invoeren" value="invoeren"><br>    
</form>