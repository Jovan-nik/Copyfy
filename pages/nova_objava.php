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
    $objavaNazivGreska = $objavaTekstGreska = $objavaSlikaGreska = "";

    ?>
    <div class="drzi novaObjava col-12" style="top:0px;  flex-direction:column">
    <h1 style="font-size:34px; color:white; letter-spacing:2px; text-transform:uppercase;">Nova objava</h1>
    <form class="col-6"action="handle_post.php" style="display:flex; flex-direction:column; align-items:center; justify-content:center;" method="post" enctype="multipart/form-data">
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
            <input type="file" id="slika" name="slika" value="Izaberi sliku" style="cursos:pointer; transition:1.05s; width:70%;  border: 2px solid white; padding: 8px 12px; border-radius: 5px;">
            <p class="greska"><?php echo $objavaSlikaGreska; ?></p><br>
            <label style="top:-10px;" for="slika">Izaberi sliku:</label>
        </div>
        <button class="dugmeLogin" type="submit">Objavi</button>
    </form>
    </div>
</body>
</html>
