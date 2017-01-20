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
require_once '../header.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connectie = verbinddatabase();

$klantId = filter_var($_GET['klantActie'], FILTER_SANITIZE_NUMBER_INT);

$klantQuery = "SELECT * FROM klant WHERE klantId = $klantId";
    $klantUitkomst = $connectie->query($klantQuery);
    $klant = $klantUitkomst->fetch_assoc();
    
echo'
    <h1> Klantdata </h1>
    <form action="wijzigKlant.php?klantActie='. $klant['klantId'] .'"method="POST">
        <strong> Klantnaam </strong><br>
        <input type="text" name="klantNaam" value="'. $klant['klantNaam'] .'" maxlength="70" required><br>
        <strong> Klant achternaam</strong><br>
        <input type="text" name="klantAchternaam" value="'. $klant['klantAchternaam'] .'" required><br>
        <strong> telefoonnummer </strong><br>
        <input type="text" name="klantTel" value="'. $klant['klantTel'] .'" required><br>
        <strong> Adres </strong><br>
        <input type="text" name="klantAdres" value="'. $klant['klantAdres'] .'" required><br>
        <strong> Postcode </strong><br>
        <input type="text" name="klantPostc" value="'. $klant['klantPostc'] .'" required><br>
        <strong> Woonplaats </strong><br>
        <input type="text" name="klantStad" value="'. $klant['klantStad'] .'" required><br>
        <strong> e-mailadres </strong><br>
        <input type="text" name="klantEmail" value="'. $klant['klantEmail'] .'" required><br>
        <button name="submit" type="submit" value="submit">Doorvoeren</button>';

        if(isset($_POST['submit'])){
            $klantNaam = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['klantNaam'])));
            $klantAchternaam = mysqli_real_escape_string($connectie, stripcslashes($_POST['klantAchternaam']));
            $klantTel = filter_var($_POST['klantTel'], FILTER_SANITIZE_NUMBER_INT);
            $klantAdres = mysqli_real_escape_string($connectie, stripcslashes($_POST['klantAdres']));
            $klantPostc = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['klantPostc'])));
            $klantStad = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['klantStad'])));
            $klantEmail = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['klantEmail'])));
            $wijzigklantquery = "UPDATE klant SET klantNaam = '$klantNaam', klantAchternaam = '$klantAchternaam',
                klantTel = '$klantTel', klantAdres = '$klantAdres', klantPostc = '$klantPostc', klantStad = '$klantStad',
                klantEmail = '$klantEmail' WHERE klantId = '$klantId'";
            if(!$connectie->query($wijzigklantquery)){
              echo "Klant update query mislukt..." . mysqli_error($connectie);  
            }
        }