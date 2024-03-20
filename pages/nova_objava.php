<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova objava</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    $logoutId = "dugmeLogout";
    include "../handlers/konekcija.php";
    $poruka = $objavaNazivGreska = $objavaTekstGreska = $objavaSlikaGreska = $objavaTemaGreska = "";
    $id_korisnika = "";
    if (isset($_SESSION["logged_in_korisnik"]["id"])) {
        $id_korisnika = $_SESSION["logged_in_korisnik"]["id"];
    }
    $conn=connect();
    
    $sql = "SELECT ID_teme, naziv FROM tema";
    $result = mysqli_query($conn, $sql);
    $temaOptions = "";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tema_id = $row['ID_teme'];
            $temaOptions .= "<option value='" . $tema_id . "'>" . $row['naziv'] . "</option>";
        }
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tema_id = $_POST['tema'];
        echo $tema_id;
        $naslov = trim($_POST['naslov']);
        $tekst = trim($_POST['tekst']);

        if (empty($tema_id)) {
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

        $targetDir = "../images/";
        $fileName = basename($_FILES["slika"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["slika"]["tmp_name"], $targetFilePath)) {
                $imagePath = "images/" . $fileName;
                $sql = "INSERT INTO objava (ID_teme, ID_korisnika, naslov, tekst, slika) VALUES ('$tema_id','$id_korisnika','$naslov','$tekst','$imagePath')";
                if (mysqli_query($conn, $sql)) {
                    $poruka = "Objava uspešno dodata.";
                } else {
                    $poruka = "Greška pri dodavanju objave u bazu podataka: " . mysqli_error($conn);
                }
            }
        }
    }
?>
<header>
    <h2 class="logo">Reddify</h2>
    <nav class="navigacija">
            <a href="../index.php">Pocetna</a>
    </nav>
</header>
    <div class="drzi novaObjava col-12" style="top:0px; justify-content:space-around; flex-direction:row">
    
        <form class="col-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:flex; flex-direction:column; align-items:center; justify-content:center;" method="post" enctype="multipart/form-data">
        <h1 style="font-size:34px; color:white; letter-spacing:2px; text-transform:uppercase;">Nova objava</h1>
            <div class="input-box" style="border-bottom:none;" >
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
                <input type="file" class="form-control"   id="slika" name="slika" value="Izaberi sliku" style="cursos:pointer; transition:0.55s; width:200%; padding: 8px 12px; border-radius: 5px;">
                <p class="greska"><?php echo $objavaSlikaGreska; ?></p><br>
                <label style="top:-10px;" for="slika">Izaberi sliku:</label>
            </div>
            <button class="dugmeLogin" type="submit">Objavi</button>
            <p class="greska"style="text-align:center;"><?php echo $poruka; ?></p><br>
        </form>
            <div id="previewObjave" class="col-4" style="display:none; border: 1px solid #ccc; padding: 10px; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h3 id="previewNaslov" style="width:100%; margin-top: 10px; font-size:28px; text-align:center; margin: 0; color: white;"></h3>
                    <p id="previewAutor" style="margin: 0; color: white;"></p>
                </div>
                <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                    <img id="previewSlika" src="#" alt="Preview slika" style="max-width: 100%; height: auto;">
                </div>
                <p id="previewTekst" style="color: white; font-size:22px; margin-bottom: 10px;"></p>
            </div>
    </div>
</div>

    <script>
            document.addEventListener("DOMContentLoaded", function() {

            document.getElementById("naslov").addEventListener("input", updatePreview);
            document.getElementById("tekst").addEventListener("input", updatePreview);
            document.getElementById("slika").addEventListener("change", updatePreview);
        });

        function updatePreview() {

            var naslov = document.getElementById("naslov").value;
            var tekst = document.getElementById("tekst").value;
            var slika = document.getElementById("slika").files[0];

            document.getElementById("previewNaslov").textContent = naslov;
            document.getElementById("previewTekst").textContent = tekst;
            
            if (slika) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("previewSlika").src = e.target.result;
                    document.getElementById("previewSlika").style.display = "block";
                };
                reader.readAsDataURL(slika);
            } else {
                document.getElementById("previewSlika").style.display = "none";
            }

            document.getElementById("previewObjave").style.display = "block";
        }
    </script>
</body>
</html>