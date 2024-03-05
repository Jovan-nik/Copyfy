<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restartovanje lozinke</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    $novaSifraGreska=$repeat_novaSifraGreska="";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $new_password = isset($_POST["new_password"]) ? $_POST["new_password"] : "";
        $repeat_new_password = isset($_POST["repeat_new_password"]) ? $_POST["repeat_new_password"] : "";

        if(empty($new_password)){
            $novaSifraGreska="Morate uneti novu lozinku";
        }else {
            // Provera dužine, velikog slova i broja
            if (strlen($new_password) < 8 || !preg_match("/[A-Z]/", $new_password) || !preg_match("/[0-9]/", $new_password)) {
                $novaSifraGreska = "Nova lozinka mora sadržati bar 8 karaktera, bar jedno veliko slovo i bar jedan broj!";
            } else {
                $novaSifraGreska="";
            }
        }
        if (empty($repeat_new_password)) {
            $repeat_novaSifraGreska = "Morate ponoviti lozinku!";
        } else {
            // Provera dužine, velikog slova i broja
            if ($repeat_new_password != $new_password) {
                $repeat_novaSifraGreska = "Ponovljena nova lozinka i nova lozinka nisu iste!";
            } else {
                $repeat_novaSifraGreska = "";
            }
        }

    }
    ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
<div class="resetDrzi">
<div class="reset">
    <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password"  name="new_password" >
                <p class="greska"><?php echo isset($novaSifraGreska) ? $novaSifraGreska : ""; ?></p><br>
                <label>Sifra</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password"   name="repeat_new_password">
                <p class="greska"><?php echo isset($repeat_novaSifraGreska) ? $repeat_novaSifraGreska : ""; ?></p><br>
                <label>Ponovljena sifra</label>
            </div>
            <button type="submit">
            Restartuj lozinku
            <?php  #echo $registration_message !== "" ? $registration_message : "Registruj se"; ?>
            </button>
        </form>
</div>
</div>
</body>
</html>