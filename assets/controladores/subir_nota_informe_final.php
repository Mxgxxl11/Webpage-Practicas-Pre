<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];
$codigo_a = $_POST['codigo_a'];
$calificacion_reporte = $_POST['calificacion_reporte'];

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo_a'");
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_docente FROM docente WHERE id_usuario = '$codigo'");
$row2 = mysqli_fetch_assoc($result2);
$id_docente = $row2['id_docente'];

$result3 = mysqli_query($conexion, "SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = $id_alumno");
$row3 = mysqli_fetch_assoc($result3);
$id_carpeta = $row3['id_carpeta'];

$result4 = mysqli_query($conexion, "SELECT id_archivo FROM archivos WHERE (nombre_archivo = 'Informe Final' AND id_carpeta = $id_carpeta)");
$row4 = mysqli_fetch_assoc($result4);
$id_archivo = $row4['id_archivo'];

$sql = "INSERT INTO calificaciones (id_archivo, id_alumno, id_docente, trabajo_final) VALUES (?, ?, ?, ?)"; 
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iiii", $id_archivo, $id_alumno, $id_docente, $calificacion_reporte);       
if ($stmt->execute()) {  
    echo "Archivo almacenado correctamente en la base de datos.";
} else {  
    echo "Error al almacenar el archivo: " . $stmt->error;  
}
$stmt->close();

$query = "UPDATE paso_cp SET paso = 11 WHERE id_usuario = '$codigo_a'";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {  
   echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
 $ejecutar = mysqli_stmt_execute($stmt); 

 if ($ejecutar) {  
    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>
