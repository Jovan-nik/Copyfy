<?php
include "konekcija.php";

session_start();
$loggedInKorisnik_id = $_SESSION["logged_in_korisnik"]["id"];
$conn = connect();

    $sql = "SELECT ID_objave, naslov FROM objava WHERE ID_korisnika = $loggedInKorisnik_id";
    $result = $conn->query($sql);

    $objave = [];
    while ($row = $result->fetch_assoc()) {
        $objava = [
            "ID_objave" => $row["ID_objave"],
            "naslov" => $row["naslov"]
        ];
        $objave[] = $objava;
    }
    echo json_encode($objave);

$conn->close();
?>