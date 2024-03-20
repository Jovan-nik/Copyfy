<?php
include "../handlers/konekcija.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
   #GENERISE KOD
   $znakovi = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $kod = '';
        $duzina_znakova = strlen($znakovi);

        for ($i = 0; $i < 6; $i++) {
            $kod .= $znakovi[rand(0, $duzina_znakova - 1)];
        }
    
    $conn = connect();
    
   
    $loginEmail = $_POST["email"];

    $login_emailgreska="";
    $check_query = "SELECT * FROM korisnik WHERE email='$loginEmail'";
    $result = $conn->query($check_query);
    if ($result->num_rows == 0) {
      $login_emailgreska="Korisnik ne postoji u bazi.";
    }else {
        $row = $result->fetch_assoc();
        $ID_korisnika = $row['ID_korisnika']; 
        $sql = "INSERT INTO nove_lozinke(ID_korisnika,kod)
                VALUES('$ID_korisnika','$kod')"; 
        $conn->query($sql); 
    }

    if ($loginEmail === "") {
      echo "<script>";
      echo "alert('Morate uneti email adresu.');"; 
      echo "</script>";
    } else {
        // Poslati email sa zaboravljenom lozinkom
        $subject = 'Zaboravljena lozinka';
        $message = '<html><body style="text-align:center; height:150px; ">';
        $message .= '<h1>Zaboravili ste lozinku?</h1>';
        $message .= '<p>Kliknite na dugme ispod da biste resetovali lozinku:</p>';
        $message .= '<a href="copyfy.com/pages/reset_password.php?kod=' . $kod . '" target="_blank" style="height:30px; border-radius: 10px; background-color: green; color: white; padding: 10px; text-decoration: none;">Link za resetovanje lozinke</a>';
        $message .= '</body></html>';

        // Postavljanje headera za HTML mejl
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: your@example.com' . "\r\n" .
                   'Reply-To: your@example.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        // Slanje mejla
        if(!empty($login_emailgreska)){
         echo"Korisnik ne postoji";
        }
        elseif(mail($loginEmail, $subject, $message, $headers)) {
            echo "Email je uspešno poslat.";
        } else {
            echo "Greška: Nije moguće poslati email.";
        }
    }
} else {
    echo "Neispravan zahtev.";
}
?>

