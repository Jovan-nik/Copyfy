<?php
include "konekcija.php";

session_start();
$loggedInKorisnik_id = $_SESSION["logged_in_korisnik"]["id"];
$conn = connect();

if (isset($_GET['id_objave'])) {
    $id_objave = $_GET['id_objave'];
    $sql = "DELETE FROM objava WHERE ID_objave = $id_objave AND ID_korisnika = $loggedInKorisnik_id";
    if ($conn->query($sql) === TRUE) {
        echo "Objava sa ID-om $id_objave je uspešno obrisana.";
    } else {
        echo "Greška prilikom brisanja objave: " . $conn->error;
    }
}

$conn->close();
?>