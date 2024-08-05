<?php
session_start(); //para iniciar sesion
include 'bd.php'; //para usar la conexion a la bd

$correo = $_POST['Correo_Institucional'];
$contrasena = $_POST['password'];
$contrasena = hash('sha512', $contrasena);

// Obtener la información del usuario junto con su rol
$query = "SELECT u.*, t.idRol, t.codigo 
          FROM usuarios u 
          JOIN tipo_usuario t ON u.codigo = t.codigo 
          WHERE u.correo = '$correo' AND u.contrasena = '$contrasena'";

$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    // Si la consulta falla, muestra el error y termina la ejecución
    die("Error en la consulta: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) > 0) { //si encuentra un dato que esta en la BD nos dirige a una pagina de bienvenida
    if ($datos = $resultado->fetch_object()) {
        $_SESSION['Correo_Institucional'] = $datos->correo; //para que no cualquiera pueda entrar a la siguiente pagina
        $_SESSION['codigo_institucional'] = $datos->codigo;
        $_SESSION['primer_nombre'] = $datos->nombre1;
        $_SESSION['segundo_nombre'] = $datos->nombre2;
        $_SESSION['primer_apellido'] = $datos->apellido1;
        $_SESSION['segundo_apellido'] = $datos->apellido2;
        $_SESSION['foto'] = $datos->foto;
        $_SESSION['celular'] = $datos->celular;
        $_SESSION['distrito'] = $datos->distrito;
        $_SESSION['direccion'] = $datos->direccion;
        $_SESSION['documento'] = $datos->numDocumento;
        $_SESSION['idRol'] = $datos->idRol;

        if ($_SESSION['idRol'] == 3) {
            header("location: ./../../../mesadepartes.php");
        } else if ($_SESSION['idRol'] == 2) {
            header("location: ./../../../menusecretaria.php");
        } else if ($_SESSION['idRol'] == 1) {
            header("location: ./../../../menuadmin.php");
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
mysqli_close($conexion);
