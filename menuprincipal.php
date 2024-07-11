<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
</head>

<body>
    <h1>HEY WHATS UP FUCKERS!!!!! 🤑</h1>
    <p><?php echo $_SESSION['codigo_institucional'] ?></p>
    <p><?php echo $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido']; ?></p>
    <a href="assets/controladores/cerrar_sesion.php">Salir</a>
</body>

</html>