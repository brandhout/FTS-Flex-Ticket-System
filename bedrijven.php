<?php

/* 
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
session_start();
require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();
$td = '</td><td>';

$bedrijfQuery = 'SELECT * FROM bedrijf';
$bedrijfUitkomst = $connectie->query($bedrijfQuery);

echo '    
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Bedrijven</title>

    </head>
    
    <body>
    <hr><div class="containertabel">
            <h1>Bedrijven</h1>
';
//als sessie gebruiker een admin is 
if($_SESSION['isAdmin'] === '1'){
    echo '<a href="/ticketsysteem/admin/invoerBedrijf.php">nieuw bedrijf</a><br><br>';
}
echo'

<table id="example" class="display" class="display nowrap" cellspacing="0" width="100%">
    <thead>
    <tr>
    <td><strong>Bedrijfsnaam</strong></td>
    <td><strong>Website</strong></td>
    <td><strong>KVK nummer</strong></td>
    <td><strong>BTW nummer</strong></td>
    <td><strong>Adres</strong></td>
    <td><strong>Plaats</strong></td>
    <td><strong>Postcode</strong></td>
    <td><strong>Telefoon</strong></td>
    </tr>
    </thead>
<tfoot>
    <tr>
    <td><strong>Bedrijfsnaam</strong></td>
    <td><strong>Website</strong></td>
    <td><strong>KVK nummer</strong></td>
    <td><strong>BTW nummer</strong></td>
    <td><strong>Adres</strong></td>
    <td><strong>Plaats</strong></td>
    <td><strong>Postcode</strong></td>
    <td><strong>Telefoon</strong></td>
    </tr>
    </tfoot><tbody>
    
    ';

while($bedrijf = $bedrijfUitkomst->fetch_assoc()){
    echo '<tr><td>'.
    $bedrijf['naam'] . $td .
    $bedrijf['website'] . $td .
    $bedrijf['kvkNr'] . $td .
    $bedrijf['btwNr'] . $td .
    $bedrijf['adres'] . $td .
    $bedrijf['stad'] . $td .
    $bedrijf['postC'] . $td .
    $bedrijf['tel'] .'</td></tr>';
 
}
echo '</tbody></table></div>';
