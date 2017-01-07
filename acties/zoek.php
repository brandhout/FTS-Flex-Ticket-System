<?php
session_start();
require_once '../functies.php'; //Include de functies.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connectie = verbinddatabase();
$output = '';
$output2 = '';


if (isset($_POST['zoekval'])) {
    $searchq = $_POST['zoekval'];
    $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
    
    $leesKlantQuery= mysqli_query($connectie,"SELECT * FROM klant WHERE klantAchternaam LIKE '%$searchq%';");
    $count = mysqli_num_rows($leesKlantQuery);
        if($count ==0){
            $output = 'geen resultaten';
            $output = 'geen resultaten';
        }else{
            while($row= mysqli_fetch_array($leesKlantQuery)){
                    $anaam= $row['klantAchternaam'];
                    $vnaam=$row['klantNaam'];
                    $kid=$row['klantId'];
                    
                    $output.=$kid.'';
                    $output2.=$vnaam.' '.$anaam.'';
            
}}}
echo($output);   
echo ($output2)

?>
