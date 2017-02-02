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
if(!isset($_SESSION['gebruikersNaam'])) {
	$ingelogd = FALSE;
	header('Location: acties/inloggen.php');
        die();
} else {
	$ingelogd = TRUE;
}

require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();
echo'
<div class="container">
<h1> FAQ </h1>
<strong>F</strong>requently <strong>A</strong>sked <strong>Q</strong>uestions
<br><br>';

$faqQuery = "SELECT * FROM faq";
$faqUitkomst = $connectie->query($faqQuery);
$faq = $faqUitkomst->fetch_assoc();

echo preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $faq['html']);