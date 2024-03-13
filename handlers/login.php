<?php

function login($email, $password)
{
    $conn = connect();
    $email = $email;
    $password = $password; 

    $sql = "SELECT * FROM korisnik WHERE email = '$email'";
    $result = $conn->query($sql);
        
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
               
            if (password_verify($password, $row["password"])) {
                $_SESSION["logged_in_korisnik"] = array(
                    "id" => $row["ID_korisnika"],
                    "email" => $row["email"],
                    "username" => $row["user_name"],
                );
                return "Uspesno logovanje"; 
            } else {
                return "Pogrešan e-mail ili lozinka"; 
                
            }
        }
    } else {
        return "Pogrešan e-mail ili lozinka";
    }
}
?>
