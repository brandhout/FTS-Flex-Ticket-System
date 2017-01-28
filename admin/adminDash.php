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
            <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />-->

        </head>
    <body>
        <header>
            <title>Admin Pagina</title>
        </header>
        <!-- hier begint het -->
                <div class="container-fluid">
        <!-- mysqli codes komt nog. -->
  <div class="row mb-3">
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-success">
                        <div class="card-block bg-success">
                            <div class="rotate">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">account</h6>
                            <h1 class="display-1">134</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-danger">
                        <div class="card-block bg-danger">
                            <div class="rotate">
                                <i class="fa fa-list fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">openstaande tickets</h6>
                            <h1 class="display-2">87</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-info">
                        <div class="card-block bg-info">
                            <div class="rotate">
                                <i class="fa fa-twitter fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">alle tickets</h6>
                            <h1 class="display-3">132</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-warning">
                        <div class="card-block bg-warning">
                            <div class="rotate">
                                <i class="fa fa-share fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">voltooide tickets</h6>
                            <h1 class="display-1">36</h1>
                        </div>
                    </div>
                </div>
            </div>   

        
        


<div class="border row">
    <div class="border col-sm-3"> <input type="button" class="btna" value="apparaat invoeren" onclick="location.href = 'invoerApparaten.php';"></div>
        <div class="border col-sm-3"> <input type="button" class="btna" value="bedrijf invoeren" onclick="location.href = 'invoerBedrijf.php';"></div>
<div class="border col-sm-3"> <input type="button" class="btna" value="categorie invoeren" onclick="location.href = 'invoerCategorie.php';"></div>
<div class="border col-sm-3"> <input type="button" class="btna" value="instantie invoeren" onclick="location.href = 'invoerInstantie.php';"></div>
</div>
<div class="border row">
    <div class="border col-sm-3"> <input type="button" class="btna" value="account invoeren" onclick="location.href = 'nieuwAccount.php';"></div>
    <div class="border col-sm-3"> <input type="button" class="btna" value="account verwijderen" onclick="location.href = 'verwijderAccount.php';"></div>
    <div class="border col-sm-3"> <input type="button" class="btna" value="account wijzigen" onclick="location.href = 'wijzigAccount.php';"></div>
    <div class="border col-sm-3"> <input type="button" class="btna" value="binnenkomsttype invoeren" onclick="location.href = 'binnenkomstType.php';"></div>
</div>
</div>


?>
        
        




    </body>
</html>    
