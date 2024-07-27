<?php
session_start(); //para iniciar sesion
include 'bd.php'; //para usar la conexion a la bd

$correo = $_POST['Correo_Institucional'];
$contrasena = $_POST['password'];
$contrasena = hash('sha512', $contrasena);

$query = "SELECT * FROM usuarios WHERE correo = '$correo' and contrasena= '$contrasena'";
$resultado = mysqli_query($conexion, $query);

$query2 = "SELECT idRol FROM tipo_usuario";
$resultado2 = mysqli_query($conexion, $query2);

if ((mysqli_num_rows($resultado) > 0) and (mysqli_num_rows($resultado2) > 0)) { //si encuentra un dato que esta en la BD nos dirige a una pagina de bienvenida
    if ($datos = $resultado->fetch_object() and $datoRol = $resultado2->fetch_object()) {
        $_SESSION['Correo_Institucional'] = $datos->correo; //para que no cualquiera pueda entrar a la siguiente pagina
        $_SESSION['codigo_institucional'] = $datos->codigo;
        $_SESSION['primer_nombre'] = $datos->nombre1;
        $_SESSION['segundo_nombre'] = $datos->nombre2;
        $_SESSION['primer_apellido'] = $datos->apellido1;
        $_SESSION['segundo_apellido'] = $datos->apellido2;
        //RECUERDA: el idRol lo sacamos de otra tabla. 
        $_SESSION['idRol'] = $datoRol->idRol;

        $_SESSION['celular'] = $datos->celular;

        if ($_SESSION['idRol'] == 1) {
            header("location: ./../../../menuprincipal.php");
        } else if ($_SESSION['idRol'] == 2) {
            header("location: ./../../../menusecretaria.php");
        } else if ($_SESSION['idRol'] == 3) {
            header("location: ./../../../mesadepartes.php");
        }

        exit();
    }
} else {
    echo '
            <script>
            alert("Correo inválido o contraseña, verifique sus credenciales");
            window.location = "./../../../login.html"; 
            </script>
        ';
    exit();
}

mysqli_close($conexion); //si hay algun error probar borrar esto
