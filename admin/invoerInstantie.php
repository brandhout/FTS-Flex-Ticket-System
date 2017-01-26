<?php

   session_start();
    require_once '../functies.php'; //Include de functies.
    require_once '../header.php'; //Include de header.
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $connectie = verbinddatabase();
    
    if(isset($_POST['submitInstantie'])){
        $instantie = $_POST['instantie'];
        $prioriteit = filter_var($_POST['prioriteit'], FILTER_SANITIZE_NUMBER_INT);
        
        $insertInstantieQuery = $connectie->prepare("INSERT INTO instantie (instantieId, instantieNaam, proriteit) VALUES ('', ?, '$prioriteit')");
        $insertInstantieQuery->bind_param("s", $instantie);

        $insertInstantieQuery->execute();
        $insertInstantieQuery->close();
        header("Refresh:0; url=../index.php", true, 303);
    }
?>


<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body>
        Invoer instanties<br><br>
        
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                Naam instantie<br>
                <input type="text"  name="instantie"><br>

                Prioriteit<br>
                <input type="text" name="prioriteit"><br><br>

                <button  name="submitInstantie" type="submit" value="1">Invoeren</button>
            </form>
    </body>
</html>    
    
                
