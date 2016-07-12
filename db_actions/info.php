<?php

//echo phpinfo();

$to      = 'mhmmd.nauman@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: mhmmd.nauman@gmail.com' . "\r\n" .
    'Reply-To: mhmmd.nauman@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 

