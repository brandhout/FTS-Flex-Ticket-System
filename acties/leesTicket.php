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

require_once '../functies.php'; //Include de functies.
require_once '../header.php'; //Include de header.

?>

<!-- Als je op tickets.php een ticket opent, komt de ticket op deze pagina te staan, met de informatie uit de database.
Je kan hier ook nieuw commentaar aanmaken, en oplossingen aandragen. Door de eerste behandelaar kan die definitief verklaard
worden. Er kan dus aan een ticket meerdere stukken commentaar en oplossingen hangen! Mocht de echte ticket aangepast worden
wordt de gebruiker doorgestuurd naar wijzigTicket.php. Dit alleen als er bijvoorbeeld een fout gemaakt is.-->