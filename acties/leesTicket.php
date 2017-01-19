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

/*
 * TODO:
* - Nieuw commentaar
* - Nieuwe oplossing
* - Oplossing definitief kunnen zetten (mits eerste behandelaar)
*/

session_start();
ini_set('display_erors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'headerUp.php'; //Include de header.
require_once '../functies.php'; //Include de functies.
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$connectie = verbinddatabase();
$opgelost = FALSE;
$fstAccount = FALSE;
$status = "Open";

if (is_numeric($_GET['ticket'])) {
	$ticketId = $_GET['ticket'];
}

$ticketQuery = "SELECT * FROM ticket WHERE ticketId = '$ticketId'";
$ticketUitkomst = $connectie->query($ticketQuery);
$ticket = $ticketUitkomst->fetch_assoc();

$doorstuurLogQuery = "SELECT * FROM doorsturing WHERE ticketId = '$ticketId'";
$doorstuurLogUitkomst = $connectie->query($doorstuurLogQuery);

$klantId = $ticket['klantId'];
$klantQuery ="SELECT * FROM klant WHERE klantId = '$klantId'";
$klantUitkomst = $connectie->query($klantQuery);
$klant = $klantUitkomst->fetch_assoc();

$oplossingQuery = "SELECT * FROM oplossingen WHERE ticketId = $ticketId";
$oplossingUitkomst = $connectie->query($oplossingQuery);

$commentaarQuery = "SELECT * FROM commentaar WHERE ticketId = '$ticketId'";
$commentaarUitkomst = $connectie->query($commentaarQuery);

if(checkDefinitief($ticketId)){
	$opgelost = TRUE;
	$status = "Gesloten";
}

if(overDatum($ticket['streefdatum'])){
	$overDatum = TRUE;
	$status = '
                    Te laat,';
	if (!$opgelost){
		$status .= 'Open';
	} else {
		$status .= 'Gesloten';
	}
	if ($ticket['redenTeLaat'] === NULL){
		$status .= '
                        <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
                            <input type="text" name="redenTekst" value="Reden ticket te laat" maxlength="70" required>
                            <button name="reden" type="redenSubmit" value="lijnDwn">Bevestig</button>';
	}
}
 
$accountNr = $_SESSION["accountNr"];

if($_POST['lijnUp'] === "lijnUp" && $ticket['lijnNr'] <= 3 ){
	$opmerking = $_POST['opmerking'];
	$vanLijn = $ticket['lijnNr'];
	$naarLijn = $vanLijn+1;
	updateLijn($vanLijn, $naarLijn, $opmerking, $ticketId, $accountNr);
}

if($_POST['lijnDwn'] === "lijnDwn" && $ticket['lijnNr'] >1){
	$opmerking = $_POST['opmerking'];
	$vanLijn = $ticket['lijnNr'];
	$naarLijn = $vanLijn-1;
	updateLijn($vanLijn, $naarLijn, $opmerking, $ticketId, $accountNr);
}

if(isset($_POST['nogBellen'])){
	if($_POST['nogBellen'] === "0"){
		updateNogBellen("0",$ticketId);
	}
	if($_POST['nogBellen'] === "1"){
		updateNogBellen("1",$ticketId);
	}
	header("Location: ../index.php");
}

if(isset($_POST['redenTekst'])){
	$ticketId = $ticket['ticketId'];
	$redenTekst = $_POST['redenTekst'];
	$teLaatRedenQuery = "UPDATE ticket SET redenTeLaat = '$redenTekst' WHERE ticketId = '$ticketId'";
	if(!$connectie->query($teLaatRedenQuery)){
		echo "teLaatReden query mislukt..." . mysqli_error($connectie);
	}
	header("Location: ../tickets.php");
}

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

if(isset($_POST['aanwijzer'])){
	$aanwijzer = $_POST['aanwijzer'];
	$aanwijsQuery = "UPDATE ticket SET aangewAccountNr = '$aanwijzer' WHERE ticketId = '$ticketId'";
	if(!$connectie->query($aanwijsQuery)){
		echo "Error : " . mysqli_error($connectie);
	}
	header("Location: ../tickets.php");
}
 
 
echo '
        <!DOCTYPE html>
        <html>
        <head>
        <title>Ticket Informatie FTS</title>
        </head>
        <body>
        <h2> Ticketinfo </h2>

<div class="inner contact">
                <!-- Form Area -->
                <div class="contact-form">
<div class="grid">
<div class="row">
<div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">

         <p>ticketnummer: </p><input class="form" type="text" disabled="disabled" placeholder="'. $ticketId . '"/>
       
        <p>Probleem: </p><textarea class="form" disabled="disabled">'.$ticket['probleem'].'</textarea>

        <p>Trefwoorden: </p><textarea class="form" disabled="disabled">' .$ticket['trefwoorden'].'</textarea>

        <p> Status: </p><input type="text" class="form" disabled="disabled" placeholder="' .$status. '"/>

        <p> Prioriteit: </p><input type="text" class="form" disabled="disabled" placeholder="'.prioriteitOmzet($ticket['prioriteit']).'"/>

        <p> Streefdatum: </p><input type="text" class="form" disabled="disabled" placeholder="'.$ticket['streefdatum'].'"/>'
        		;
        		 

        		if($ticket['aangewAccountNr'] > 0){
        			$aangewAccountNr = $ticket['aangewAccountNr'];
        			echo'
                <p> Aangewezen operator: </p> <input class="form" type="text" disabled="disabled" placeholder="'.leesAccountAchterNaam($aangewAccountNr).'"/> </div>';
        		}else {
        			echo '</div>';}

        			if($ticket['vVLaptopTypeId'] > 0){
        				$typeId = $ticket['vVLaptopTypeId'];
        				$typeQuery = "SELECT * FROM veelVoorkomendeLaptopTypes WHERE vVLaptopTypeId = '$typeId'";
        				if(!$typeUitkomst = $connectie->query($typeQuery)){
        					echo "Type query mislukt..." . mysqli_error($connectie);
        				}
        				$type = $typeUitkomst->fetch_assoc();
        				$merkId = $type['vVLaptopMerkId'];
        				$typeOm = $type['vVLaptopTypeOm'];

        				$merkQuery = "SELECT vVLaptopMerkOm FROM veelVoorkomendelaptopMerken WHERE vVLaptopMerkId = '$merkId'";
        				if(!$merkUitkomst = $connectie->query($merkQuery)){
        					echo "Merk query mislukt..." . mysqli_error($connectie);
        				}
        				$merk = $merkUitkomst->fetch_assoc();
        				$merkOm = $merk['vVLaptopMerkOm'];
        				echo '
            <div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
            <p> Laptop: </p>
            Merk:<input type="text" class="form" disabled="disabled" placeholder="'.$merkOm.'/>
            Type:<input type="text" class="form" disabled="disabled" placeholder="'.$typeOm.'/>';
        			}else{echo'<div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">';}


        			if($ticket['lijnNr'] === $_SESSION['lijnNr'] or $_SESSION['isAdmin'] === "1"){
        				echo '
            <p> Doorsturing: </p>
            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'"method="POST">
            <p>Lijn <input type="text" class="form" disabled="disabled" placeholder="'.$ticket['lijnNr'].'"/>
            <p>reden doorsturing</p><textarea class="form" name="opmerking" value="Reden doorsturing" maxlength="70" required></textarea><br>
            ';

        				if($ticket['lijnNr'] > 1 && $ticket['lijnNr'] <= 3) {
        					echo '
                <button name="lijnDwn" type="submit" value="lijnDwn">Lijnomlaag</button> ';
            }

            if($ticket['lijnNr'] < 3) {
            	echo '
                <button name="lijnUp" type="submit" value="lijnUp">Lijnomhoog</button> ';
            }
            echo'
                </form>';
        			} else {
        				echo'
        <p> Behandelaar </p>
        <input type="text" class="form" disabled="disabled" placeholder="'.leesAccountAchterNaam($ticket['fstAccountNr']).'"/>
        <input type="text" class="form" disabled="disabled" placeholder="'.$ticket['fstAccountNr'].'"/>';

        			}
        			if($_SESSION['isAdmin'] === "1"){
        				echo '
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
        			echo '<div class="col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"><p> Klant </p>';

        			if($klant[bedrijfsId] > 0){
        				echo '<p> Bedrijfsnaam </p><input class="form" type="text" disabled="disabled" placeholder="'.leesBedrijfsNaam($klant[bedrijfsId]).'"/>';
        			}

        			echo '
        <p> Achternaam: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantAchternaam'].'"/>
        <p> Voornaam: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantNaam'].'"/>
        <p> Telefoon: </p> <input type="text" class="form" disabled="disabled" placeholder="'.$klant['klantTel'].'"/>';

        			echo '<form action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';

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
        <p> Logboek:
        Ticket is op <strong>'.$ticket['datumAanmaak'].'</strong> aangemaakt door <strong>'.leesAccountAchterNaam($ticket['fstAccountNr']).'</strong><p><br>';

        			if($overDatum){
            echo'
                Sinds <strong>'.$ticket['streefdatum'].'</strong> is deze ticket te laat,<br>';
            if($ticket['redenTeLaat'] === NULL){
            	echo '
                    <textarea class="form" disabled="disabled"> reden nog niet ingevuld</textarea>';
            } else {
            	echo '<textarea class="form" disabled="disabled">reden:'.$ticket['redenTeLaat'].'</textarea>';
            }
        			}

        			while($doorstuurLog = $doorstuurLogUitkomst->fetch_assoc()){
            echo '<p> Doorsturingen </p>'
            		. '<textarea class="form" disabled="disabled">Ticket is op <strong>'.$doorstuurLog['datum'].'</strong> doorgestuurd
                    van Lijn <strong>'.$doorstuurLog['vanLijn'].'</strong>
                    naar Lijn <strong>'.$doorstuurLog['naarLijn'].'</strong>
                    door <strong>'.leesAccountAchterNaam($doorstuurLog['accountNr']).'</strong><br>
                    met <strong>accountnr: '.$doorstuurLog['accountNr'].'</strong> reden:'.$doorstuurLog["opmerking"].'</textarea>';

        			}

        			echo '<p> Oplossingen </p>';

        			while($oplossingen = $oplossingUitkomst->fetch_array()){
            echo '
                <textarea class="form" disabled="disabled"> Er is op <strong>'.$oplossingen['datumFix'].'</strong>
                een oplossing aangedragen
                door <strong>'.leesAccountAchterNaam($oplossingen['accountNr']).'</strong>
                <br>met <strong>accountnr: '.$oplossingen['accountNr'].'
                </strong><br><br>
                De oplossing luidt:<br>
                '.$oplossingen['oplossOmschrijving'].'
                </textarea>';

            if($oplossingen['definitief'] === "1"){
            	$definitief = TRUE;
            	echo 'Deze oplossing is <strong>definitief</strong>,
                     de ticket is afgesloten<br><br>';
            } else {
            	echo 'Deze oplossing is <strong>niet</strong> definitief.<br><br>';
            	if($_SESSION['accountNr'] === $ticket['fstAccountNr']){
            		echo '
                            <p>
                            <form action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                                <button type="submit" value="def">Definitief</button></p>
                        ';
            	}
            }

        			}

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

        			echo '<form name="leesTicket" action="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">';

        			if(!$definitief && $ticket['lijnNr'] === $_SESSION['lijnNr']){
            echo '<p> Nieuwe oplossing </p>
                <form action ="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                    <input class="form" type ="text" name="oplossing"><br>';
            if($_SESSION["accountNr"] === $ticket['fstAccountNr']){
            	echo '<input type ="checkbox" name="definitief" value="1">Definitief';
            }
            echo'
                    <button name="submitOplossing" type="submit" value="1">Verstuur</button>
                </form><br>
                <p> Nieuw commentaar </p>
                <form action ="leesTicket.php?ticket='. $ticket['ticketId'] .'" method="POST">
                    <input class="form" type ="text" name="commentaar"><br><br>
                    <button name="submitCommentaar" type="submit" value="1">Verstuur</button>
                ';
        			}
        			echo'</div></div></div></div> ';
        			?>
