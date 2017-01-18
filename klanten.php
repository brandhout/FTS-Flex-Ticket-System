<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();
$td = '</td><td align="left"></a>';

$klantenQuery = "SELECT * FROM klant";
    $klantenUitkomst = $connectie->query($klantenQuery);
    
echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Alle Klanten</title>
        <h1>Klantenlijst</h1>
    </head>
    <body>
<div class="containert1">
    <table align="left" cellspacing="5" cellpadding="8">
    <td align="left"><strong>KlantID</strong></td>
    <td align="left"><strong>Achternaam</strong></td>
    <td align="left"><strong>Voornaam</strong></td>
    <td align="left"><strong>Telefoon</strong></td>
    <td align="left"><strong>E-mail</strong></td>
    <td align="left"><strong>Adres</strong></td>
    <td align="left"><strong>Postcode</strong></td>
    <td align="left"><strong>Woonplaats</strong></td>
    <td align="left"><strong>Actie</strong></tr>
    
    ';

echo "Aantal klanten :".$klantenUitkomst->num_rows. "<br>";

while($klant = $klantenUitkomst->fetch_assoc()){
    echo '<tr><td align=left"> '.
    $klant['klantId'] . $td .
    $klant['klantAchternaam'] . $td .        
    $klant['klantNaam'] . $td .
    $klant['klantTel'] . $td .
    $klant['klantEmail'] . $td .
    $klant['klantAdres'] . $td .
    $klant['klantPostc'] . $td .
    $klant['klantStad'] . $td ;
    echo '
        <form action="acties/wijzigKlant.php">
            <button name="klantActie" type="submit" value="Wijzig'. $klant['klantId'] .'">Wijzigen</button>
            <button name="klantActie" type="submit" value="Verwijder'. $klant['klantId'] .'" disabled>Verwijderen</button>
        </form><tr></div>';
}

?>

<!DOCTYPE html>
<!--
Copyright (C) 2017 rhuijzer

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
    </body>
</html>
