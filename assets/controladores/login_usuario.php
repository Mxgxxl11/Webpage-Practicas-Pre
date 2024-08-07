<?php
session_start(); //para iniciar sesion
include 'bd.php'; //para usar la conexion a la bd

$correo = $_POST['correo'];
$contrasena = $_POST['password'];
$contrasena = hash('sha512', $contrasena);

// Obtener la información del usuario junto con su rol
$query = "SELECT u.*, a.id_rol, a.id_usuario
          FROM usuario u
          JOIN acceso a ON u.codigo = a.id_usuario
          WHERE (u.correo = '$correo' AND u.contraseña = '$contrasena')";

$query2 = "SELECT paso
          FROM usuario u
          JOIN paso_cp p ON u.codigo = p.id_usuario";

$resultado = mysqli_query($conexion, $query);
$resultado2 = mysqli_query($conexion, $query2);

if (!$resultado || !$resultado2) {
    // Si la consulta falla, muestra el error y termina la ejecución
    die("Error en la consulta: " . mysqli_error($conexion));
}

if (mysqli_num_rows($resultado) > 0) { //si encuentra un dato que esta en la BD nos dirige a una pagina de bienvenida
    if (($datos = $resultado->fetch_object()) && ($datos2 = $resultado2->fetch_object())) {
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
        $_SESSION['departamento'] = $datos->nro_departamento;
        $_SESSION['documento'] = $datos->numDocumento;
        $_SESSION['id_rol'] = $datos->id_rol;
        $_SESSION['paso_cp'] = $datos2->paso;

        $query3 = "SELECT escuela, imagen_firma
          FROM usuario u
          JOIN escuelas e ON u.id_escuela = e.id_escuela
          JOIN acceso a ON u.codigo = a.id_usuario
          JOIN alumno al ON u.codigo = al.id_usuario
          WHERE u.codigo = $_SESSION[codigo_institucional]";

        $resultado3 = mysqli_query($conexion, $query3);
        $datos3 = $resultado3->fetch_object();
        $_SESSION['escuela_profesional'] = $datos3->escuela;
        $_SESSION['firma'] = $datos3->foto_firma;

        if ($_SESSION['id_rol'] == 3) {
            header("location: ./../../../mesadepartes.php");
        } else if ($_SESSION['id_rol'] == 2) {
            header("location: ./../../../menusecretaria.php");
        } else if ($_SESSION['id_rol'] == 1) {
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
