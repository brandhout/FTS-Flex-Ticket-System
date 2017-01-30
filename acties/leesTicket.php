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

    session_start();
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once '../header.php'; //Include de header.
    require_once '../functies.php'; //Include de functies.
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
//VAR
    $connectie = verbinddatabase();
    $opgelost = FALSE;
    $fstAccount = FALSE;
    $status = "Open";
    
//HAALT TICKETID OP VAN VORIGE PAGINA EN ZET HET IN VAR
    if (is_numeric($_GET['ticket'])) {
        $ticketId = $_GET['ticket'];
    }
//SELECTEERD ALLES VAN DB EN KIJKT OF HET GELIJK IS AAN VAR ID
    $ticketQuery = "SELECT * FROM ticket WHERE ticketId = '$ticketId'";
        $ticketUitkomst = $connectie->query($ticketQuery);
        $ticket = $ticketUitkomst->fetch_assoc();
//SELECTEERD AAN DE HAND VAN TICKETID DE RIJ DIE BIJ TICKETID HOORT IN DOORSTURING
    $doorstuurLogQuery = "SELECT * FROM doorsturing WHERE ticketId = '$ticketId'";
        $doorstuurLogUitkomst = $connectie->query($doorstuurLogQuery);
//SELECTEERD ALLES VAN KLANT WAARVAN DE RIJ OVEREENKOMT MET KLANTID VAN TICKET       
    $klantId = $ticket['klantId'];
        $klantQuery ="SELECT * FROM klant WHERE klantId = '$klantId'";
        $klantUitkomst = $connectie->query($klantQuery);             
        $klant = $klantUitkomst->fetch_assoc();
//SELECTERD ALLES VAN OPLOSSINGEN WAARVAN DE RIJ OVEREENKOMT MET TICKETID VAN TICKET        
    $oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
        $oplossingUitkomst = $connectie->query($oplossingQuery);
//SELECTEERD ALLES VAN COMMENTAAR WAARVAN DE RIJ OVEREENKOMT MET TICKETID VAN TICKET        
    $commentaarQuery = "SELECT * FROM commentaar WHERE ticketId = '$ticketId'";
        $commentaarUitkomst = $connectie->query($commentaarQuery);
//SELECTEERD ALLES VAN BIJLAGE WAARVAN DE RIJ OVEREENKOMT MET TICKETID VAN TICKET        
    $bijlageQuery = "SELECT * FROM bijlage WHERE ticketId = '$ticketId'";
        $bijlageUitkomst = $connectie->query($bijlageQuery);
//FUNCTIE CHECK FUNCTIES.PHP
    if(checkDefinitief($ticketId)){
        $opgelost = TRUE;
        $status = "Gesloten";
    }
//FUNCTIE CHECK FUNCTIES.PHP    
    if(overDatum($ticket['streefdatum'])){
        $overDatum = TRUE;
        $status = '
                    Te laat,';
        if (!$opgelost){
            $status .= 'Open';
        } else {
            $status .= 'Gesloten';
        }
//ALS REDENTELAAT LEEG IS DAN MOET ER EEN REDEN INGEVULD WORDEN FORM WORDT WEERGEGEVEN      
        if ($ticket['redenTeLaat'] === NULL){
            $status .= '
                        <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
                            <input type="text" name="redenTekst" value="Reden ticket te laat" maxlength="70" required>
                            <button name="reden" type="redenSubmit" value="lijnDwn">Bevestig</button>';
        }
    }
   
    $accountNr = $_SESSION["accountNr"]; 
// ALS LIJNUP(FORM) IN IS GEDRUKT EN GELIJK IS AAN LIJNUP EN LIJNNR VAN TICKET KLEINER OF GELIJK IS AAN 3 DAN WORDEN ALLE VELDEN DIE ZIJN INGEVULD GEUPDATE IN DB VIA FUNCTIE    
    if($_POST['lijnUp'] === "lijnUp" && $ticket['lijnNr'] <= 3 ){
        $opmerking = $_POST['opmerking'];
        $vanLijn = $ticket['lijnNr'];
        $naarLijn = $vanLijn+1;           
        updateLijn($vanLijn, $naarLijn, $opmerking, $ticketId, $accountNr);                               
    }
//ZELFDE ALS HIERBOVEN MAAR DAN HET TEGENOVERGESTELDE
    if($_POST['lijnDwn'] === "lijnDwn" && $ticket['lijnNr'] >1){
        $opmerking = $_POST['opmerking'];
        $vanLijn = $ticket['lijnNr'];
        $naarLijn = $vanLijn-1;
        updateLijn($vanLijn, $naarLijn, $opmerking, $ticketId, $accountNr);
    }
//ALS CHECKBOX IN IS GEVULT DAN WORDT NOGBELLEN GEUPDATE MET 1 EN ANDERS 0 VIA FUNTIE
    if(isset($_POST['nogBellen'])){
        if($_POST['nogBellen'] === "0"){
            updateNogBellen("0",$ticketId);
        }
        if($_POST['nogBellen'] === "1"){
            updateNogBellen("1",$ticketId);
        }            
        header("Location: ../index.php");
    }
//HIER WORDT REDENTELAAT GEUPDATE AAN DE HAND VAN TICKETID
    if(isset($_POST['redenTekst'])){
        $ticketId = $ticket['ticketId'];
        $redenTekst = $_POST['redenTekst'];
        $teLaatRedenQuery = "UPDATE ticket SET redenTeLaat = '$redenTekst' WHERE ticketId = '$ticketId'";
        if(!$connectie->query($teLaatRedenQuery)){
            echo "teLaatReden query mislukt..." . mysqli_error($connectie);
        }
        header("Location: ../tickets.php");
    }
// HIER WORDT COMMENTAAR IN DE DATABASE GEZET MET EEN BIND_PARAM METHODE  OM SQL-INJECTIES TEGEN TE GAAN       
    if(isset($_POST['commentaar'])){
        $commentaar = $_POST['commentaar'];
        $tcom = 0;
        $fstAccountNr = $_SESSION["accountNr"];
        $datumAanmaak = mysqldatum();

        $insertcomment= $connectie->prepare("INSERT INTO commentaar(commentaarID, commOmschrijving, typeCommentaar, datum, accountNr, ticketId)
        VALUES ('',?,'$tcom','$datumAanmaak','$fstAccountNr','$ticketId'  )");
        if ($insertcomment){
            $insertcomment->bind_param('s',$commentaar);
            if ($insertcomment->execute()){
                header("Location: ../tickets.php");
            } else {
                echo "Error : " . mysqli_error($connectie);               
            }
        } else {
            echo "Error : " . mysqli_error($connectie);               
        } 
    }
 //ALS ER EEN OPLOSSING IS DAN WORDT DAT IN DE DATABASE GEDAAN VIA BIND_PARAM       
    if (isset($_POST['oplossing'])){
        $oplossing = $_POST['oplossing'];
        $def = '0';
        $datumAanmaak = mysqldatum();
        $fstAccountNr = $_SESSION["accountNr"];
        
        if(isset($_POST['definitief'])){
            $def = '1';
        }
        
        $insertoplossing=$connectie->prepare("INSERT INTO oplossingen(oplossingId, definitief, oplossOmschrijving, datumFix, accountNr, ticketId)
        VALUES ('','$def', ?,'$datumAanmaak','$fstAccountNr','$ticketId')");
        if($insertoplossing){
            $insertoplossing->bind_param('s', $oplossing);
            if ($insertoplossing->execute()){
                header("Location: ../tickets.php");               
            } else {
                echo "Error : " . mysqli_error($connectie);   
            }
        } else {
            echo "Error : " . mysqli_error($connectie);
        }
    }
//ALS AANWIJZER NIET LEEG IS DAN WORDT DE TICKET GEKOPPELD AAN EEN ANDER ACCOUNT    
    if(isset($_POST['aanwijzer'])){       
        $aanwijzer = $_POST['aanwijzer'];
        $aanwijsQuery = "UPDATE ticket SET aangewAccountNr = '$aanwijzer' WHERE ticketId = '$ticketId'";
        if(!$connectie->query($aanwijsQuery)){
            echo "Error : " . mysqli_error($connectie);
        }
        header("Location: ../tickets.php");
    }
           
 // PAGINA WORDT WEERGEGEVEN           
    echo '
        <!DOCTYPE html>
        <html>
        <head>
        <title>Ticket Informatie FTS</title>
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>
            tinymce.init({
                    selector: "#mce",
                    menubar: false,
                    readonly : 1
                });
        </script>
        </head>
        <body><hr><div class="containerlees">
        <p><strong> Ticketinfo </strong></p>
        
<div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
<div class="grid">
<div class="row">
<div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">

         <p>ticketnummer: </p><input class="form" type="text" disabled="disabled" placeholder="'. $ticketId . '"/>
             
        <p>Probleem: </p><textarea class="form" id="mce" disabled="disabled">'.$ticket['probleem'].'</textarea>

        <p>Trefwoorden: </p><textarea class="form" disabled="disabled">' .$ticket['trefwoorden'].'</textarea>
            
        <p> Status: </p><input type="text" class="form" disabled="disabled" placeholder="' .$status. '"/>
            
        <p> Prioriteit: </p><input type="text" class="form" disabled="disabled" placeholder="'.prioriteitOmzet($ticket['prioriteit']).'"/>
            
        <p>Lijn: </p><input type="text" class="form" disabled="disabled" placeholder="'.$ticket['lijnNr'].'"/>
            
        <p> Streefdatum: </p><input type="text" class="form" disabled="disabled" placeholder="'.datumOmzet($ticket['streefdatum']).'"/>'
            ;
   
//ALS AANGEWEZENACCOUNTNR GROTER IS DAN NUL DAN WORDT DIT WEERGEGEVEN     
    if($ticket['aangewAccountNr'] > 0){
                $aangewAccountNr = $ticket['aangewAccountNr'];
                echo'
                <p> Aangewezen operator: </p> <input class="form" type="text" disabled="disabled" placeholder="'.leesAccountAchterNaam($aangewAccountNr).'"/> </div>';
            }else {
            echo '</div>';}
//ALS AAN DE HAND VAN TICKET, LAPTOPTYPEID GROTER IS DAN O DAN SELECTEERD DE QUERY DE DESBETREFFENDE VELD EN ZET HET IN EEN VAR          
    if($ticket['vVLaptopTypeId'] > 0){
        $typeId = $ticket['vVLaptopTypeId'];
        $typeQuery = "SELECT * FROM veelVoorkomendeLaptopTypes WHERE vVLaptopTypeId = '$typeId'";
        if(!$typeUitkomst = $connectie->query($typeQuery)){
            echo "Type query mislukt..." . mysqli_error($connectie);
        }
        $type = $typeUitkomst->fetch_assoc();
        $merkId = $type['vVLaptopMerkId'];
        $typeOm = $type['vVLaptopTypeOm'];
//MERK WORDT OPGEHAALD AAN DE DE HAND VAN LAPTOPMERKID EN ZET ZE IN VAR       
        $merkQuery = "SELECT vVLaptopMerkOm FROM veelVoorkomendelaptopMerken WHERE vVLaptopMerkId = '$merkId'";
        if(!$merkUitkomst = $connectie->query($merkQuery)){
            echo "Merk query mislukt..." . mysqli_error($connectie);
        }
        $merk = $merkUitkomst->fetch_assoc();
        $merkOm = $merk['vVLaptopMerkOm'];
        echo '
            <div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
            <p> Laptop: </p>
            Merk:<input type="text" class="form" disabled="disabled" placeholder="'.$merkOm.'"/><br>
            Type:<input type="text" class="form" disabled="disabled" placeholder="'.$typeOm.'"/>';
    }else{echo'<div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">';}
    
//ALS HET LIJNR VAN DE TICKET HETZELFDE IS ALS HET LIJNNR VAN DE SESSIE OF HET EEN ADMIN IS DAN MAG ER DOORGESTUURD WORDEN 
    if($ticket['lijnNr'] === $_SESSION['lijnNr'] or $_SESSION['isAdmin'] === "1"){
        echo '
            <p> Doorsturen:</p>
            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
            <textarea class="form" placeholder="reden doorsturing" name="opmerking" value="Reden doorsturing" maxlength="70" required></textarea><br>     
            ';
//ALS TICKET LIJNNR GROTER IS DAN 1 EN KLEINER OF GELIJK IS AAN 3 DAN VERSCHIJNT LIJNOMLAAG KNOP
        if($ticket['lijnNr'] > 1 && $ticket['lijnNr'] <= 3) {
            echo '
                <button name="lijnDwn" type="submit" value="lijnDwn">Lijnomlaag</button> ';
            }
 //ALS TICKET LIJNR KLEINER IS DAN 3 DAN VERSCHIJNT LIJN OMHOOG KNOP           
        if($ticket['lijnNr'] < 3) {
            echo '
                <button name="lijnUp" type="submit" value="lijnUp">Lijnomhoog</button> ';
            }            
            echo'
                </form>';            
    } else {
// ALS REGEL243 NIET HET GEVAL IS DAN VERSCHIJNEN DE VOLGENDE VELDEN
        echo'
        <p> Behandelaar </p>
        <input type="text" class="form" disabled="disabled" placeholder="'.leesAccountAchterNaam($ticket['fstAccountNr']).'"/>
        <input type="text" class="form" disabled="disabled" placeholder="'.$ticket['fstAccountNr'].'"/>';      
    }
    
    echo '<form name="leesTicket" action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';
//ALS HET NIET DEFINITIEF IS EN LIJN NR GELIJK IS AAN SESSIE DAN KOMT ER EEN TEXTVELD BIJ
    if(!$definitief && $ticket['lijnNr'] === $_SESSION['lijnNr']){
        echo '<p> Nieuwe oplossing:</p>
            <form action ="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                <textarea class="form" type="text" name="oplossing" maxlength="70"></textarea><br>';
//ALS SESSIE GELIJK IS AAN ACCOUNTNR VAN DE TICKET DAN VERSCHIJNT ER EEN CHECKBOX OM EEN TICKET AFTERONDEN         
                if($_SESSION["accountNr"] === $ticket['fstAccountNr']){
                   echo '<input type ="checkbox" name="definitief" value="1">Definitief';
                }                                    
        echo'        
                <button name="submitOplossing" type="submit" value="1">Verstuur</button>
            </form><br>

            <p> Nieuw commentaar: </p>
            <form action ="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                <input class="form" type ="text" name="commentaar"><br>
                <button name="submitCommentaar" type="submit" value="1">Verstuur</button><br><br>
                </form>
            ';
            
    }

    
//ALS ADMIN IN SESSIE IS (1) DAN KAN ADMIN EEN TICKET VERWIJZEN NAAR EEN ANDER PERSOON
    if($_SESSION['isAdmin'] === "1"){
//SELECT VELD WORDT WEERGEGEVEN EN KAN GEKOZEN WORDEN UIT ACCOUNT DIE ZIJN OPGEHAALD
        echo ' <br><br>
            <p>Account aanwijzen</p>
            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
            <select class="form" name="aanwijzer">
            ';
        $aanwijsQuery = "SELECT accountNr, achterNaam FROM account";
        $aanwijsUitkomst = $connectie->query($aanwijsQuery);
        while($aanwijzer = $aanwijsUitkomst->fetch_array()){
            echo "
                <option value=".$aanwijzer['accountNr'].">".$aanwijzer['achterNaam']."</option>              
                ";
        }
        echo '</select>
            <button name="submit" type="submit" value="submit">Verstuur</button><br<br></form>
            ';
    }
    
    echo '</div>';
    echo '<div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"><p><strong> Klant</strong></p>';
//ALS INSTANTIE ID GROTER IS DAN 0 DAN LAAT DIE INSTANTIE ZIEN DMV FUNCTIE    
    if($klant['instantieId'] > 0){
        echo '<p> Instantie: </p><input class="form" type="text" disabled="disabled" placeholder="'.leesInstantieNaam($klant["instantieId"]).'"/>';
    }
    
    if($klant['bedrijfsId'] > 0){
        echo '<p> Bedrijfsnaam </p><input class="form" type="text" disabled="disabled" placeholder="'.leesBedrijfsNaam($klant["bedrijfsId"]).'"/>';
    }
            
    echo '
    <p> Achternaam: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantAchternaam'].'"/>
    <p> Voornaam: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantNaam'].'"/>
    <p> Telefoon: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantTel'].'"/>';

    echo '<form action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';
// ALS DE WAARDE 1 OF 0 IS DAN WORDEN 1 VAN DE VOLGENDE ZINNEN WEERGEGEVEN
    if($ticket['nogBellen'] === "1"){
        echo '<p>Klant <strong>moet nog</strong> gebeld worden! <p>
            <button name="nogBellen" type="submit" value="0">Klant is gebeld</button>';

    } else {
        echo '
            <p>Klant <strong>hoeft niet</strong> gebeld te worden <br>
            <button name="nogBellen" type="submit" value="1">Klant moet gebeld worden</button>
            </form>
            ';
    }
    
    echo'
    <p> Adres: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantAdres'].'"/>
    <p> Postcode: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantPostc'].'"/>
    <p> Woonplaats: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantStad'].'"/>

    <p> Emailadres: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantEmail'].'"/></div>
    <div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">   
    <p> Logboek: <br>
    Ticket is op <strong>'.datumOmzet($ticket['datumAanmaak']).'</strong> aangemaakt door <strong>'.leesAccountAchterNaam($ticket['fstAccountNr']).'</strong><p>';
// ALS OVERDATUM VAR IS GEMAAKT DAN WORDEN DE DATUM, REDEN OF DAT HET NOG NIET IS INGEVULD WEERGEGEVEN
    if($overDatum){
        echo'
            Sinds <strong>'.datumOmzet($ticket['streefdatum']).'</strong> is deze ticket te laat,<br>';
        if($ticket['redenTeLaat'] === ""){
            echo '
                <strong>Reden nog niet ingevuld</strong><br>';
        } else {
            echo '<textarea class="form" disabled="disabled">reden:'.$ticket['redenTeLaat'].'</textarea>';
        }
    }

    //echo '<p><strong> Doorsturingen </strong></p>';
// WHILE LOOP DIT HAALT ALLE LOGS VAN DESBETREFFENDE TICKET UIT DE DATABASE EN LAAT DIT ZIEN
    while($doorstuurLog = $doorstuurLogUitkomst->fetch_assoc()){
        echo '<br>Doorsturing:<br>'
        . 'Ticket is op <strong>'.datumOmzet($doorstuurLog['datum']).'</strong> doorgestuurd
                van Lijn <strong>'.$doorstuurLog['vanLijn'].'</strong>
                naar Lijn <strong>'.$doorstuurLog['naarLijn'].'</strong>
                door <strong>'.leesAccountAchterNaam($doorstuurLog['accountNr']).'</strong>
                met <strong>accountnr: '.$doorstuurLog['accountNr'].
                '</strong><textarea class="form" disabled="disabled">
                '.$doorstuurLog["opmerking"].'</textarea>';

    }

    //echo '<p><strong> Oplossingen </strong></p>';
//WHILE LOOP DIT HAALT ALLE OPLOSSINGEN VAN DB EN LAAT DIT ZIEN
    while($oplossingen = $oplossingUitkomst->fetch_array()){
        echo '
            <br> Oplossing:<br>
            Er is op <strong>'.datumOmzet($oplossingen['datumFix']).'</strong>
            een oplossing aangedragen
            door <strong>'.leesAccountAchterNaam($oplossingen['accountNr']).'</strong>
            <br>met <strong>accountnr: '.$oplossingen['accountNr'].'
            </strong><br>
            <textarea class="form" disabled="disabled">

            '.$oplossingen['oplossOmschrijving'].'
            </textarea>';
//ALS DEFINITIEF DE WAARDE 1 HEEFT IS DIE AFGESLOTEN EN LAAT DAT OOK ZIEN
            if($oplossingen['definitief'] === "1"){
                $definitief = TRUE;
                echo 'De oplossing is <strong>definitief</strong>,
                 de ticket is afgesloten<br>';                 
            } else {
// ALS DIE NOG NIET IS AFGESLOTEN EN ACCOUNT NR GELIJK IS AAN FTSACCOUNT DAN VERSCHIJNT DE DEFINITIEF KNOP 
                echo '<br>De oplossing is <strong>niet</strong> definitief.<br>';
                if($_SESSION['accountNr'] === $ticket['fstAccountNr']){
                    echo '
                        <p>
                        <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                            <button type="submit" value="def">Definitief</button></p>                           
                    ';
                }
            }

    }
// DIT LAAT ALLE COMMENTAAR DIE BIJ DE TICKET HOREN ZIEN IN EEN TEXTAREA
    echo '<p> Commentaar </p>';

    while($commentaar = $commentaarUitkomst->fetch_assoc()){
        echo'
            <textarea class="form" disabled="disabled"> Er is op <strong>'.$commentaar['datum'].'</strong>
            commentaar aangeleverd door <strong>'.leesAccountAchterNaam($commentaar['accountNr']).'<br></strong>
            met <strong>accountnr: '.$commentaar['accountNr'].'</strong><br><br>
            Het commentaar luidt:<br>'.$commentaar['commOmschrijving'].'
            </strong></textarea>    
            ';
    }

    echo '<p> Bijlagen </p>';
// BIJLAGE KRIJGT WAARDE 0 EN WORDT STEEDS OPGETELD TOT ALLE BIJLAGE ZIJN GETELD EN ZET DE ALLES IN VAR
    $countBijlage = 0;
    while($bijlage = $bijlageUitkomst->fetch_assoc()){

        $countBijlage += 1;
        $id = $bijlage['id'];
        $naam = $bijlage['naam'];

/*            echo'
            <textarea class="form" disabled="disabled"> '.$bijlage['naam'] .'
            <textarea class="form" disabled="disabled"> <a href="download.php?id=' . $id . '">' . $name . '</a><br>
            </textarea>    
            '; */
        echo '
            <a href="leesBijlage.php?id=' . $id .'">' . $countBijlage . ': ' . $naam . '</a><br>
            ';
    }

    echo'</div></div></div></div></div></div><hr> ';
?>
