<?php  
include 'bd.php'; 
session_start();  

$codigo = $_SESSION['codigo_institucional']; 
$informe3 = $_FILES['informe3'];
$fecha_subida = $_POST['fechaInforme3'];

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");  
$row = mysqli_fetch_assoc($result2);  
$id_carpeta = $row['id_carpeta'];

// Verifica si el archivo fue subido  
if ($informe3['error'] === UPLOAD_ERR_OK) {
    // Leer el contenido de los archivos  
    $contenido_informe3 = file_get_contents($informe3['tmp_name']);   

    // Preparar la consulta SQL para insertar en la base de datos  
    $sql = "INSERT INTO archivos (id_carpeta, nombre_archivo, fecha_subida, contenido_archivo) VALUES (?, ?, ?, ?)"; 
    
    $stmt = $conexion->prepare($sql); 

    $nombre_archivo = "3er informe";

    // Enlazar parámetros  
    $stmt->bind_param("issi", $id_carpeta, $nombre_archivo, $fecha_subida, $contenido_informe3);     

    // Ejecutar la consulta  
    if ($stmt->execute()) {  
        echo "Archivos almacenados correctamente en la base de datos.";  
    } else {  
        echo "Error al almacenar los archivos: " . $stmt->error;  
    }  

    // Cerrar el statement  
    $stmt->close();
} else {  
    echo "Error al subir los archivos.";  
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

    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>