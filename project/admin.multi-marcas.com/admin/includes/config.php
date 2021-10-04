<?php
//Aplicacion
define('DEMO_STS','false');//Activar o desactivar demo true/false
define('APP_TITLE','Multi Marcas');
define('APP_HEAD','Multi Marcas');
define('THEME_HEAD','pink');
define('THEME_RGB','#'.'ff008f');
define('THEME_EXCEL','ff008f');


//Recuperacion de accesos para el administrador
define('EMAIL_RECOVERY','soporterg@multi-marcas.com');
define('ADMIN_ROOT','MGarcia');
define('ADMIN_PASS','Misael1406');

//Contraseña Predeterminada para empleados nuevos
define('PASS_PRED','M123456789*');


// Datos de la base de datos
define('DB_HOST','localhost');
define('DB_USER','bqwdxwfh_root');
define('DB_PASS','LH[b5w*8jOUG');
define('DB_NAME','bqwdxwfh_asistencias');

// Datos de conexion a servidor SMTP
define('HOST_SMTP','mail.multi-marcas.com');    /*Servidor SMTP*/
define('SECURE_SMTP','');   /*Protocolo SSL o TLS*/
define('PORT_SMTP','587');   /*Puerto de conexión al servidor SMTP*/
define('AUTH_SMTP','true');   /*Para habilitar o deshabilitar la autenticación*/
define('USERNAME_SMTP','mail@multi-marcas.com');   /*Usuario, normalmente el correo electrónico*/
define('PASSWORD_SMTP','*Mm.com/*0*');   /*Tu contraseña*/
define('FROM_SMTP','mail@multi-marcas.com');   /*Correo electrónico que estamos autenticando*/
define('FROM_NAME_SMTP','Multi Marcas');   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
define('COD_SMTP','UTF-8');   /*Codificación del mensaje*/

/*Dominio donde se alojan los correos de la empresa
Ejemplo: hotmail.com
         gmail.com
         outlook.com*/
define('DOMINIO_SMTP','@'.'multi-marcas.com');

// Comando de conexion establesida
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}


                            
?>