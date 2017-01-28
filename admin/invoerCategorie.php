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
    require_once '../header.php'; //Include de header.
    $connectie = verbinddatabase();
    
    if($_SESSION['isAdmin'] < 1){
        echo '<script> window.alert("U bent geen Administrator!");</script>';
        header("refresh:0;url= ../index.php");
    }    
    if(isset($_POST['submitCategorie'])){
        $query = $connectie->prepare("INSERT INTO categorie (categorieId, catOmschrijving) VALUES ('',?) ");
        $query->bind_param("s", $catOm);
        
        $catOm = $_POST['catOm'];
        
        $query->execute();
        $query->close();
    }
    
    if(isset($_POST['submitSubCategorie'])){
        $query = $connectie->prepare("INSERT INTO subCategorie (subCategorieId, subCatomschrijving, categorieId) VALUES ('',?,?) ");
        $query->bind_param("si", $subCatOm, $catId);
        
        $subCatOm = $_POST['subCatOm'];
        $catId = $_POST['categorie'];
                
        $query->execute();
        $query->close();
    }
    
?>

 
<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body>
         <div class="containert1">
        <form name="cat" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <h2><strong>Categorie invoer</strong></h2>
            
            Categorie <br>
            <input type="text" name="catOm"><br><br>

          <input type="submit" name="submitCategorie" value="invoeren"><br>    
        </form>
        
        <form name="subCat" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <h2><strong>Sub categorie invoer</strong></h2>
            
            Subcategorie <br>
            <input type="text" name="subCatOm"><br><br>
            
            <strong> Valt onder categorie </strong><br><select name="categorie">
            <?php
            $ophaalcat = "SELECT * FROM categorie ";
                            $resultcat = mysqli_query($connectie, $ophaalcat);
                            while ($c = mysqli_fetch_assoc($resultcat)) {
                            echo "<option value='" . $c['categorieId'] . "'>" . $c['categorieId'] . " " . $c['catOmschrijving'] . "</option>";
                            } ?>
            </select><br>
          <br><input type="submit" name="submitSubCategorie" value="invoeren"><br>    
        </form></div>
    </body>  
</html>   