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
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $connectie = verbinddatabase();
    
    // NEE DE ISADMIN CHECK MOET HIER NIET IN!!!!!!!!!!!
    
    if(isset($_POST['submitBedrijf'])){
        $naam = $_POST['naam'];
        $website = $_POST['website'];
        
        if(isset($_POST['kvkNr'])){
            $kvkNr = filter_var($_POST['kvkNr'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $kvkNr = 0;
        }
        
        $adres = $_POST['adres'];
        $postC = $_POST['postC'];
        $stad = $_POST['stad'];
        
        if(isset($_POST['tel'])){
            $tel = filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $tel = 0;
        }
        
        if(isset($_POST['btwNr'])){
            $btwNr = filter_var($_POST['btwNr'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            $btwNr = 0;
        }
        
        $insertBedrijfQuery = $connectie->prepare("INSERT INTO bedrijf (bedrijfsId, naam, website, kvkNr, 
                btwNr, adres, stad, postC, tel) VALUES ('', ?, ?,
                ?, '$btwNr', ?, ?, ?, '$tel')");
        $insertBedrijfQuery->bind_param("ssssss", $naam, $website, $kvkNr, $adres, $stad, $postC);
        $insertBedrijfQuery->execute();
        $insertBedrijfQuery->close();
        header('url=../index.php');
        die();
    }
?>

<html>
    <body>
        <header>
            <title>Invoer FTS</title>
        </header><hr>
    
    
    
        <div class="container">
            <div class="inner contact">  
                <div class="contact-form">


                        
                            <form name="bedrijf" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"enctype="multipart/form-data">
                                    		<div class="grid">
                    <div class="row">
                                <div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                                Bedrijfsnaam<br>
                                <input type="text" class="form" name="naam" required><br>
                                Website<br>
                                <input type="text" class="form" name="website" required><br>
                                Kvk nummer<br>
                                <input type="text" class="form" name="kvkNr"><br>
                                BTW. Nummer<br>
                                <input type="text" class="form" name="btwNr"><br>
                        </div>
                        <div class=" col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                                Adres<br>
                                <input type="text" class="form" name="adres" required><br>
                                Postcode<br>
                                <input type="text" class="form" name="postC" required><br>
                                Stad<br>
                                <input type="text" class="form" name="stad" required><br>
                                Telefoonnummer<br>
                                <input type="text" class="form" name="tel">
                                <button name="submitBedrijf" class="form-btn semibold" type="submit" value="1">Invoeren</button></div></div></div>
                            </form>
                        </div></div></div>
                                                    
        
        <hr>
               
