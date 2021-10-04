<?php

/*
*
* Endeos, Working for You
* blog.endeos.com
*
*/

require_once('PHPMailerAutoload.php');


$mail = new PHPMailer;

//$mail->SMTPDebug    = 3;

$mail->IsSMTP();
$mail->Host =           HOST_SMTP;   /*Servidor SMTP*/																		
$mail->SMTPSecure =     SECURE_SMTP;   /*Protocolo SSL o TLS*/
$mail->Port =           PORT_SMTP;   /*Puerto de conexión al servidor SMTP*/
$mail->SMTPAuth =       AUTH_SMTP;   /*Para habilitar o deshabilitar la autenticación*/
$mail->Username =       USERNAME_SMTP;   /*Usuario, normalmente el correo electrónico*/
$mail->Password =       PASSWORD_SMTP;   /*Tu contraseña*/
$mail->From =           FROM_SMTP;   /*Correo electrónico que estamos autenticando*/
$mail->FromName =       FROM_NAME_SMTP;   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
$mail->CharSet =        COD_SMTP;   /*Codificación del mensaje*/

?>