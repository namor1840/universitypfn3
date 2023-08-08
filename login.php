<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $servername = "localhost";
    $db_username = "tu_usuario";
    $db_password = "tu_contraseña";
    $dbname = "tu_base_de_datos";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT id, nombre, rol, habilitado FROM usuarios WHERE nombre = '$username' AND contraseña = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['habilitado'] == 0) {
            $error_message = "El usuario está desactivado.";
        } else {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_role'] = $row['rol'];

            if ($row['rol'] === 'admin') {
                header("Location: admin.php");
            } elseif ($row['rol'] === 'maestro') {
                header("Location: maestro.php");
            } elseif ($row['rol'] === 'alumno') {
                header("Location: alumno.php");
            }
            exit();
        }
    } else {
        $error_message = "Credenciales inválidas.";
    }

    $conn->close();
}
?>
