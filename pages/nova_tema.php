<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova tema</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    include "../handlers/konekcija.php";
    $temaNazivGreska = $temaOpisGreska = "";
    $naziv = $opis = $poruka = "";

    $conn = connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["naziv"])) {
            $temaNazivGreska = "Morate uneti naziv teme.";
        } else {
            $naziv = $_POST["naziv"];
        }

        if (empty($_POST["opis"])) {
            $temaOpisGreska = "Morate uneti opis teme.";
        } else {
            $opis =$_POST["opis"];
        }

        if (empty($temaNazivGreska) && empty($temaOpisGreska)) {
            $sql_check = "SELECT * FROM tema WHERE naziv = '$naziv'";
            $result_check = $conn->query($sql_check);
            
            if ($result_check->num_rows > 0) {
                $temaNazivGreska="Tema sa istim nazivom već postoji.";
            } else {
                $sql_insert = "INSERT INTO tema (naziv, opis) VALUES ('$naziv', '$opis')";
                if ($conn->query($sql_insert) === TRUE) {
                    $poruka= "Nova tema uspešno dodana.";
                    header("Location: ../index.php");
                } else {
                    $poruka= "Greška prilikom dodavanja nove teme: $conn->error";
                }
            }
        }
    }

    $conn->close();

    ?>
<div class="drzi novaTema col-12">
    <form class="col-6" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="input-box ">
            <input type="text" id="naziv" name="naziv" >
            <p class="greska"><?php echo $temaNazivGreska; ?></p><br>
            <label for="naziv">Naziv:</label>
        </div>
        <div class="input-box">
            <input type="text" id="opis" name="opis">
            <p class="greska"><?php echo $temaOpisGreska; ?></p><br>
            <label for="opis">Opis:</label>
        </div>
        <button class="dugmeLogin" type="submit">Dodaj temu</button>
        <p class="greska"><?php echo $poruka; ?></p><br>
    </form>
</div>
</body>
</html>