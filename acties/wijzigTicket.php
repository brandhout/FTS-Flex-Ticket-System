<?php

session_start();
require_once '../functies.php'; //Include de functies.
require_once 'headerUp.php'; //Include de functies.

?>

<!--
Dit is geen basisfunctionaliteit, indien te weinig tijd niet maken.

De pagina hier wordt vrijwel hetzelfde als NIEUW TICKET, maar je wordt hier naartoe gestuurd vanaf 
leesTicket.php met de data in de sessie. Deze pagina heeft geen nut zonder leesTicket.php. Daar wordt namelijk
de ticket geopend en de gebruiker kan daar klikken op wijzigen (of iets in die richting).
Hier komt een HTML form en daarin staat dus al de data over de ticket. Die kan
(indien aanvaadbaar) aangepast worden. Nieuw commentaar en oplossingen komen hier niet! -->

