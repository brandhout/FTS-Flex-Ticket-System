<?php

   session_start();
    require_once '../functies.php'; //Include de functies.
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $connectie = verbinddatabase();
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
        die();
    }
        
    if(isset($_POST['submitBinnenkomstType'])){
        
        $binnenkomst = $_POST['binnenkomstType'];           
        
        $insertBinnenkomstQuery = $connectie->prepare("INSERT INTO binnenkomstType (binnenkomstId, binnenkomstTypeOm) VALUES ('', ?)");
        $insertBinnenkomstQuery->bind_param("s", $binnenkomst);

        $insertBinnenkomstQuery->execute();
        $insertBinnenkomstQuery->close();
        echo '
        <script> location.replace("adminDash.php"); </script>';   
        die();
    } else {
        require_once '../header.php'; //Include de header.
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
                    <div class="row"><div class="col-xs-6 col-md-4 wow animated slideInLeft" data-wow-delay=".5s"></div>
                        <div class="col-xs-6 col-md-4 wow animated slideInLeft" data-wow-delay=".5s">        
                            <form name="binnenkomstType" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"><br>
                            Binnenkomst type<br>
                            <input type="text" name="binnenkomstType" class="form"><br><br>
                            <button  name="submitBinnenkomstType" class="form-btn semibold" type="submit" value="1">Invoeren</button>
                            </form>
                        </div> 
                        <div class="col-xs-6 col-md-4 wow animated slideInLeft" data-wow-delay=".5s">                         
        </div></div></div></div></div><hr>
    </body>
</html>    

