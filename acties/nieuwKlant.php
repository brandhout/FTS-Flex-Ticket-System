<?php

/* 
 * Copyright (C) 2017 Rick Huijzer
 *
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
require_once '../functies.php'; //Include de functies.
$connectie = verbinddatabase();

if($_GET['popup'] == 1){
    echo'<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>'
    . '<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">';
}


if(!isset($_SESSION['gebruikersNaam'])) {
    header('Location: /ticketsysteem/acties/inloggen.php');
    die();
}

if (isset($_POST['nieuwKlant'])){
    //naw
    $naam = $_POST["klantNaam"];
    $achternaam = $_POST["klantAchternaam"];
    $tel = $_POST["klantTel"];
    $adres = $_POST["klantAdres"];
    $postcode = $_POST["klantPostc"];
    $stad = $_POST["klantStad"];
    $email = $_POST["klantEmail"];
    $instantie = $_POST["instantie"];
    $bedrijf = $_POST["bedrijf"];
    
    if(isset($_SESSION['bedrijfsId'])){
        $bedrijfsId = $_SESSION['bedrijfsId'];
    } else {
        $bedrijfsId = 0;
    }

    $insertklant = $connectie->prepare("INSERT INTO klant (klantId, klantAchternaam, klantNaam, klantTel,
        klantAdres, klantPostc, klantStad, klantEmail, instantieId, bedrijfsId)
        VALUES ('',?,?,?,?,?,?,?,?,?)");

    $insertklant->bind_param('sssssssii', $achternaam, $naam, $tel, $adres, $postcode, $stad, $email, $instantie, $bedrijfsId);
    $insertklant->execute();
    flush();
    die();
            
} else {
    if(!$_GET['popup'] == 1){
        require_once '../header.php'; //Include de header.
    }
}
?>
<head>
        <script>
            function bedrijf(){
                var zoektxt = $("input[name='zoekBedrijf']").val();
                $.post("AJAX/getBedrijfsnaam.php", {zoekval: zoektxt}, function(bedrijfsnaam){
                    $("#bedrijfsnaam").text(bedrijfsnaam);
                });             
                }
        </script>
</head>
<body>
 
        <div class="w3-container">
                <!-- Form Area -->
                    <!-- Form -->
                    <form name="nieuwTicket" action="nieuwKlant.php" method="POST" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
                        <h2 class="w3-center">Nieuwe Klant</h2>
                        <!-- voornaam -->
                        <input type="text" name="klantNaam" id="name" required="required" class="w3-input w3-border" placeholder="voornaam" /><br>
                        <!-- achternaam -->
                        <input type="text" name="klantAchternaam" id="lname" required="required" class="w3-input w3-border" placeholder="achternaam" /><br>
                        <!-- adres -->
                        <input type="text" name="klantAdres" id="adres" required="required" class="w3-input w3-border" placeholder="adres" /><br>
                        <!-- postcode -->
                        <input type="text" name="klantPostc" id="zipcode" required="required" class="w3-input w3-border" placeholder="postcode" /><br>
                        <!-- woonplaats -->
                        <input type="text" name="klantStad" id="city" required="required" class="w3-input w3-border" placeholder="woonplaats" /><br>	
                        <!-- telefoonnummer -->
                        <input type="text" name="klantTel" id="phone" required="required" class="w3-input w3-border" placeholder="telefoonnummer" /><br>	
                        <!-- email -->
                        <input type="email" name="klantEmail" id="email" required="required" class="w3-input w3-border" placeholder="E-mail" /><br>							
                        <select name="instantie" class="w3-input w3-border">
                        <option value = "">---instanties---</option>';

                        <?php
                        $ophaali = "SELECT * FROM instantie ";
                        $resulti = mysqli_query($connectie, $ophaali);
                        while ($l = mysqli_fetch_assoc($resulti)) {
                        echo "<option value='" . $l['instantieId'] . "'>" . $l['instantieNaam'] . "</option>";
                        }
                        ?> 

                        </select><br>						
                        <input type="text" name="zoekBedrijf" id="zoekBedrijf" onblur="bedrijf();" class="w3-input w3-border" placeholder="zoek op bedrijfsnaam" />
                        <p type="text" id="bedrijfsnaam" name="bedrijfsnaam" placeholder="resultaat"></p>

                        <p class="w3-center">
                        <button type="submit" class="w3-button w3-section w3-blue w3-ripple" id="nieuwKlant" name="nieuwKlant" class="form-btn semibold">invoeren</button>
        <p></form></div></body></html>                                                      