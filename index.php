<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

/*
 * TODO:
 * - Streefdatum weergeven
 * - Meer data toevoegen
 * - Opmaak
 */

require_once 'classes/gebruiker.php';
session_start();//sessie starten
if(!isset($_SESSION['gebruikersNaam'])) { //als sessie niet is ingelogd dan word header false en ga je naar het inlogpagina.
    $ingelogd = FALSE;
    header('Location: acties/inloggen.php');
    die();
} else {
    $ingelogd = TRUE;// anders is ingelogd true
}

require_once 'functies.php'; //Include de functies.
require_once 'header.php'; //Include de header.
$connectie = verbinddatabase();//aanroepen van een functie connectie met database

$datum = new DateTime();

$gebruiker = $_SESSION["gebruiker"];

?>


