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
        </header>
        <!-- hier begint het -->
 <?php
     require_once '../infodb.php'; //Include de functies.
 ?>  

        <hr>
                        <div class="clearfix"></div>
                <div class="col-lg-6">
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
                                    <a href="Accounts.php" class="list-group-item"><span class="float-right label label-success"></span>accounts inzien/verwijderen </a>
                                    <a href="wijzigAccount.php" class="list-group-item"><span class="float-right label label-success"></span> account wijzigen</a>
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
                                    <a href="invoerApparaten.php" class="list-group-item"><span class="float-right label label-success"></span> apparaat invoeren</a>
                                    <a href="invoerCategorie.php" class="list-group-item"><span class="float-right label label-success"></span>categorie invoeren </a>
                                    <a href="binnenkomstType.php" class="list-group-item"><span class="float-right label label-success"></span> binnenkomsttype toevoegen</a>
                                </div>
                            </div>
                        </div>
                        <!--/tabs content-->
                    </div><!--/card-->
                </div><!--/col-->
                




    </body>
</html>    
