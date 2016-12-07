<html>

<header>
<img src="fts.PNG">
<style>
img {
    display: block;
    margin: auto;
}
</style>
</header>
    
    <body>
        
        <div class="form1">
            <form action="#" method="POST">
                    <input type="text" name="klascode" onblur="checkcode()" required placeholder="Vul hier uw klascode in*"><span id="message1" ></span><br>
                    <input type="text" name="wachtwoord" onblur="checkww()" required placeholder="Vul hier uw wachtwoord in*"><span id="message2" ></span><br>
                <input type="submit" value="Submit" onclick="validateForm()">
            </form>
        </div>
        
<script>
    
    var count = 0;
    
    function checkcode() {// controleren of veld 1 leeg is
    var m1 = document.getElementById('message1');
    var kc = document.getElementById('klascode'); 

   
    if (kc.value == ''){
    m1.innerHTML = "veld mag niet leeg zijn";
    kc.focus;
    return false;
    }
        else{
            message1.innerHTML = "veld voldoet aan de eisen";
            count = count+1;
        }
}


function checkww() {// controleren of veld 2 leeg is

    var m2 = document.getElementById('message2');
    var ww = document.getElementById('wachtwoord');

   if (ww.value == '') {
    message2.innerHTML = "veld mag niet leeg zijn";
    ww.focus;
    return false;
    }
        else {
        m2.innerHTML = "veld voldoet aan de eisen";
        count = count+1;
        }
}


function validateForm() {

                if (count < 2 ){
                alert("Velden mogen niet LEEG zijn of moet correct ingevuld worden");
                return false;
                }
                    else {
                    window.location.href= 'index.php';
                    }
}
    
    </script>
            
    
    
    </body>


</html>