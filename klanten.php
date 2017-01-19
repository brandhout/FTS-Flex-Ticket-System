<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();
$td = '</td><td>';

$klantenQuery = "SELECT * FROM klant";
    $klantenUitkomst = $connectie->query($klantenQuery);
    
echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Alle Klanten</title>

    </head>
    
    <body>
            <h1>Klantenlijst</h1>
<table id="example3" class="display" cellspacing="0" width="100%">
<thead>
<tr>
    <td><strong>KlantID</strong></td>
    <td><strong>Achternaam</strong></td>
    <td><strong>Voornaam</strong></td>
    <td><strong>Telefoon</strong></td>
    <td><strong>E-mail</strong></td>
    <td><strong>Adres</strong></td>
    <td><strong>Postcode</strong></td>
    <td><strong>Woonplaats</strong></td>
    <td><strong>Actie</strong></td>
    </tr>
    </thead>
    <tfoot>
<tr>
    <td><strong>KlantID</strong></td>
    <td><strong>Achternaam</strong></td>
    <td><strong>Voornaam</strong></td>
    <td><strong>Telefoon</strong></td>
    <td><strong>E-mail</strong></td>
    <td><strong>Adres</strong></td>
    <td><strong>Postcode</strong></td>
    <td><strong>Woonplaats</strong></td>
    <td><strong>Actie</strong></td>
    </tr>
    </tfoot><tbody>
    
    
    ';

echo "Aantal klanten :".$klantenUitkomst->num_rows. "<br>";

while($klant = $klantenUitkomst->fetch_assoc()){
    echo '<tr><td> '.
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
        </form></td></tr>';
}
echo '</tbody></table>';
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
