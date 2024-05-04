<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $mysqli = new mysqli("localhost", "root", "", "DB proyecto final");

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("SELECT id, password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            setcookie("username", $username, time() + (86400 * 30), "/");
            // Send POST request to Flask server
            $url = 'http://127.0.0.1:5000/login_redirect';
            $data = array('username' => $username, 'user_id' => $id);
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) {
                // Handle error
            } else {
                // Redirect user based on Flask response
                header("Location: " . $result);
            }
        } else {
            echo "<p style='color: red;'>Usuario o contraseña incorrectos.</p>";
        }
    } else {
        echo "<p style='color: red;'>Usuario o contraseña incorrectos.</p>";
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
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../static/login.css">


</head>
<body>
    <div class="container">
        <h2>Iniciar sesión</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username">Usuario:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Iniciar sesión">
        </form>
        <div class="signup">
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>

        </div>
    </div>
</body>
</html>

