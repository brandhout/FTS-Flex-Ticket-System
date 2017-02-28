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
    echo'<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>';
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
        <script>
            function bedrijf(){
                var zoektxt = $("input[name='zoekBedrijf']").val();
                $.post("AJAX/getBedrijfsnaam.php", {zoekval: zoektxt}, function(bedrijfsnaam){
                    $("#bedrijfsnaam").text(bedrijfsnaam);
                });             
                }
        </script>
        
 
        <div class="container">
            <div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                    <form name="nieuwTicket" action="nieuwKlant.php" method="POST">
                        <!-- Left Inputs -->
			<div class="grid">
			<div class="row">
                        <div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                            <!-- voornaam -->
                            <input type="text" name="klantNaam" id="name" required="required" class="form" placeholder="voornaam" /><br>
                            <!-- achternaam -->
                            <input type="text" name="klantAchternaam" id="lname" required="required" class="form" placeholder="achternaam" /><br>
                            <!-- adres -->
                            <input type="text" name="klantAdres" id="adres" required="required" class="form" placeholder="adres" /><br>
                            <!-- postcode -->
                            <input type="text" name="klantPostc" id="zipcode" required="required" class="form" placeholder="postcode" /><br>
                            <!-- woonplaats -->
                            <input type="text" name="klantStad" id="city" required="required" class="form" placeholder="woonplaats" /><br>	
                            <!-- telefoonnummer -->
                            <input type="text" name="klantTel" id="phone" required="required" class="form" placeholder="telefoonnummer" /><br>	
                            <!-- email -->
                            <input type="email" name="klantEmail" id="email" required="required" class="form" placeholder="E-mail" /><br>							
                        </div>
                        <!-- End Left Inputs -->
                        <!-- mid inputs -->
                            <div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                            <select class="form" name="instantie">
                            <option value = "">---instanties---</option>';

                            <?php
                            $ophaali = "SELECT * FROM instantie ";
                            $resulti = mysqli_query($connectie, $ophaali);
                            while ($l = mysqli_fetch_assoc($resulti)) {
                            echo "<option value='" . $l['instantieId'] . "'>" . $l['instantieNaam'] . "</option>";
                            }
                            ?> 

                            </select><br>						
                            <input type="text" name="zoekBedrijf" id="zoekBedrijf" class="form" onblur="bedrijf();" placeholder="zoek op bedrijfsnaam" />
                            <p type="text" class="form" id="bedrijfsnaam" name="bedrijfsnaam" placeholder="resultaat"></p>
                            
                            <!-- End Mid Inputs -->
                            </div>
                            
                            <div class="relative fullwidth col-xs-12">
                            <button type="submit" id="nieuwKlant" name="nieuwKlant" class="form-btn semibold">invoeren</button>
                            </div></form></body></html>                                                      