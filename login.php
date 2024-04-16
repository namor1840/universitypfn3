<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conexion.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, password, rol, habilitado FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password']) && $row['habilitado'] == 1) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_role'] = $row['rol'];

            $redirect_url = "";
            switch ($row['rol']) {
                case 'admin':
                    $redirect_url = "admin.php";
                    break;
                case 'alumno':
                    $redirect_url = "alumno.php";
                    break;
                case 'maestro':
                    $redirect_url = "maestro.php";
                    break;
                default:
                    $redirect_url = "erro.php"; // Página de error en caso de roles desconocidos
            }

            $conn->close(); // Cerrar la conexión antes de la redirección
            header("Location: $redirect_url");
            exit();
        } else {
            $_SESSION['error_message'] = "Credenciales inválidas o usuario desactivado.";
        }
    } else {
        $_SESSION['error_message'] = "Credenciales inválidas o usuario desactivado.";
    }
}

// Si llegamos a este punto, algo salió mal, y deberíamos redirigir de nuevo al index.php
$_SESSION['error_message'] = "Error en la autenticación."; // Puedes personalizar este mensaje
$conn->close();
header("Location: index.php");
exit();
?>
