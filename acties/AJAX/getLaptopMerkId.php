<?php
ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../functies.php';

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

$connectie = verbinddatabase();
session_start();

        $searchq = $_POST['zoekval'];
        $leesLaptopTypeQuery = "SELECT * FROM veelVoorkomendeLaptopTypes WHERE vVLaptopTypeOm LIKE '%$searchq%';";
        if(!$leesLaptopTypeUitkomst = $connectie->query($leesLaptopTypeQuery)){
            echo "Type query mislukt..." . mysqli_error($connectie);
        }
        if($leesLaptopTypeUitkomst->num_rows === 0) {
            $laptop = "Niet gevonden!";
        } else {
            $type = $leesLaptopTypeUitkomst->fetch_array();
                $merkId = $type['vVLaptopMerkId'];
                $typeOm = $type['vVLaptopTypeOm'];
                $_SESSION['typeId'] = $type['vVLaptopTypeId'];
                $laptopMerkQuery = "SELECT * FROM veelVoorkomendelaptopMerken WHERE vVLaptopMerkId = $merkId";
                $laptopMerkUitkomst = $connectie->query($laptopMerkQuery);
                    $merk = $laptopMerkUitkomst->fetch_array();
                        $merkOm = $merk['vVLaptopMerkOm'];
                    
                $laptop = $merkOm.' '.$typeOm;  
            
        }
echo($laptop);
?>