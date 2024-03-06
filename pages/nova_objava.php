<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova objava</title>
</head>
<body>
    <h1>Nova objava</h1>
    <form action="handle_post.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="naslov">Naslov:</label>
            <input type="text" id="naslov" name="naslov">
        </div>
        <div>
            <label for="tekst">Tekst:</label>
            <input type="text" id="tekst" name="tekst">
        </div>
        <div>
            <label for="slika">Slika:</label>
            <input type="file" id="slika" name="slika">
        </div>
        <button type="submit">Objavi</button>
    </form>
</body>
</html>
