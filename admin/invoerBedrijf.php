<?php

/* 
 * Copyright (C) 2017 rhuijzer
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
    require_once 'headerUp.php'; // Zet de header bovenaan deze pagina.
?>

<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body> <strong>
             <form name="bedrijf" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                Bedrijfsnaam <br>
                <input type="text" name="naam"><br><br>
                Website <br>
                <input type="text" name="website"><br><br>
                Kamer van Koophandel nummer <br>
                <input type="text" name="kvkNr"><br><br>
                BTW. Nummer <br>
                <input type="text" name="btwNr"><br><br>
                Adres <br>
                <input type="text" name="adres"><br><br>
                Postcode <br>
                <input type="text" name="postC"><br><br>
                Stad <br>
                <input type="text" name="stad"><br><br>
                Telefoonnummer <br>
                <input type="text" name="telNr"><br><br></strong>
                <button name="submitBedrijf" type="submit" value="1">Invoeren</button>
             </form>
               
