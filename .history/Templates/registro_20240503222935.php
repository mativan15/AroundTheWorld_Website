<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $email = $_POST["email"];

    $mysqli = new mysqli("localhost", "root", "", "usuarios");
    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
    $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, apellido, username, password, dni, telefono, fecha_nacimiento, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ssssssss", $nombre, $apellido, $username, $hashed_password, $dni, $telefono, $fecha_nacimiento, $email);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "<p style='color: red;'>Error al registrar el usuario.</p>";
    }
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../static/registro.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="nombre">Nombres:</label><br>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="apellido">Apellidos:</label><br>
            <input type="text" id="apellido" name="apellido" required><br>
            <label for="username">Usuario:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="dni">DNI:</label><br>
            <input type="text" id="dni" name="dni" required><br>
            <label for="telefono">Teléfono:</label><br>
            <input type="tel" id="telefono" name="telefono" required><br>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label><br>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <input type="submit" value="Registrarse">
        </form>
        <a href="http://localhost:5000/">Regresar al inicio</a>
    </div>
</body>
</html>

