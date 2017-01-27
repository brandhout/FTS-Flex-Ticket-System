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
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../../index.php");
    }
    
    require_once '../../functies.php'; //Include de functies.
    require_once '../../header.php'; //Include de header.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    $connectie = verbinddatabase();
    error_reporting(E_ALL);

    echo '
        <div class="container">
        <img src="/ticketsysteem/styles/mousepointer.png">
        <h3> FTS Content Management! </h3>
        <a href="/ticketsysteem/admin/cms/faq.php">FAQ</a><br><br>';
