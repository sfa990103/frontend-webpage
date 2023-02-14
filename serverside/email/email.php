<?php
$to = "somebody@example.com";
$subject = $_POST["title"];
$txt = $_POST["message"];
$email = $_POST["email"];
$txt = $txt."\r\n"."FROM : ".$email;
$headers = "From: Enquries@hkiersvpn.com" . "\r\n";

mail($to,$subject,$txt,$headers);
echo "success";
?>