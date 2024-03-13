<?php
include "konekcija.php";

function registracija($username, $email, $password)
{
    $conn = connect();
    $email = $email;
    $user_name = $username;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");

    // Provera postoji li korisnik s istim e-mailom u bazi
    $check_query = "SELECT * FROM korisnik WHERE email='$email'";
    $result = $conn->query($check_query);
    if ($result->num_rows > 0) {
        return "Korisnik već postoji u bazi.";
    }

    // Ako korisnik ne postoji, dodajte novog korisnika
    $sql = "INSERT INTO korisnik(email,user_name,password,registration_time)
            VALUES('$email', '$username', '$hashed_password', '$date')";
    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id;
        $_SESSION["logged_in_korisnik"] = array(
            "id" => $id,
            "email" => $email,
            "username" => $username,
        );
        return "";
    } else {
        echo "Greska pri unosu u bazu";
    }
}
?>
