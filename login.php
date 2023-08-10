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
                // Puedes agregar más casos según los roles disponibles

                default:
                    $redirect_url = "error.php"; // Página de error en caso de roles desconocidos
            }

            header("Location: $redirect_url");
            exit();
        } else {
            $error_message = "Credenciales inválidas o usuario desactivado.";
        }
    } else {
        $error_message = "Credenciales inválidas o usuario desactivado.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">
    <div class="w-1/3 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Iniciar Sesión</h2>
        <?php if (isset($error_message)): ?>
            <p class="text-red-500 mb-4"><?= $error_message ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label class="block font-semibold">Correo Electrónico:</label>
            <input type="email" name="email" class="border rounded px-2 py-1 w-full mb-2" required>
            <label class="block font-semibold">Contraseña:</label>
            <input type="password" name="password" class="border rounded px-2 py-1 w-full mb-4" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
