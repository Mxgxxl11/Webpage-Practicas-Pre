<?php
include 'bd.php';
session_start();
date_default_timezone_set('America/Lima');
define('RUTA_DEF_CARPETA', './../carpetas_virtuales/');

$codigo = $_SESSION['codigo_institucional'];
$exam = $_FILES['examen'];
$fechaExamen = $_POST['fechaExamen'];
$fechaHoy = date('Y-m-d');

if($fechaExamen !== $fechaHoy){
    echo 'La fecha de envío del examen debe ser la fecha actual.';
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
if ($exam['error'] === UPLOAD_ERR_OK) {
    // Crear la ruta completa de la carpeta del alumno
    $ruta_carpeta = RUTA_DEF_CARPETA . $nombre_carpeta;

    // Verificar si la carpeta existe; si no, crearla
    if (!file_exists($ruta_carpeta)) {
        echo "LA CARPETA NO EXISTE :("; // Crear la carpeta con permisos completos
    }

    // Definir la ruta completa donde se almacenará el archivo
    $ruta_destino = $ruta_carpeta . "/Examen_Final_Resuelto.pdf";

    // Mover el archivo a la carpeta correspondiente
    if (move_uploaded_file($exam['tmp_name'], $ruta_destino)) {
        // Preparar la consulta SQL para insertar en la base de datos  
        $sql = "INSERT INTO archivos (id_carpeta, nombre_archivo, fecha_subida, ruta) VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        $nombre_archivo = "Examen Final Resuelto";

        // Enlazar parámetros  
        $stmt->bind_param("isss", $id_carpeta, $nombre_archivo, $fechaExamen, $ruta_destino);

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

// Inserción en la tabla notificaciones
$query = "INSERT INTO notificaciones (id_usuario, id_archivo, tipo_notificacion, mensaje, id_profesor) VALUES (?, ?, ?, ?, ?)";  

$tipo_notificacion = 'Examen Final Resuelto';
$mensaje = 'Subí el examen final resuelto';

$result3 = mysqli_query($conexion, "SELECT id_archivo FROM archivos WHERE (nombre_archivo = '$nombre_archivo' AND id_carpeta = '$id_carpeta')");  
$row3 = mysqli_fetch_assoc($result3);  
$id_archivo = $row3['id_archivo'];

$result4 = mysqli_query($conexion, "SELECT id_profesor FROM notificaciones WHERE (tipo_notificacion = 'Examen Final' AND id_usuario = '$codigo')");  
$row4 = mysqli_fetch_assoc($result4);  
$id_docente = $row4['id_profesor'];

// Preparar la consulta  
$stmt3 = mysqli_prepare($conexion, $query);  
if (!$stmt3) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
}  
mysqli_stmt_bind_param($stmt3, "iissi", $codigo, $id_archivo, $tipo_notificacion, $mensaje, $id_docente); 
$ejecutar2 = mysqli_stmt_execute($stmt3);  

$query = "UPDATE paso_cp SET paso = 13 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query);

if (!$stmt2) {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    exit();
}
$ejecutar = mysqli_stmt_execute($stmt2);


if ($ejecutar) {  

    $_SESSION['paso_cp'] = '13'; // Cambia esto según el div que desees mostrar  

    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
