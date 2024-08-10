<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional']; 
$fechaRegistro = $_POST['fechaRegistro'];
$fechaRecord = $_POST['fechaRecord'];
$numLiquidacion = $_POST['numLiquidacion'];
$nombre_carpeta = "prueba";
$id_tipoSolicitud = 1;
$estado = "prueba";
$nt = 1111;

// Obtener el id_rol basado en el código  
$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno'];

$apertura_carpeta = "INSERT INTO carpeta_virtual (id_alumno, nombre_carpeta)
          VALUES (?, ?)";

$stmt_cp = mysqli_prepare($conexion, $apertura_carpeta);  
if (!$stmt_cp) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 

mysqli_stmt_bind_param($stmt_cp, "is", $id_alumno, $nombre_carpeta);  

$ejecutar_cp = mysqli_stmt_execute($stmt_cp);  

$result2 = mysqli_query($conexion, "SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");  
$row = mysqli_fetch_assoc($result2);  
$id_carpeta = $row['id_carpeta'];

// Preparar la consulta  
$query = "INSERT INTO solicitud (id_alumno, id_carpeta, id_tipoSolicitud, fecha_solicitud, estado, fecha_recordAcademico, numero_liquidacion, nt_solicitud)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $query);  
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 

// Establecer los tipos de datos y enlazar los parámetros  
mysqli_stmt_bind_param($stmt, "iiisssii", $id_alumno, $id_carpeta, $id_tipoSolicitud, $fechaRegistro, $estado, $fechaRecord, $numLiquidacion, $nt);  

// Ejecutar la consulta  
$ejecutar = mysqli_stmt_execute($stmt);  

$query2 = "UPDATE paso_cp SET paso = 3 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query2);

if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

if ($ejecutar and $ejecutar2 and $ejecutar_cp) {  

    $_SESSION['paso_cp'] = '3'; // Cambia esto según el div que desees mostrar  

    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}  

mysqli_close($conexion);
?>  
