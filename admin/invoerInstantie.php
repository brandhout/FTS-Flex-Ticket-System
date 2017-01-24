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
        //$prioriteit = $_POST['prioriteit'];
        $prioriteit = filter_var($_POST['prioriteit'], FILTER_SANITIZE_NUMBER_INT);
        echo $instantie . '<br>' . $prioriteit . '<br>';
        
        $insertInstantieQuery = $connectie->prepare("INSERT INTO instantie (instantieId, instantieNaam, proriteit) VALUES ('', ?, '$prioriteit')");
        echo 'prepare<br>';
        $insertInstantieQuery->bind_param("s", $instantie);
        echo 'bind_param<br>';

        $insertInstantieQuery->execute();
        echo 'execute<br>';
        $insertInstantieQuery->close();
        //header('url=adminDash');
        echo '<br>';
        echo 'klaar';
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
    
                
