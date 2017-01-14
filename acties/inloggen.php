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
     * - Opmaak fixen
     * - (EVENTUEEL) versleuteling
     */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../functies.php'; //Include de functies.
    
    $connectie = verbinddatabase();
     

    if(isset($_POST['gebruikersNaam']) && isset($_POST['wachtwoord'])){
        //verkrijg de variabele uit het forum hieronder, de functies voorkommen SQL injectie
        $gebruikersNaam = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['gebruikersNaam'])));
        $wachtwoord = mysqli_real_escape_string($connectie, stripcslashes(trim($_POST['wachtwoord'])));
   
        $query = mysqli_query($connectie, "SELECT gebruikersNaam, wachtwoord, isAdmin, magInloggen, accountNr, lijnNr FROM account WHERE gebruikersNaam = '$gebruikersNaam'");
        $uitkomst = mysqli_fetch_array($query);
        $teller = mysqli_num_rows($query);

        if ($teller == 1 && $uitkomst['wachtwoord'] == $wachtwoord && $uitkomst['magInloggen'] == 1){ //Als gegevens in de database gelijk zijn aan ingevulde gegevens

            // Inloggen succes, hier moet een sessie aangemaakt worden
            session_start();
            $_SESSION["gebruikersNaam"] = $uitkomst['gebruikersNaam'];
            $_SESSION["accountNr"] = $uitkomst['accountNr'];
            $_SESSION["isAdmin"] = $uitkomst['isAdmin'];
            $_SESSION["lijnNr"] = $uitkomst['lijnNr'];
            header('Location: ../index.php'); 
            
        } else {
            echo "foute gegevens!";
            return FALSE;
        }}
?>
<html>    
    <head>
        <meta charset="UTF-8">
        <link rel='stylesheet' href='//fonts.googleapis.com/css?family=font1|font2|etc' type='text/css'>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        
            <!--bootstrap--> 
  <link rel="stylesheet" type="text/css" href="../styles/css/bootstrap.css">
  <script src="../styles/js/bootstrap.min.js"></script>
  
  <style>
      body{
          margin: 0 auto;
          background-image: url("../styles/inlogroc.jpg");
          background-repeat: no-repeat;
          background-size: 100%;
          
      }
      
      .container{
          width:400px;
          height:200px;
          text-align: center;
          background-color: rgba(255,250,250,0.7);
          border-radius:4px;
          margin:0px auto;
          margin-top:150px;
      }
      
      .container img{
          width:102px;
          height:120px;
          margin-top:-90px;
          display: inline-block;
      }
      
      inlog[type="text"],inlog[type="password"]{
          width:300px;
          height:45px;
          font-size:18px;
          margin-bottom:30px;
          background-color: #fff;
          padding-left:30px;
          
      }
      .btn-login{
          margin-top:5px;
          padding:10px 20px;
          color: #fff;
          border:none;
          border-radius: 4px;
          background-color:#2ECC71;
          
      }
      
     img.logo2 {
  display: inline-block;


        }
     img.roc1 {
          display: inline-block;
          width:250px;
          height:125px;
            width: 250px;
  height: 125px;
  position: absolute;
  top: 0;
  left: 0;
        }
 
        header{
  background-color: rgba(255, 0, 0, 0.6);
  position: relative;
  text-align: center;
  height: 128px;

        }
        footer{
            background-color: rgba(255,0,0,0.6);
            text-align:right;
              position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1rem;
  color:#fff;
      
        }
  </style>
    </head>
    <header>
        <img src="../styles/roc.png" class="roc1"><img src="../fts.PNG" class="logo2">
    </header>
    
    <body>
        <br><br><br>    
        
        <div class="container">
            <img src="../styles/login.png"><br><br>
           <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
               <div class="inlog"><i class="fa fa-user" aria-hidden="true">
                    <input type="text" name="gebruikersNaam" autocomplete="off" required placeholder="Vul hier uw gebruikersnaam in*"><span id="message1" ></span><br>
                    </i></div>
               <div class="inlog"><i class="fa fa-lock" aria-hidden="true">
                    <input type="password" name="wachtwoord" required placeholder="Vul hier uw wachtwoord in*"><span id="message2" ></span><br>
                    </i></div>
                <input type="submit" value="inloggen"name="submit"class="btn-login">                  
            </form>
            
        </div>
        
    </body>
    <footer>
        <p>this website was made with: html/php/css/bootstrap/ajax/mysqli/javascript made by: Naomi M, Rick H, Robby M. </p>
    </footer>
</html>

