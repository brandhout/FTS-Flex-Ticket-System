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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once '../../functies.php';
$connectie = verbinddatabase();
    
if($_SESSION['isAdmin'] < 1){
    echo '<script> window.alert("U bent geen Administrator!");</script>';
    header("refresh:0;url= ../../index.php");
    die();
   }
   
require_once '../../header.php';
   
$faqLeesQuery = "SELECT * FROM faq";
$faqLeesUitkomst = $connectie->query($faqLeesQuery);
$faq = $faqLeesUitkomst->fetch_assoc();

if(isset($_POST['html'])){
    $html = $connectie->real_escape_string($_POST['html']);
    $faqUpdateQuery = "UPDATE faq SET html = '$html'";
    if($connectie->query($faqUpdateQuery)){
        header("refresh:1; url=../../faq.php", true, 303);
    }
}

?>

<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
<script>
    tinymce.init({
        selector: '#message1',
        menubar: false
    });
</script>

<div class="container">
<h1> FAQ </h1>
<strong>F</strong>requently <strong>A</strong>sked <strong>Q</strong>uestions<br><br>
<div>
    <form name="faq" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>
        <textarea name="html" id="message1"> <?php echo $faq['html']; ?> </textarea><br><br>
        <input type="submit" name="opslaan" value="opslaan">
    </form> 

