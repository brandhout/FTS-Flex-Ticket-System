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
    }
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
    }
    
    if(isset($_POST['submitBinnenkomstType'])){
        
        $binnenkomst = $_POST['binnenkomstType'];
       
        
        
        $insertBinnenkomstQuery = $connectie->prepare("INSERT INTO binnenkomstType (binnenkomstId, binnenkomstTypeOm) VALUES ('', ?)");
        echo 'prepare<br>';
        $insertBinnenkomstQuery->bind_param("s", $binnenkomst);
        echo 'bind_param<br>';

        $insertBinnenkomstQuery->execute();
        echo 'execute<br>';
        $insertBinnenkomstQuery->close();
        header('url=adminDash');
        echo '<br>';
        echo 'klaar';
    }
?>




<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body> 
            
        <form name="binnenkomstType" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"><br>
            Binnenkomst type<br>
            <input type="text" name="binnenkomstType"><br><br>
            <button  name="submitBinnenkomstType" type="submit" value="1">Invoeren</button>
        </form>
    </body>
</html>    

