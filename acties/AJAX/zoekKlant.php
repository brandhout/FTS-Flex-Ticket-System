<?php
require_once '../functies.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connectie = verbinddatabase();
$output = '';
if (isset($_POST['zoekval'])) {
    $searchq = preg_replace("#[^0-9a-z]#i","",$_POST['zoekval']);
    // Dit moet uitgebreider met realescapestring e.d
    $leesKlantQuery= mysqli_query($connectie,"SELECT * FROM klant WHERE klantAchternaam LIKE '%$searchq%';");
    $count = mysqli_num_rows($leesKlantQuery);
        if($count ==0){
            $output = 'geen resultaten';
        }else{
            while($row= mysqli_fetch_array($leesKlantQuery)){
                    $anaam= $row['klantAchternaam'];
                    $vnaam=$row['klantNaam'];
                    $kid=$row['klantId'];
                    $output.=$kid.'';
            
}}}
echo($output);
?>
