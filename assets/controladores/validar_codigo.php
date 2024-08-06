<?php
session_start();
include 'bd.php';
// este codigo me sirve para validar el codigo y que me direccione a la pestaña de reestablecer la contraseña
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];

    // Verificar que el código existe en la base de datos
    $query = "SELECT * FROM usuario WHERE codigo = '$codigo'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['codigo'] = $codigo;
        header("Location: ./../../../restablecer_contra.php");
    } else {
        echo '
            <script>
                alert("Código inválido, verifique sus credenciales");
                window.location = "./../../../olvide_contra.html"; 
            </script>
        ';
    }
}
