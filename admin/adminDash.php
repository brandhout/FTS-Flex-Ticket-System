<?php
    
    session_start();
    require_once '../functies.php'; //Include de functies.

    require_once 'headerUp.php'; //Include de header.
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
    }
    

?>

<html>
        <head>
            <link rel="stylesheet" href="../styles.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">


        </head>
    <body>
        <header>
            <title>Admin Pagina</title>
        </header><hr>
        <!-- hier begint het -->
        
            						
						
                        
 <?php
     infoBar();
 ?>  
                                                
                                                        
                      <div class="containeradmin">
                          <div class="grid">
                          <div class="row">
                        <div class="clearfix"></div>
                <div class="col-xs-6 wow animated slideInLeft" data-wow-delay=".5s">
                    <div class="card card-default card-block">
                        <ul id="tabsJustified" class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link" href="" data-target="#tab1" data-toggle="tab">accountbeheer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="" data-target="#tab2" data-toggle="tab">bedrijf/instantie beheer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="" data-target="#tab3" data-toggle="tab">meer...</a>
                            </li>
                        </ul></div>
                        <!--/tabs-->
                        <br>
                        <div id="tabsJustifiedContent" class="tab-content">
                            <div class="tab-pane" id="tab1">
                                <div class="list-group">
                                    <a href="nieuwAccount.php" class="list-group-item"><span class="float-right label label-success"></span> account invoeren</a>
                                    <a href="accounts.php" class="list-group-item"><span class="float-right label label-success"></span>accounts inzien/bewerken/verwijderen </a>
                                </div>
                            </div>
                            <div class="tab-pane active" id="tab2">
                                <div class="list-group">
                                    <a href="invoerBedrijf.php" class="list-group-item"><span class="float-right label label-success"></span> bedrijf invoeren</a>
                                    <a href="invoerInstantie.php" class="list-group-item"><span class="float-right label label-success"></span>instantie invoeren </a>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="list-group">
                                <div class="list-group">
                                    <a href="cms/cmsDash.php" class="list-group-item"><span class="float-right label label-success"></span> content management</a>
                                    <a href="invoerApparaten.php" class="list-group-item"><span class="float-right label label-success"></span> apparaat invoeren</a>
                                    <a href="invoerCategorie.php" class="list-group-item"><span class="float-right label label-success"></span> categorie invoeren </a>
                                    <a href="binnenkomstType.php" class="list-group-item"><span class="float-right label label-success"></span> binnenkomsttype toevoegen</a>
                                </div>
                            </div>
                        </div>
                        <!--/tabs content-->
                    </div><!--/card-->
                </div><!--/col-->
                
<?php
  $connectie = verbinddatabase();
              $ticketQuery ="SELECT * FROM ticket;";
            $ticketUitkomst = $connectie->query($ticketQuery);
echo '<div class="col-xs-6 wow animated slideInLeft" data-wow-delay=".5s">

    <table id="examplead" class="display nowrap" cellspacing="0" width:100%>
                    <thead>
                    <tr>
                    <td><strong>TicketID</strong></td>
                    <td><strong>trefwoorden</strong></td>
                    <td><strong>Klantnaam</strong></td>
                    <td><strong>Lijn</strong></td>
                    <td><strong>Aannemer</strong></td>
                    <td><strong>Aangewezen</strong></td>
                    <td><strong>Streefdatum</strong></td>
                    <td><strong>Prioriteit</strong></td>
                    <td><strong>Status</strong></td>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                    <td><strong>TicketID</strong></td>
                    <td><strong>trefwoorden</strong></td>
                    <td><strong>Klantnaam</strong></td>
                    <td><strong>Lijn</strong></td>
                    <td><strong>Aannemer</strong></td>
                    <td><strong>Aangewezen</strong></td>
                    <td><strong>Streefdatum</strong></td>
                    <td><strong>Prioriteit</strong></td>
                    <td><strong>Status</strong></td>
                    </tr>
                    </tfoot><tbody>
                    
            ';
        		
        echo "<p>Aantal tickets :<strong>".$ticketUitkomst->num_rows. "</strong></p>";
			
	while($ticket = $ticketUitkomst->fetch_assoc()){
            $status = "Open";
            $opgelost = FALSE;
            $uitzondering = FALSE;
                                           
            $klantId = $ticket['klantId'];
                $klantQuery ="SELECT klantAchternaam FROM klant WHERE klantId = '$klantId'";
                    $klantUitkomst = $connectie->query($klantQuery);
                         
            if(!$klant = $klantUitkomst->fetch_assoc()){
                echo "Klant query mislukt..." . mysqli_error($connectie);
            }
            
            if($ticket['aangewAccountNr'] > 0){
                $aangewAccountNr = $ticket['aangewAccountNr'];
            } else {
                $aangewAccountNr = $ticket['fstAccountNr'];
            }
            
            $ticketId = $ticket['ticketId'];
            $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
                $oplossingUitkomst = $connectie->query($oplossingQuery);

            
            //Nieuw oplossing script
            while($oplossing = $oplossingUitkomst->fetch_assoc()){
                if($oplossing['definitief'] === "1"){
                    $status = "Gesloten";
                    $opgelost = TRUE;
                } 
            }
            
            if(overDatum($ticket['streefdatum'])){
                $status = '<p style="color:red">
                    Te laat,';
                if (!$opgelost){
                $status .= '<br>Open</p>';
                } else {
                    $status .= '<br>Gesloten</p>';
                }
            }
            
            if($opgelost === TRUE && $alleenOpen === TRUE){
                $uitzondering = TRUE;
            }
            
            if($opgelost === FALSE && $alleenGesloten === TRUE){
                $uitzondering = TRUE;
            }
                
            if(!$uitzondering){                                            
                echo '<tr><td><a href=../acties/leesTicket.php?ticket='. $ticket['ticketId'] .' >' .
                    $ticket['ticketId'] . '</a></td><td>' . 
                    $ticket['trefwoorden'] . '</td><td>' .
                    $klant['klantAchternaam'] . '</td><td>' .
                    $ticket['lijnNr'] . '</td><td>' .
                    leesAccountAchterNaam($ticket['fstAccountNr']) . '</td><td>' .
                    leesAccountAchterNaam($aangewAccountNr) . '</td><td>' .
                    datumOmzet($ticket['streefdatum']) . '</td><td>' .
                    prioriteitOmzet($ticket['prioriteit']) . '</td><td>' .
                    $status . '</td>';
                echo '</tr>';
            }
	}
   
	
	echo "</tbody></table></div>";
        ?>
                          </div></div></div>
                




        <hr></body>
</html>    
