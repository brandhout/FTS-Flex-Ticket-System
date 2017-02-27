<script>
    function bedrijf(){
        var zoektxt = $("input[name='zoekBedrijf']").val();
        $.post("AJAX/getBedrijfsnaam.php", {zoekval: zoektxt}, function(bedrijfsnaam){
            $("#bedrijfsnaam").text(bedrijfsnaam);
        });             
        }
</script>

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
require_once '../header.php'; //Include de header.
$connectie = verbinddatabase();

ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

if (isset($_POST['nieuwKlant'])){
    echo 'test';
} else {
    echo '
         
        <div class="container">
            <div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
                    <!-- Form -->
                    <form name="nieuwTicket" action="nieuwTicketNieuwKlant.php" method="POST" enctype="multipart/form-data">
                        <!-- Left Inputs -->
			<div class="grid">
			<div class="row">
                        <div class="col-md-4 wow animated slideInLeft" data-wow-delay=".5s">
                            <!-- voornaam -->
                            <input type="text" name="klantNaam" id="name" required="required" class="form" placeholder="voornaam" />
                            <!-- achternaam -->
                            <input type="text" name="klantAchternaam" id="lname" required="required" class="form" placeholder="achternaam" />
                            <!-- adres -->
                            <input type="text" name="klantAdres" id="adres" required="required" class="form" placeholder="adres" />
                            <!-- postcode -->
                            <input type="text" name="klantPostc" id="zipcode" required="required" class="form" placeholder="postcode" />
                            <!-- woonplaats -->
                            <input type="text" name="klantStad" id="city" required="required" class="form" placeholder="woonplaats" />	
                            <!-- telefoonnummer -->
                            <input type="text" name="klantTel" id="phone" required="required" class="form" placeholder="telefoonnummer" />	
                            <!-- email -->
                            <input type="email" name="klantEmail" id="email" required="required" class="form" placeholder="E-mail" />							
                        </div>
                        <!-- End Left Inputs -->
                        <!-- mid inputs -->
                            <div class="col-md-4 wow animated slideInLeft" data-wow-delay=".5s">
                            <select class="form" name="instantie">
                            <option value = "">---instanties---</option>';

                                $ophaali = "SELECT * FROM instantie ";
                                $resulti = mysqli_query($connectie, $ophaali);
                                while ($l = mysqli_fetch_assoc($resulti)) {
                                echo "<option value='" . $l['instantieId'] . "'>" . $l['instantieNaam'] . "</option>";
                                }
                            echo'    

                            </select>						
                            <input type="text" name="zoekBedrijf" id="zoekBedrijf" class="form" onblur="bedrijf();" placeholder="zoek op bedrijfsnaam" />
                            <p type="text" class="form" id="bedrijfsnaam" name="bedrijfsnaam" placeholder="resultaat"></p>
                            <a href="/ticketsysteem/admin/invoerBedrijf.php" target="_blank">Nieuw bedrijf</a><br><br>';
}
