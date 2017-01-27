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
        echo 'param';
        $insertLaptopMerkQuery->bind_param("s", $merk);
        echo 'bind_param';

        $insertLaptopMerkQuery->execute();
        $insertLaptopMerkQuery->close();
        header("Refresh:0; url=adminDash.php", true, 303);
  
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
        //header("Refresh:0; url=adminDash.php", true, 303);
        
    }
         
        
    
?>

 
<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body>
         
        <form name="merk" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <h2><strong>Laptop merk invoer</strong></h2>
            
            laptop merk <br>
            <input type="text" name="laptopMerk"><br><br>

          <input type="submit" name="submitMerk" value="invoeren"><br>    
        </form>
        
        <form name="type" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <h2><strong>Laptop type invoer</strong></h2>
            
            Typenummer <br>
            <input type="text" name="laptopType"><br><br>
            
            
               Hoort bij merk<br>
                <select name="merk">
                <option value ="">---Select---</option>
                <?php
                   $ophaalMerk = "SELECT * FROM veelVoorkomendelaptopMerken "; //selecteerd alle klassen 
                    echo 'werk';
                    $resultsMerk = mysqli_query($connectie, $ophaalMerk);
                    while ($m = mysqli_fetch_assoc($resultsMerk)) {
                        echo "<option value='" . $m['vVLaptopMerkId'] . "'>" . $m['vVLaptopMerkId'] . " " . $m['vVLaptopMerkOm'] . "</option>";
                    }
                ?> 
                    
                </select><br><br>
            

          <br><input type="submit" name="submitType" value="invoeren"><br>    
          </form>
    </body>  
</html>   