<?php

   session_start();
    require_once '../functies.php'; //Include de functies.
    require_once '../header.php'; //Include de header.
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $connectie = verbinddatabase();
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
        die();
    }
    
    if(isset($_POST['submitInstantie'])){
        $instantie = $_POST['instantie'];
        $prioriteit = filter_var($_POST['prioriteit'], FILTER_SANITIZE_NUMBER_INT);
        
        $insertInstantieQuery = $connectie->prepare("INSERT INTO instantie (instantieId, instantieNaam, prioriteit) VALUES ('', ?, '$prioriteit')");
        $insertInstantieQuery->bind_param("s", $instantie);

        $insertInstantieQuery->execute();
        $insertInstantieQuery->close();
        header("Refresh:0; url=adminDash.php", true, 303);
    }
?>


<html>
    <body>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
        <hr>
            
        <div class="container">
            <div class="inner contact">  
    		<div class="grid">
                    <div class="row">
                        <div class="col-xs-6 col-md-4 wow animated slideInLeft" data-wow-delay=".5s"></div>
                        <div class="col-xs-6 col-md-4 wow animated slideInLeft" data-wow-delay=".5s">    
                            <p><strong>Invoer instanties</strong></p><br>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                Naam<br>
                                <input type="text" class="form" name="instantie"><br>
                                Prioriteit<br>
                                <input type="text" class="form" name="prioriteit"><br><br>
                                <button  name="submitInstantie" class="form-btn semibold" type="submit" value="1">Invoeren</button>
                            </form>
                        </div></div></div></div></div><hr>
    </body>
</html>    
    
                
