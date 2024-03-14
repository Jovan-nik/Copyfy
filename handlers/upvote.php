<?php

session_start();

if (isset($_SESSION["logged_in_korisnik"]["id"]) && isset($_POST["objava_id"])) {

    include "konekcija.php";
    $conn = connect();

    $korisnikId = $_POST["korisnik_id"];
    $objavaId = $_POST["objava_id"];

    $query = "INSERT INTO up_vote (ID_korisnika, ID_objave) VALUES ('$korisnikId', '$objavaId')";
    
    if (mysqli_query($conn, $query)) {

        echo "Upvote je uspešno zabeležen.";
    } else {
        echo "Greška prilikom upisa upvote-a u bazu podataka: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Niste prijavljeni kao korisnik.";
}
?>
