<?php
$servername = "v48.h.filess.io";
 $username = "NamorProjects_blackhayup";
 $password = "24961d0ecc320eea10392be9cbd172427fd82f9e";
 $dbname = "NamorProjects_blackhayup";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
