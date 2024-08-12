<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional']; 
$apellidos = $_SESSION['primer_apellido'] . '_' . $_SESSION['segundo_apellido'];
$fechaRegistro = $_POST['fechaRegistro'];
$fechaRecord = $_POST['fechaRecord'];
$numLiquidacion = $_POST['numLiquidacion'];
$fut = $_FILES['blob1'];  
$ficha_empresa = $_FILES['blob2']; 
$id_tipoSolicitud = 1;
$estado = "Iniciado";
$nombre_carpeta = "carpeta";
$nt = 0;

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

$nombre_carpeta_ofi = date('Y') . '_' . $id_carpeta . '-' . $apellidos;

$update = "UPDATE carpeta_virtual SET nombre_carpeta = '$nombre_carpeta_ofi' WHERE id_carpeta = '$id_carpeta'";
$stmt_u = mysqli_prepare($conexion, $update);

if (!$stmt_u) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar_u = mysqli_stmt_execute($stmt_u); 

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

$result3 = mysqli_query($conexion, "SELECT id_solicitud FROM solicitud WHERE id_alumno = '$id_alumno' AND id_tipoSolicitud = '$id_tipoSolicitud'");  
$row = mysqli_fetch_assoc($result3);  
$id_solicitud = $row['id_solicitud'];

if ($fut['error'] === UPLOAD_ERR_OK && $ficha_empresa['error'] === UPLOAD_ERR_OK) {  
    // Leer el contenido de los archivos  
    $contenido_fut = file_get_contents($fut['tmp_name']);  
    $contenido_ficha_empresa = file_get_contents($ficha_empresa['tmp_name']);  

    // Preparar la consulta SQL para insertar en la base de datos  
    $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";  
    
    $stmt = $conexion->prepare($sql);  
    $nombre_archivo = "FUT";
    // Enlazar parámetros  
    $stmt->bind_param("isi", $id_solicitud, $nombre_archivo, $contenido_fut);  

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

if ($ejecutar and $ejecutar2 and $ejecutar_cp and $ejecutar_u) {  

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
