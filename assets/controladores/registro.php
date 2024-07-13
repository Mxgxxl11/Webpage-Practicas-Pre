<?php

include 'bd.php';
$codigo = $_POST['codigo'];
$password = $_POST['password'];
$tipoDoc = $_POST['tipo_documento'];
$numDoc = $_POST['numero_documento'];
$primerNombre = $_POST['nombre1'];
$segundoNombre = $_POST['nombre2'];
$primerApellido = $_POST['apellido1'];
$segundoApellido = $_POST['apellido2'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];
$Escuela = $_POST['escuela'];

//para sacar la fecha de creacion de la cuenta
$fecha_actual = date("Y-m-d");

$query = "INSERT INTO usuarios(codigo_estudiante, contrasena, correo, idRoles, fecha_creacion, nombre1,
    nombre2, apellido1, apellido2, celular, direccion, idEscuela, id_tdoc, numDocumento)
    values ('$codigo','$password','$correo', 3, '$fecha_actual', '$primerNombre','$segundoNombre',
    '$primerApellido', '$segundoApellido', '$celular', '$direccion', '$Escuela','$tipoDoc','$numDoc')";

$verificarCorreo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo' "); //le estoy pidiendo que me verifique los correos que sean iguales
if (mysqli_num_rows($verificarCorreo) > 0) { //
    echo '
            <script>
                alert("Correo ya registrado, ingrese un correo válido.");
                window.location = "./login.html";
            </script>
        ';
    exit(); //para salir del script actual y que no se ejecute el codigo de abajo.
}
$verificarCodigo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE codigo_estudiante = '$codigo' ");
if (mysqli_num_rows($verificarCodigo) > 0) { //
    echo '
            <script>
                alert("Codigo ya registrado, ingrese un codigo nuevo.");
                window.location = "./login.html";
            </script>
        ';
    exit(); //para salir del script actual y que no se ejecute el codigo de abajo.
}

$ejecutar = mysqli_query($conexion, $query); //primero ingresamos la base, y luego ingresamos a los campos de la base

if ($ejecutar) {
    echo '
        <script>
            alert("Usuario almacenado exitosamente.");
            window.location = "./../../login.html";
        </script>';
} //Cambiar el window.location.
else {
    echo '
        <script>
            alert("Usuario no almacenado. Intentelo nuevamente.");
            
        </script>';
    echo "Error: " . mysqli_error($conexion);
}
mysqli_close($conexion);
