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
    include "konekcija.php";
    $novaSifraGreska=$repeat_novaSifraGreska="";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn=connect();
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
        if(empty($novaSifraGreska)&&empty($repeat_novaSifraGreska)){
            $nova_hash_sifra = password_hash($new_password, PASSWORD_DEFAULT);
            $vreme=date("Y-m-d H:i:s");
            $kod="";
            $vreme_kreiranja;
    
            $sql = "SELECT kod,vreme_kreiranja FROM nove_lozinke WHERE kod = '" . $_POST["kod"] . "'";

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $kod = $row["kod"];
                    $vreme_kreiranja = $row["vreme_kreiranja"];
                }
                $razlika_u_sekundama = strtotime($vreme) - strtotime($vreme_kreiranja);
                if ($razlika_u_sekundama <= 120) {
                    // Dohvatanje ID korisnika povezanog sa datim kodom
                    $korisnik_id = "";
                    $id_query = "SELECT id_korisnika FROM nove_lozinke WHERE kod = '" . $_POST["kod"] . "'";
                    $id_result = $conn->query($id_query);
                    if ($id_result->num_rows > 0) {
                        while ($id_row = $id_result->fetch_assoc()) {
                            $korisnik_id = $id_row["id_korisnika"];
                        }
                    } else {
                        echo "Nema rezultata.";
                    }
                    $nova_hash_sifra = password_hash($new_password, PASSWORD_DEFAULT); 
                
                    $update_query = "UPDATE korisnik SET password = '$nova_hash_sifra' WHERE id_korisnika = '$korisnik_id'";
                    if ($conn->query($update_query) === TRUE) {
                        echo "<script>alert('Šifra uspešno promenjena.');</script>";
                    } else {
                        echo "<script>alert('Greška prilikom ažuriranja šifre: . $conn->error');</script>";
                    }
                } else {
                    echo "<script>alert('Istekao kod. Razlika u sekundama: " . $razlika_u_sekundama . "');</script>";
                }
            } else {
                echo "Nema rezultata.";
            }
        }
    }
    ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
<div class="drzi">
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

                <input type="hidden" value="<?php echo isset($_GET['kod']) ? $_GET['kod'] : '';?> " name="kod">

            </div>
            <button type="submit">
            Restartuj lozinku
           
            </button>
        </form>
</div>
</div>
</body>
</html>