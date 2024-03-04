<?php
$to = 'nikodinovicjovan1@gmail.com';
$subject = 'Test Email';
$message = 'MILOYE. jede decu.';
$headers = 'From: nikodinovicjovan1@gmail.com' . "\r\n" .
           'Reply-To: nikodinovicjovan1@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
    
if (mail($to, $subject, $message, $headers)) {
   echo 'POslato!';
} else {
   echo 'Error: Unable to send email.';
}
?>
