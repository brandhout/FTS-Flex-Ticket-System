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
    require_once '../header.php'; //Include de header.
?>


<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body> <strong>
             <form name="instantie" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                Instantie <br>
