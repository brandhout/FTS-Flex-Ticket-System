


<!DOCTYPE html>
<html>

    <body>
        <h1> Nieuw ticket </h1>
        
        <!--  alle scripts  -->
            <script>
                function zoekf(){
                    var zoektxt = $("input[name='zoek']").val();
                    $.post("AJAX/zoekKlant.php", {zoekval: zoektxt}, function(output){
                        $("#output").text(output);
                    });
                    
                }
            </script>

<form name="nieuwTicket2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <button type="button" onclick="bestaandek()" id="bk">bestaandeklant</button><br>
                <input name='zoek' type="text" placeholder="zoeken in Achternaam"  onkeydown="zoekf();" class='hidden2'/><br>
                <label class="hidden02">klant ID:</label><textfield  type="text" id="output" name="fstAccountNr" class="hidden2"/></textfield><br>
                    <label class="hidden02">klant moet gebeld worden:</label><input type="checkbox" name="nogBellen" value="nogBellen" class="hidden2"/><br>
                
                     <label class="hidden02">binnengekomen via:</label>
                        <select name="binnenkomstType" class="hidden2"> <!-- Moet nog gescript worden! Data moet uit database komen -->
                            <option>Telefoon</option>
                            <option>E-mail</option>
                        </select><br>
                    <label class="hidden02">locatie:</label>
                        <select name="locatie" class="hidden2"> <!-- Disabled, gaan we nog niets mee doen-->
                            <option>Hilversum Soestdijkerstraatweg</option>
                            <option>uy</option>
                        </select><br>
                    <label class="hidden02">trefwoorden (aan elkaar, door komma gescheiden)</label><input id="text1" type="text" name="trefwoorden" class="hidden2"/></p>
			
                    <label class="hidden02">categorie:</label>
                        <select name="categorie" class="hidden2">
                            <option>Software</option>
                            <option>Hardware</option>
                        </select><br>
                    <label class="hidden02">sub-categorie:</label>
                        <select name="subCategorie" class="hidden2">
                            <option>Fedora Linux</option>
                            <option></option>
                        </select><br>
                    <label class="hidden02">merk:</label>
                        <select name="vVLaptopMerk" class="hidden2">
                            <option>1</option>
                            <option>2</option>
                        </select><br>
                    <label class="hidden02">type:</label>
                        <select name="vVLaptopType" class="hidden2">
                            <option>2</option>
                            <option>1</option>
                        </select><br>
                    <label class="hidden02">besturingsysteem:</label>
                        <select name="besturingssysteem" class="hidden2">
                            <?php
                                while($OSrij = $OSLijst->fetch_assoc()) {
                                    echo '<option>' . $OSrij[besturingssysteemOm] . '</option>';
                                }
                            ?>
                            <option></option>
                        </select><br>

                        <label class="hidden02">probleem(korte omschrijving:)</label><br>
                        <textarea id="probleem" class="hidden2"></textarea><br>
                        <label class="hidden02">commentaar:</label><br>
                        <textarea id="nieuwComment" class="hidden2"></textarea><br>
                        <label class="hidden02">potentieele oplossing:</label><br>
                        <textarea id="oplossing" class="hidden2"></textarea><br>
                    <!--datepicker-->
                    <label class="hidden02">streefdatum:</label>
                        <input type="date" id="datepicker" class="hidden2"/></p>  
                    
                    
                    
                    <input type="submit"value=">>" name="submit2" class='hidden2' />
                    
                </form>
    </body>
</html>
