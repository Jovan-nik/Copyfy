<?php 
    session_start();
    $session_active = isset($_SESSION["logged_in_korisnik"]);
    $include_js = !$session_active;
    $logoutId="";
    $loggedInKorisnik_id="";
    if($session_active){$logoutId="dugmeLogout";
        $loggedInKorisnik_id=$_SESSION["logged_in_korisnik"]["id"];
    }

            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reddify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php 
        
            //include "novaLozinka.php";
            include "./handlers/registracija.php";
            include "./handlers/login.php";
            $registration_message = "";
            $login_message="";
            $wrapper_class="";
           
            #GRESKE
            $login_emailgreska=$login_passwordgreska="";
            $usernamegreska=$emailgreska=$passwordgreska=$repeat_passwordgreska=$uslovi_greska="";
            

            if($_SERVER["REQUEST_METHOD"] == "POST"){

                #UZIMA STANJE DUGMETA

                $login_dugme = isset($_POST["login_submit"]);
                $register_dugme = isset($_POST["registration_submit"]);

                #LOGIN
                if($login_dugme){
                    $pamti_podatke=isset($_POST["zapamti_podatke"])?isset($_POST["zapamti_podatke"]):"";
                    $login_email = isset($_POST["login_email"]) ? $_POST["login_email"] : "";
                    $login_password = isset($_POST["login_password"]) ? $_POST["login_password"] : "";
                    
                    //PAMCENJE PODATAKA
                    if(isset($pamti_podatke)){
                        echo "<script>";
                        echo "localStorage.setItem('login_email', '$login_email');";
                        echo "localStorage.setItem('login_password', '$login_password');";
                        echo "</script>";
                    }
                    if(empty($login_password)){
                        $login_passwordgreska="Morate uneti sifru!";
                        $wrapper_class="active-iskoci";
                    }

                    if(empty($login_email)){
                        $login_emailgreska="Morate uneti email!";
                        $wrapper_class="active-iskoci";
                    }
                    else{
                        if(!filter_var($login_email, FILTER_VALIDATE_EMAIL)){
                            $login_emailgreska = "Email nije validan!";
                            $wrapper_class="active-iskoci";
                        }
                        else{
                            $login_emailgreska = "";
                        }
                        if(empty($login_emailgreska)&&empty($login_passwordgreska)){
                            $login_message=login($login_email,$login_password);    
                            if(empty($login_message))
                            {
                                $wrapper_class="";
                            }
                            else{
                                $wrapper_class="active-iskoci";
                            }
                        }
                       
                    }
                    
                }
                #REGISTRACIJA
                if($register_dugme){
              
                    $email = isset($_POST["email"]) ? $_POST["email"] : "";
                    $korisnicko_ime = isset($_POST["korisnicko_ime"]) ? $_POST["korisnicko_ime"] : "";
                    $password = isset($_POST["password"]) ? $_POST["password"] : "";
                    $repeat_password = isset($_POST["repeat_password"]) ? $_POST["repeat_password"] : "";
                    $uslovi = isset($_POST["uslovi"]) ? $_POST["uslovi"] : "";
    
    
                    if (empty($email)) {
                        $emailgreska = "Morate uneti email!";
                        $wrapper_class="active active-iskoci";
                    } else {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailgreska = "Email nije validan!";
                            $wrapper_class="active active-iskoci";
                        } else {
                            $emailgreska = "";
                        }
                    }
        
                    if(empty($korisnicko_ime)){
                        $usernamegreska = "Morate uneti korisnicko ime!";
                        $wrapper_class="active active-iskoci";
                    }
                    else{
                        $usernamegreska = "";

                    }
        
                    if (empty($password)) {
                        $passwordgreska = "Morate uneti lozinku!";
                        $wrapper_class="active active-iskoci";
                    } else {
                        // Provera dužine, velikog slova i broja
                        if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
                            $passwordgreska = "Lozinka mora sadržati bar 8 karaktera, bar jedno veliko slovo i bar jedan broj!";
                            $wrapper_class="active active-iskoci";
                        } else {
                            $passwordgreska = "";
                        }
                    }
        
                    if (empty($repeat_password)) {
                        $repeat_passwordgreska = "Morate ponoviti lozinku!";
                        $wrapper_class="active active-iskoci";
                    } else {
                        // Provera dužine, velikog slova i broja
                        if ($repeat_password != $password) {
                            $repeat_passwordgreska = "Ponovljena lozinka i lozinka nisu iste!";
                            $wrapper_class="active active-iskoci";
                        } else {
                            $repeat_passwordgreska = "";
                        }
                    }
                    if (!isset($uslovi)) {
                        $uslovi_greska = "Morate prihvatiti uslove korišćenja.";
                        $wrapper_class="active active-iskoci";
                    }
                    if(empty($emailgreska) && empty($usernamegreska) && empty($passwordgreska) && empty($repeat_passwordgreska) && empty($uslovi_greska)){
                        $registration_message = registracija($korisnicko_ime,$email,$password);
                        if(empty($registration_message))
                            {
                                $wrapper_class="";
                            }
                            else{
                                $wrapper_class="active active-iskoci";
                            }   

                    }
                    
                }                
            }
?>
<header>
    <h2 id="logo" class="logo">Reddify</h2>
    <nav class="navigacija">
    <?php if ($session_active) { ?>
            <a href="pages/nova_objava.php">Nova objava</a>
            <a href="#" id="toggleSearch">Pretraga</a>
            <a href="#" data-ulogovani-korisnik-id="<?php echo $loggedInKorisnik_id?>" id="tvoje_objave">Tvoje objave</a>

            <button id="<?php echo $logoutId; ?>" class="dugmeLogin"><?php echo isset($_SESSION["logged_in_korisnik"]["username"]) ? $_SESSION["logged_in_korisnik"]["username"] : "Uloguj se"; ?></button>
            <?php } else { ?>
                <button id="<?php echo $logoutId; ?>" class="dugmeLogin"><?php echo isset($_SESSION["logged_in_korisnik"]["username"]) ? $_SESSION["logged_in_korisnik"]["username"] : "Uloguj se"; ?></button>
            <?php } ?>
    </nav>
</header>
<!--FORMA-->


<div class="drzi col-12">

<div class="wrapper <?php echo $wrapper_class;?>">
    <span class="iks"><ion-icon name="close"></ion-icon></span>
    <div class="form-box login">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="email"  name="login_email" >
                <p id="login_emailgreska"class="greska"><?php echo isset($login_emailgreska) ? $login_emailgreska : ""; ?></p><br>
                <label>Email</label>
                
            </div>
              <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password"  name="login_password" >
                <p class="greska"><?php echo isset($login_passwordgreska) ? $login_passwordgreska : ""; ?></p><br>

                <label>Sifra</label>
            </div>
            <div class="seti-se">
                <label><input type="checkbox" id="zapamti_podatke" name="zapamti_podatke">Zapamti podatke</label>
                <a  id="zaboraviliSteLozinku" href="#">Zaboravili ste lozinku?</a>

            </div>
            <button type="submit" class="dugme" name="login_submit">
            <?php echo $login_message !== "" ? $login_message : "Uloguj se"; ?>
            </button>

            <div class="login-register">
                <p>Nemate nalog?<a href="#" class="register-link"> Kreirajte nalog </a></p>
            </div>
        </form>
    </div>

    <div class="form-box register">
        <h2>Registruj se</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
       
            <div class="input-box">
                <span class="icon"><ion-icon name="person"></ion-icon></span>
                <input type="text"  name="korisnicko_ime" >
                <p class="greska"><?php echo isset($usernamegreska) ? $usernamegreska : ""; ?></p><br>
                <label>Korisnicko ime</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="email"  name="email" >
                <p class="greska"><?php echo isset($emailgreska) ? $emailgreska : ""; ?></p><br>
                <label>Email</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password"  name="password" >
                <p class="greska"><?php echo isset($passwordgreska) ? $passwordgreska : ""; ?></p><br>
                <label>Sifra</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password"   name="repeat_password">
                <p class="greska"><?php echo isset($repeat_passwordgreska) ? $repeat_passwordgreska : ""; ?></p><br>
                <label>Ponovljena sifra</label>
            </div>
            <div class="seti-se">
                <label for="uslovi"><input type="checkbox" id="uslovi" name="uslovi">Pristajem na uslove koriscenja</label>
                <p class="greska"><?php echo isset($uslovi_greska) ? $uslovi_greska : ""; ?></p><br>
                
            </div>
            <button type="submit" id="registracija" class="dugme" name="registration_submit">
            <?php echo $registration_message !== "" ? $registration_message : "Registruj se"; ?>
            </button>

            <div class="login-register">
                <p>Vec imate nalog?<a href="#" class="login-link"> Ulogujte se</a></p>
            </div>
            
        </form>
    </div>
</div>

<!-- KRAJ FORME -->
<div class="meni col-3" >
        <ul>
        
            <h3 id="home"> <ion-icon name="home-outline"></ion-icon>Home </h3>
        
        
            <h3><ion-icon name="arrow-up-outline"></ion-icon>Popularno</h3>
        
        <br>
        <?php
        $conn = connect();
        $sql = "SELECT naziv, ion_icon,ID_teme FROM tema";
        $result = $conn->query($sql);
        $counter = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($counter < 4) {
                    echo "<p id='" . $row['ID_teme'] . "'><ion-icon name=\"" . $row['ion_icon'] . "\"></ion-icon> " . $row['naziv'] . "</p>";
                } else {
                    break;
                }
                $counter++;
            }
        }
        ?>
       
            <h3 id="vise">Ostalo</h3>
        
       
        <div id="dodatno">
            <?php
            $conn = connect();
            $sql = "SELECT naziv, ion_icon,ID_teme FROM tema";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $counter = 0;
                while ($row = $result->fetch_assoc()) {
                    if ($counter >= 4) {
                        echo "<p id='" . $row['ID_teme'] . "'><ion-icon name=\"" . $row['ion_icon'] . "\"></ion-icon> " . $row['naziv'] . "</p>";
                    }
                    $counter++;
                }
            }
            
            if ($session_active) {
                echo "<h3><ion-icon name='add-outline'></ion-icon><a href='./pages/nova_tema.php'>Nova tema</a></h3>";
            }
            
            ?> 
            
        </div>
    </ul>
</div>
<div class="content col-9">
        <div class="popularneObjave">
            <?php
            $conn = connect();
            $sql = "SELECT objava.*, COUNT(up_vote.ID_objave) AS broj_glasova 
                    FROM objava 
                    LEFT JOIN up_vote ON objava.ID_objave = up_vote.ID_objave 
                    GROUP BY objava.ID_objave 
                    ORDER BY broj_glasova DESC 
                    LIMIT 4";

            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $style = "style='background-image: linear-gradient(90deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.6) 100%), url(\"" . $row['slika'] . "\"); background-position: center; background-size: cover'";
                    
                    echo "<div class='objava' $style>";
                    echo "<h3>" . $row['naslov'] . "</h3>";
                    echo "<p>" . $row['tekst'] . "</p>"; 

                    echo "</div>";
                }
            } else {
                echo "Nema objava za prikaz.";
            }
            ?>
        </div>
        <div class="postovi">
            <div class="col-8 objave">
            <?php
            $upvote_ids = array();

            if ($session_active) {
                $upvote_query = "SELECT * FROM up_vote WHERE ID_korisnika = $loggedInKorisnik_id";
                $upvote_result = $conn->query($upvote_query);

                if ($upvote_result) {
                    if ($upvote_result->num_rows > 0) {
                        while ($upvote_row = $upvote_result->fetch_assoc()) {
                            $upvote_ids[] = $upvote_row['ID_objave'];
                        }
                    }
                } else {
                    echo "Greška prilikom izvršavanja upita za upvote-ove: " . $conn->error;
                }
            }
            $conn = connect();
            $sql = "SELECT objava.*, korisnik.user_name 
                    FROM objava 
                    JOIN korisnik ON objava.ID_korisnika = korisnik.ID_korisnika";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='objava' style='    border-bottom: 0.5px solid white; cursor:pointer;' id-tema='" . $row['ID_teme'] . "' id-korisnika='" . $row['ID_korisnika'] . "'>";
                    echo "<h2 style='font-size:28px;text-align:center;'>" . $row['naslov'] . "</h2>"; 
                    echo "<img src='" . $row['slika'] . "' alt='Slika objave'>";
                    echo "<p style='font-size:24px;'>Opis : " . $row['tekst'] . "</p>";
                    echo "<p style='font-size:20px; text-align:end;'>Objavio/la: " . $row['user_name'] . "</p>";
                    if($session_active) {
                        if (in_array($row['ID_objave'], $upvote_ids)) {
                            echo "<ion-icon class='upvote'  id-objave=" . $row['ID_objave'] ."  name='chevron-up-circle'></ion-icon>";
                        } else {
                            echo "<ion-icon class='upvote'  id-objave=" . $row['ID_objave'] ." name='chevron-up-circle-outline'></ion-icon>";
                        }
                    }
                    echo "</div>";
                }
            } else {
                echo "Nema objava za prikaz.";
            }
            ?>
            </div>
            <div class="reklame d-none d-xxl-block col-3" style="display:flex; align-items:start; flex-direction:column;">

                <div id="zajednica" class="zajednice"></div>
                <div id="reklama" class="zajednice"> </div>
            <div>
        </div>
</div>


<script src="js/dodatno.js"></script>
<script src="js/logoutDugme.js"></script>
<script src="js/novaLozinka.js"></script>

<?php if ($include_js) { ?>
<script src="js/main.js"></script>
<?php } ?>
<?php if (!$include_js) { ?>
        <script src="js/upvote.js"></script>
    <?php } ?>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>