<?php  
include 'bd.php'; 
session_start();  
date_default_timezone_set('America/Lima');
define('RUTA_DEF_CARPETA', './../carpetas_virtuales/'); 

$codigo = $_SESSION['codigo_institucional'];
$codigo_a = $_POST['codigo_a'];
$fechaRegistro = $_POST['fechaRegistro'];
$evaluacion = $_FILES['evaluacion'];
$fechaHoy = date('Y-m-d');
$id_archivo = 0;
$nombre_archivo = "Ficha de Evaluacion";

if($fechaRegistro !== $fechaHoy){
    echo '  
        <script>  
            alert("La fecha de envío del examen debe ser la fecha actual.");   
            window.location = "./../../ficha-evaluacion-alui.php?codigo=' . $codigo_a . '";
        </script>';  
    exit(); 
}

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo_a'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_carpeta, nombre_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");  
$row2 = mysqli_fetch_assoc($result2);  
$id_carpeta = $row2['id_carpeta'];
$nombre_carpeta = trim($row2['nombre_carpeta']); // Eliminar espacios en blanco

// Verifica si el archivo fue subido  
if ($evaluacion['error'] === UPLOAD_ERR_OK) {
    // Crear la ruta completa de la carpeta del alumno
    $ruta_carpeta = RUTA_DEF_CARPETA . $nombre_carpeta;

    // Verificar si la carpeta existe; si no, crearla
    if (!file_exists($ruta_carpeta)) {
        echo "LA CARPETA NO EXISTE :("; 
    }

    // Definir la ruta completa donde se almacenará el archivo
    $ruta_destino = $ruta_carpeta . "/Ficha_evaluacion_coordinador.pdf";

    // Mover el archivo a la carpeta correspondiente
    if (move_uploaded_file($evaluacion['tmp_name'], $ruta_destino)) {
        // Preparar la consulta SQL para insertar en la base de datos  
        $sql = "INSERT INTO archivos (id_carpeta, nombre_archivo, fecha_subida, ruta) VALUES (?, ?, ?, ?)"; 
        
        $stmt = $conexion->prepare($sql); 

        // Enlazar parámetros  
        $stmt->bind_param("isss", $id_carpeta, $nombre_archivo, $fechaRegistro, $ruta_destino);     

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

$tipo_notificacion = 'Ficha de Evaluacion';
$mensaje = 'Subí la ficha de evaluacion';

$result3 = mysqli_query($conexion, "SELECT id_archivo FROM archivos WHERE (nombre_archivo = '$nombre_archivo' AND id_carpeta = '$id_carpeta')");  
$row3 = mysqli_fetch_assoc($result3);  
$id_archivo = $row3['id_archivo'];

// Preparar la consulta  
$stmt2 = mysqli_prepare($conexion, $query);  
if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
}  
mysqli_stmt_bind_param($stmt2, "iissi", $codigo_a, $id_archivo, $tipo_notificacion, $mensaje, $codigo); 
$ejecutar = mysqli_stmt_execute($stmt2);  

$query2 = "UPDATE paso_cp SET paso = 17 WHERE id_usuario = '$codigo_a'";
$stmt3 = mysqli_prepare($conexion, $query2);

if (!$stmt3) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt3); 

if ($ejecutar) {  
    echo '<script>  
            alert("La ficha de evaluacion fue enviada correctamente.");   
            window.location = "./../../ficha-evaluacion-alui.php?codigo=' . $codigo_a . '";
        </script>';  
} else {  
    echo 'Error al enviar examen. Inténtelo nuevamente';  
    echo "Error: " . mysqli_error($conexion);  
} 

mysqli_close($conexion);
?>