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
?>

 
<html>
    <header>
        <title>Admin Invoer FTS</title>
    </header>
    <body>
         <div class="containert1">
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
            
            <strong> Hoort bij merk </strong><br>
            <select name="merk">
                    <option>Dell</option>
                    <option>HP</option>
                    </select>
            

          <br><input type="submit" name="submitType" value="invoeren"><br>    
        </form></div>
    </body>  
</html>   