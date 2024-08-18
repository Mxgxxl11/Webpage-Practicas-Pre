<?php
include 'bd.php';
session_start();
date_default_timezone_set('America/Lima');
define('RUTA_DEF_CARPETA', './../carpetas_virtuales/');

$codigo = $_SESSION['codigo_institucional'];
$informe2 = $_FILES['informe2'];
$fecha_subida = $_POST['fechaInforme2'];

$fechaHoy = date('Y-m-d');

if($fecha_subida !== $fechaHoy){
    echo '  
        La fecha de registro debe ser la fecha de hoy.';  
    exit(); 
}

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_carpeta, nombre_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");
$row2 = mysqli_fetch_assoc($result2);
$id_carpeta = $row2['id_carpeta'];
$nombre_carpeta = trim($row2['nombre_carpeta']); // Eliminar espacios en blanco

// Verifica si el archivo fue subido  
if ($informe2['error'] === UPLOAD_ERR_OK) {
    // Crear la ruta completa de la carpeta del alumno
    $ruta_carpeta = RUTA_DEF_CARPETA . $nombre_carpeta;

    // Verificar si la carpeta existe; si no, crearla
    if (!file_exists($ruta_carpeta)) {
        echo "LA CARPETA NO EXISTE :("; // Crear la carpeta con permisos completos
    }

    // Definir la ruta completa donde se almacenará el archivo
    $ruta_destino = $ruta_carpeta . "/2do_Informe.pdf";

    // Mover el archivo a la carpeta correspondiente
    if (move_uploaded_file($informe2['tmp_name'], $ruta_destino)) {
        // Preparar la consulta SQL para insertar en la base de datos  
        $sql = "INSERT INTO archivos (id_carpeta, nombre_archivo, fecha_subida, ruta) VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        $nombre_archivo = "2do Informe";

        // Enlazar parámetros  
        $stmt->bind_param("isss", $id_carpeta, $nombre_archivo, $fecha_subida, $ruta_destino);

        // Ejecutar la consulta  
        if ($stmt->execute()) {
            echo "Archivo almacenado correctamente en la base de datos.";
        } else {
            echo "Error al almacenar el archivo: " . $stmt->error;
        }

        // Cerrar el statement  
        $stmt->close();
    } else {
        echo "Error al mover el archivo a la carpeta destino.";
    }
} else {
    echo "Error al subir el archivo.";
}

$query = "UPDATE paso_cp SET paso = 7 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query);

if (!$stmt2) {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    exit();
}
$ejecutar = mysqli_stmt_execute($stmt2);

if ($ejecutar) {
    $_SESSION['paso_cp'] = '7'; // Cambia esto según el div que desees mostrar  
    echo 'Datos almacenados exitosamente';
} else {
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';
    echo "Error: " . mysqli_error($conexion);
}

mysqli_close($conexion);
