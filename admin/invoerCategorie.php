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
        die();
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
    <body>
        <header>
            <title>Admin Invoer FTS</title>
        </header>
        <hr>
            
        <div class="container">
            <div class="inner contact">  
    		<div class="grid">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                        <form name="cat" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="submit" class="form-btn semibold" name="submitCategorie" value="invoeren categorie"><br>  
                            <p><strong>Categorie invoer</strong></p>
                            Categorie <br>
                            <input type="text" class="form" name="catOm"><br>
  
                        </form></div>
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s">
                        <form name="subCat" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="submit" class="form-btn semibold" name="submitSubCategorie" value="invoeren s-categorie"><br>  
                            <p><strong>Sub categorie invoer</strong></p>
                            Subcategorie <br>
                            <input type="text" class="form" name="subCatOm"><br><br>
                            <strong> Valt onder categorie </strong><br>
                            <select class="form" name="categorie">
                                <?php
                                    $ophaalcat = "SELECT * FROM categorie ";
                                    $resultcat = mysqli_query($connectie, $ophaalcat);
                                    while ($c = mysqli_fetch_assoc($resultcat)) {
                                        echo "<option value='" . $c['categorieId'] . "'>" . $c['categorieId'] . " " . $c['catOmschrijving'] . "</option>";
                                    }
                                ?>
                            </select><br>
  
                        </form>
                        </div>
                        <div class="col-xs-6 col-sm-3 wow animated slideInLeft" data-wow-delay=".5s"></div>
                    </div></div></div></div><hr>
    </body>  
</html>   