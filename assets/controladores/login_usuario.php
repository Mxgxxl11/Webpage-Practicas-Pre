<?php
session_start(); //para iniciar sesion
include 'bd.php'; //para usar la conexion a la bd

$correo = $_POST['Correo_Institucional'];
$contrasena = $_POST['password'];

$query = "SELECT * FROM usuarios WHERE correo = '$correo' and contrasena= '$contrasena'";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) { //si encuentra un dato que esta en la BD nos dirige a una pagina de bienvenida
    if ($datos = $resultado->fetch_object()) {
        $_SESSION['Correo_Institucional'] = $datos->correo; //para que no cualquiera pueda entrar a la siguiente pagina
        $_SESSION['codigo_institucional'] = $datos->codigo_estudiante;
        $_SESSION['primer_nombre'] = $datos->nombre1;
        $_SESSION['segundo_nombre'] = $datos->nombre2;
        $_SESSION['primer_apellido'] = $datos->apellido1;
        $_SESSION['segundo_apellido'] = $datos->apellido2;
        header("location: ./../../../menuprincipal.php");
        exit();
    }
} else {
    echo '
            <script>
            alert("Correo inválido, verifique sus credenciales");
            window.location = "login.html"; 
            </script>
        ';
    exit();
}
