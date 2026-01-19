<?php
$host = "localhost";
$user = "root"; // usuario de la base de datos
$pass = "Prueba123"; // contraseña de la base de datos
$db   = "sistema_seguimient_op"; // nombre de la base de datos

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>