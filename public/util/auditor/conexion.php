<?php

$servidor= "localhost";
$usuario= "gpeygbhh_root";
$password = 'Z)9QdQ+8etG]#_ize$Vk]D5o';
$nombreBD= "gpeygbhh_pos";

$db = new mysqli($servidor, $usuario, $password, $nombreBD);
$db->set_charset("utf8");
if ($db->connect_error) {
    die("la conexión ha fallado: " . $db->connect_error);
}
?>