<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; // Zet de header bovenaan deze pagina.

verbinddatabase();

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
<h1> Test </h1>
<form name="nieuwTicket" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<input type="submit" name="invoeren" value="invoeren"><br>    
</form>