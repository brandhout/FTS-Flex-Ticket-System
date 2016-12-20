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

require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
?>

<h1> Dasboard </h1>




<?php session_start();

        if(isset($_SESSION['gebruikersNaam'])) {
            echo "Welkom " . $uitkomst['GebruikersNaam'] . "</br>";
        }  else {
            header('Location: acties/inloggen.php'); 

        }   ?>