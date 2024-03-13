<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova objava</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php

    include "../handlers/konekcija.php";
    $poruka = $objavaNazivGreska = $objavaTekstGreska = $objavaSlikaGreska = $objavaTemaGreska = "";
    $id_korisnika = "";
    if (isset($_SESSION["logged_in_korisnik"]["id"])) {
        $id_korisnika = $_SESSION["logged_in_korisnik"]["id"];
    }
    $conn=connect();
    $sql = "SELECT naziv FROM tema";
    $result = mysqli_query($conn, $sql);
    $temaOptions = "";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $temaOptions .= "<option value='" . $row['naziv'] . "'>" . $row['naziv'] . "</option>";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tema = $_POST['tema'];
        $naslov = trim($_POST['naslov']);
        $tekst = trim($_POST['tekst']);

        if (empty($tema)) {
            $objavaTemaGreska = "Morate izabrati temu.";
        }
        if (empty($naslov)) {
            $objavaNazivGreska = "Naslov je obavezan.";
        }
        if (empty($tekst)) {
            $objavaTekstGreska = "Tekst je obavezan.";
        }
        if (empty($_FILES['slika']['name'])) {
            $objavaSlikaGreska = "Morate izabrati sliku.";
        }

        if (empty($objavaNazivGreska) && empty($objavaTekstGreska) && empty($objavaSlikaGreska) && empty($objavaTemaGreska)) {
            $slika_data = file_get_contents($_FILES['slika']['tmp_name']); // Read the image data
    
            // Prepare the SQL statement with placeholders
            $sql = "INSERT INTO objava (ID_teme, ID_korisnika, naslov, tekst, slika) VALUES (
                (SELECT ID_teme FROM tema WHERE naziv = ?),
                ?,
                ?,
                ?,
                ?
            )";
    
            // Create a prepared statement
            $stmt = mysqli_prepare($conn, $sql);
    
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "sssss", $tema, $id_korisnika, $naslov, $tekst, $slika_data);
    
            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $poruka = "Objava uspešno dodata.";
                echo "<script>setTimeout(function() {
                   window.location.href = '../index.php';
                }, 2000);</script>";
            } else {
                $poruka = "Greška prilikom dodavanja objave: " . mysqli_error($conn);
            }
    
            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }
    ?>
    <div class="drzi novaObjava col-12" style="top:0px;  flex-direction:column">
    <h1 style="font-size:34px; color:white; letter-spacing:2px; text-transform:uppercase;">Nova objava</h1>
    <form class="col-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:flex; flex-direction:column; align-items:center; justify-content:center;" method="post" enctype="multipart/form-data">
        <div class="input-box" >
                <select name="tema" id="tema">
                    <?php echo $temaOptions; ?>
                </select>
                <p class="greska"><?php echo $objavaTemaGreska; ?></p><br>
                <label for="tema" style="top:-18px;">Tema:</label>
        </div>
        <div class="input-box ">
            <input type="text" id="naslov" name="naslov">
            <p class="greska"><?php echo $objavaNazivGreska; ?></p><br>
            <label for="naslov">Naslov:</label>
        </div>
        <div class="input-box ">
            <input type="text" id="tekst" name="tekst">
            <p class="greska"><?php echo $objavaTekstGreska; ?></p><br>
            <label for="tekst">Tekst:</label>
        </div>
        <div class="input-box" style="border-bottom:none; display:flex; flex-direction:row; align-items:center; justify-content:center; ">
            <input type="file" id="slika" name="slika" value="Izaberi sliku" style="cursos:pointer; transition:1.05s; width:200%;  border: 2px solid white; padding: 8px 12px; border-radius: 5px;">
            <p class="greska"><?php echo $objavaSlikaGreska; ?></p><br>
            <label style="top:-10px;" for="slika">Izaberi sliku:</label>
        </div>
        <button class="dugmeLogin" type="submit">Objavi</button>
        <p class="greska"style="text-align:center;"><?php echo $poruka; ?></p><br>
    </form>
    </div>
</body>
</html>
