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

require_once '../../functies.php';
$connectie = verbinddatabase();
session_start();

        $searchq = $_POST['zoekval'];
        $query = "SELECT * FROM bedrijf WHERE naam LIKE '%$searchq%';";
        if(!$uitkomst = $connectie->query($query)){
            echo "query mislukt..." . mysqli_error($connectie);
        }
        if($uitkomst->num_rows === 0) {
            $uit = "Zoek duidelijker of voeg nieuw bedrijf toe";
        } else {
            $bedrijf = $uitkomst->fetch_array();
                $naam = $bedrijf['naam'];
                $id = $bedrijf['bedrijfsId'];
                $_SESSION['bedrijfsId'] = $id;
                
                $uit = $naam ." (nr:" . $id .")";
        }
echo($uit);
?>