<?php
session_start();
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../header.php'; //Include de header.
    require_once '../functies.php'; //Include de functies.

    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
    
    $connectie = verbinddatabase();
// GEEN ID WAT DIT IS MAAR ZAL WEL
    if(isset($_GET['id'])){
        $id    = $_GET['id'];   
        $bijlage2Query = "SELECT naam, type, bijlage FROM bijlage WHERE id = '$id'";
        $bijlage2Uitkomst = $connectie->query($bijlage2Query);
        while($bijlage2 = $bijlage2Uitkomst->fetch_assoc()){
            $naam = $bijlage2['naam'];
            $type = $bijlage2['type'];
            $bijlage = $bijlage2['bijlage'];
            echo '<img src="data:' . $type . ';base64,'. base64_encode( $bijlage ) . '"/>';
         }
 
    }
    
?>