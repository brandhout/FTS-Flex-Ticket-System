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
    require_once '../functies.php'; //Include de functies.
    require_once '../header.php'; //Include de header
    ini_set('display_erors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $connectie = verbinddatabase();
   
    if(isset($_POST['submitMerk'])){
        $merk = $_POST['laptopMerk'];
                     
        $insertLaptopMerkQuery = $connectie->prepare("INSERT INTO veelVoorkomendelaptopMerken (vVLaptopMerkId, vVLaptopMerkOm) VALUES ('', ?)");
        $insertLaptopMerkQuery->bind_param("s", $merk);

        $insertLaptopMerkQuery->execute();
        $insertLaptopMerkQuery->close();
  
    }
    if(isset($_POST['submitType'])){
        $type = $_POST['laptopType'];
        $typeMerk =$_POST['merk']; ;
        
        echo $type;
        echo $typeMerk;
        
        $insertLaptopTypeQuery = $connectie->prepare("INSERT INTO veelVoorkomendeLaptopTypes (vVLaptopTypeId, vVLaptopTypeOm, vVLaptopMerkId) VALUES ('', ?, '$typeMerk')");
        echo 'param';
        $insertLaptopTypeQuery->bind_param("s", $type);
        echo 'bind_param';

        $insertLaptopTypeQuery->execute();
        $insertLaptopTypeQuery->close();
        
    }               
require_once '../header.php'; //Include de header 
?>

 
<html>
    <body>
        <header>
            <title>Admin Invoer FTS</title>
        </header><hr>
        
        <div class="container">
            <div class="inner contact">  
    		<div class="grid">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                            <form name="merk" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="submit" class="form-btn semibold" name="submitMerk" value="invoeren merk"><br>
                                <p><strong>Laptop merk invoer</strong></p>
                                laptop merk <br>
                                <input type="text" class="form" name="laptopMerk"><br><br>
                            </form>
                        </div>
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                            <form name="type" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="submit" class="form-btn semibold" name="submitType" value="invoeren type"><br>  
                            <p><strong>Laptop type invoer</strong></p>
                            Typenummer <br>
                            <input type="text" class="form" name="laptopType"><br><br>
                            Hoort bij merk<br>
                            <select class="form" name="merk">
                                <option value ="">---Select---</option>
                                <?php
                                    $ophaalMerk = "SELECT * FROM veelVoorkomendelaptopMerken "; //selecteerd alle klassen 
                                        echo 'werk';
                                    $resultsMerk = mysqli_query($connectie, $ophaalMerk);
                                        while ($m = mysqli_fetch_assoc($resultsMerk)) {
                                            echo "<option value='" . $m['vVLaptopMerkId'] . "'>" . $m['vVLaptopMerkId'] . " " . $m['vVLaptopMerkOm'] . "</option>";
                                        }
                                ?>    
                            </select><br>  
                            </form>
                        </div>
                    <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>   
        </div></div></div></div>
        <hr>
    </body>  
</html>   