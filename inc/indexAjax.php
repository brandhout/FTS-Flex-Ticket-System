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

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    require_once '../functies.php'; //Include de functies.
    $connectie = verbinddatabase();//aanroepen van een functie connectie met database

    $datum = new DateTime();


    $ticketQuery ="SELECT * FROM ticket LIMIT 4;";
    $ticketUitkomst = $connectie->query($ticketQuery);
    
    $query3 = $connectie->prepare("SELECT oplossingId FROM oplossingen WHERE definitief = '1'");
    $query3->execute();
    $query3->store_result();
    $rowsbt = $query3->num_rows;
    
    $query10="SELECT ticketId FROM ticket";
    $uitkomst10 = $connectie->query($query10);
    $rowsat = $uitkomst10->num_rows;
    $ato = $rowsat-$rowsbt;
    
    echo '
        
        <div class="w3-quarter">
        <div class="nieuwDatabar w3-teal w3-hover-shadow w3-padding-32 w3-center">
                <i class="fa fa-pencil-square-o fa-5x"></i>             
                <p> Openstaande Tickets </p>
                <h1> '.$ato.' </h1>
        </div></div>
        
        <div class="w3-quarter">
        <div class="nieuwDataBar w3-green w3-hover-shadow w3-padding-32 w3-center">
            <i class="fa fa-ticket fa-5x"></i>
            <p> Aantal Tickets </p>
            <h1> '.$rowsat.' </h1>
        </div></div>

        <div class="w3-quarter">
        <div class="nieuwDataBar w3-indigo w3-hover-shadow w3-padding-32 w3-center">
            <i class="fa fa-times fa-5x"></i>
            <p> Gesloten Tickets </p>
            <h1> '.$rowsbt.' </h1>
        </div></div></div>
        <div class="container">
        </div>
        <p><h3 style="text-align:middle;"> Openstaande Tickets: </h3></p>
';
    
    while($ticket = $ticketUitkomst->fetch_assoc()){
        
        $klantId = $ticket['klantId'];
        $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";
        $klantUitkomst = $connectie->query($klantQuery);
        $klant = $klantUitkomst->fetch_assoc();
            
        if(overDatum($ticket['streefdatum'])){
            echo ' <div class="w3-quarter">
               <div class="nieuwDataBar w3-card-8 w3-red w3-center">';
        } else {
            echo ' <div class="w3-quarter">
               <div class="nieuwDataBar w3-card-8 w3-green w3-center">';
        }
        
        echo '
            
            <div class="w3-container w3-center">
            <a href=/ticketsysteem/acties/leesTicket.php?ticket='. $ticket['ticketId'] .' style=" color: white; text-decoration: none" >
            <h3>Ticket</h3>
            </div>
            <p>
            <i class="fa fa-ticket fa-5x"></i><strong>'. $ticket['ticketId'] .'</strong><p>
            <p> 
            Trefw: '. $ticket['trefwoorden'] .'
            <hr>
            Prioriteit: <strong>'. $ticket['prioriteit'] .'</strong> Lijn: <strong>1</strong><br>
            Klant: <strong>'. $klant['klantAchternaam'] .'</strong><br>            
            Aangewezen: <strong>'. leesAccountAchterNaam($ticket['aangewAccountNr']) .'</strong><br>
            ';
        $streefdatum = new DateTime($ticket['streefdatum']);
        $interval = $datum->diff($streefdatum);
        if(strpos($interval->format('%R%a dagen'),'-') !== FALSE ){
            echo '
                <p>
                '.$interval->format('%R%a dagen').'
                </p> 
                 ';  
        } else {
            echo '
                <p>
                '.$interval->format('%R%a dagen').'
                </p>   
            ';
        }
        echo '
            <div class="w3-section">
            </div>          
            </p></div></div></a>
        ';
        
    }

?>     
</div>
