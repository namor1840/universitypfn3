<?php
$servername = "localhost";
$username = "id21126023_root";
$password = "Roman18*";
$dbname = "id21126023_universidad";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
