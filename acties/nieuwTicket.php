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
<h1> Nieuw ticket </h1>
<form name="nieuwTicket" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
          Probleem (korte omschrijving) <br>
          <input type="text" name="Beschrijving"><br>

          trefwoorden (aan elkaar, door komma gescheiden ) <br>
          <input type="text" name="Beschrijving"><br>

          Probleem (korte omschrijving) <br>
          <input type="text" name="Beschrijving"><br>

          <input type="checkbox" name="nogBellen" value="nogBellen">Klant moet nog gebeld worden<br><br>
          
          Categorie 
          <select name="categorie">
              <option></option>
              <option></option>
          </select><br><br>
          
          <strong>Streefdatum</strong><br>
          
                Dag (17) <br>
                <input type="text" name="dag"><br>
          
                Maand (2) <br>
                <input type="text" name="maand"><br>
          
                Jaar (2017) <br>
                <input type="text" name="jaar"><br><br>

                     Binnenkomst type: 
          <select name="binnenkomstType"> <!-- Moet nog gescript worden! Data moet uit database komen -->
              <option>Pas op, plaatshouders!</option>
              <option>E-mail</option>
          </select><br><br>

                     Lokatie: 
          <select name="binnenkomstType">
              <option></option>
              <option></option>
          </select><br><br>

          <strong>Veelvoorkomend laptop:</strong><br>
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
</form>