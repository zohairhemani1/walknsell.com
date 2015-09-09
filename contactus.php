<?php
header('Access-Control-Allow-Origin: *');
$name = $_POST['name-contact'];
$emailAdd = $_POST['email-contact'];
$message = $_POST['message-contact'];

$to = 'WalknSell <info@avialdo.com>';
$subject = 'WalknSell Contact Form Response';
$headers = 'From: '.$name.' <'.$emailAdd.'>' . "\r\n" .
    'Reply-To: '.$name.' <'.$emailAdd.'>' . "\r\n";

$flag = mail($to, $subject, $message, $headers);
if($flag){
    echo 'success';
}else{
    echo 'failed';
}
?>