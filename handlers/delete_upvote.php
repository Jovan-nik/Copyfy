<?php
session_start();

if (isset($_SESSION["logged_in_korisnik"]["id"]) && isset($_POST["objava_id"])) {

    include "konekcija.php";
    $conn = connect();

    $korisnikId = $_POST["korisnik_id"];
    $objavaId = $_POST["objava_id"];

    $delete_query = "DELETE FROM up_vote WHERE ID_korisnika = '$korisnikId' AND ID_objave = '$objavaId'";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "Upvote je uspešno obrisan.";
    } else {
        echo "Greška prilikom brisanja upvote-a iz baze podataka: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Niste prijavljeni kao korisnik.";
}
?>