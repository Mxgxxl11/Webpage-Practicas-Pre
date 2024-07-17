<?php
session_start();
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $codigo =  $_SESSION['codigo'];
    if ($nueva_contrasena !== $confirmar_contrasena) {
        echo '
            <script>
                alert("Las contraseñas no coinciden, ingreselas de nuevo");
                window.location = "./../../restablecer_contra.php";
            </script>
        ';
        exit();
    }

    // Encriptar la nueva contraseña
    $nueva_contrasena_hashed = hash('sha512', $nueva_contrasena);

    // Actualizar la contraseña en la base de datos
    $cambiar_contrasena = "UPDATE usuarios SET contrasena = '$nueva_contrasena_hashed' WHERE codigo = '$codigo'";
    $validar_contrasena = mysqli_query($conexion, $cambiar_contrasena);

    if ($validar_contrasena) {
        session_destroy();
        echo '
            <script>
                alert("Contraseña cambiada con éxito!");
                window.location = "./../../login.html";
            </script>
        ';
    } else {
        $error = mysqli_error($conexion);
        echo '
            <script>
                alert("Problemas al actualizar la contraseña. Intentelo de nuevo");
                window.location = "./../../restablecer_contra.php";
            </script>
        ';
    }
}
