<?php
//REGISTRO DE ADMINS EN EL PORTAL DE ADMINISTRADORES 
include 'bd.php';
$rol = $_POST['rol'];
$codigo = $_POST['codigo'];
$password = $_POST['password'];
$password = hash('sha512', $password);
$tipoDoc = $_POST['tipo_documento'];
$numDoc = $_POST['numero_documento'];
$primerNombre = $_POST['nombre1'];
$segundoNombre = $_POST['nombre2'];
$primerApellido = $_POST['apellido1'];
$segundoApellido = $_POST['apellido2'];
$distrito = $_POST['distrito'];
$direccion = $_POST['direccion'];
$dpto = $_POST['dpto'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];
$Escuela = $_POST['escuela'];

//para sacar la fecha de creacion de la cuenta
$fecha_actual = date("Y-m-d");
//recordar que idRoles ahora esta en otra tabla
//aca se guardan los admin
$query = "INSERT INTO usuario(codigo, contrasena, correo, fecha_creacion, nombre1,
    nombre2, apellido1, apellido2, celular, direccion, id_escuela, id_tipodoc, numDocumento, distrito, nro_departamento)
    VALUES ('$codigo','$password','$correo', '$fecha_actual', '$primerNombre','$segundoNombre',
    '$primerApellido', '$segundoApellido', '$celular', '$direccion', '$Escuela','$tipoDoc','$numDoc', '$distrito', '$dpto')";

//guardando codigo y idRol en la tabla tipo_usuario
$query2 = "INSERT INTO acceso(id_usuario, id_rol) VALUES ('$codigo', '$rol')";
$query3 = "INSERT INTO docente(id_usuario) VALUES ('$codigo')";
$query4 = "INSERT INTO paso_cp(paso, id_usuario) VALUES (0, '$codigo')";

$verificarCorreo = mysqli_query($conexion, "SELECT * FROM usuario WHERE correo = '$correo' "); //le estoy pidiendo que me verifique los correos que sean iguales
if (mysqli_num_rows($verificarCorreo) > 0) { //
    echo '
            <script>
                alert("Correo ya registrado, ingrese un correo válido.");
                window.location = "./../../agregar_usuario.php";
            </script>
        ';
    exit(); //para salir del script actual y que no se ejecute el codigo de abajo.
}
$verificarCodigo = mysqli_query($conexion, "SELECT * FROM usuario WHERE codigo = '$codigo' ");
if (mysqli_num_rows($verificarCodigo) > 0) { //
    echo '
            <script>
                alert("Codigo ya registrado, ingrese un codigo nuevo.");
                window.location = "./../../agregar_usuario.php";
            </script>
        ';
    exit(); //para salir del script actual y que no se ejecute el codigo de abajo.
}
$verificarDOC = mysqli_query($conexion, "SELECT * FROM usuario WHERE  numDocumento= '$numDoc' "); //le estoy pidiendo que me verifique los numDOC que sean iguales
if (mysqli_num_rows($verificarDOC) > 0) { //
    echo '
            <script>
                alert("Numero de documento ya registrado, ingrese un correo válido.");
                window.location = "./../../agregar_usuario.php";
            </script>
        ';
    exit(); //para salir del script actual y que no se ejecute el codigo de abajo.
}

//Para cuando le demos a registrar
$ejecutar = mysqli_query($conexion, $query); // RECORDANDO: primero ingresamos la base, y luego ingresamos a los campos de la base
$ejecutar2 = mysqli_query($conexion, $query2);

$ejecutar4 = mysqli_query($conexion, $query4);

if ($ejecutar and $ejecutar2) {
    if ($rol == 2) {
        $ejecutar3 = mysqli_query($conexion, $query3);
        if ($ejecutar3) {
            echo '
            <script>
                alert("Docente almacenado exitosamente.");
                window.location = "./../../agregar_usuario.php";
            </script>';
        }
    } else {
        echo '
                    <script>
                        alert("Administrador almacenado exitosamente.");
                        window.location = "./../../agregar_usuario.php";
                    </script>';
    }
} else {
    echo '
        <script>
            alert("Usuario no almacenado. Intentelo nuevamente.");
            window.location = "./../../agregar_usuario.php";
        </script>';
    echo "Error: " . mysqli_error($conexion);
}

mysqli_close($conexion);
