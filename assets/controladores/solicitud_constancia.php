<?php  
include 'bd.php'; 
date_default_timezone_set('America/Lima');
session_start();  
$codigo = $_SESSION['codigo_institucional']; 
$apellidos = $_SESSION['primer_apellido'] . '_' . $_SESSION['segundo_apellido'];
$FechaSolicitud = $_POST['Fechaconstancia'];
$fechaRecord = null;
$NumeroLiquidacion = $_POST['NumeroLiquidacion'];
$fut = $_FILES['blob1']; 
$fotos_carnet = $_FILES['Fotoscarnet'];
$cons_empresa = $_FILES['ConsEmpresa'];
$comprobante = $_FILES['Comprobante'];
$id_tipoSolicitud = 3;
$estado = "Solicitado";
$fechaHoy = date('Y-m-d');

if($FechaSolicitud !== $fechaHoy){
    echo '  
        La fecha de solicitud debe ser la fecha de hoy.';  
    exit(); 
}

// Obtener el id_rol basado en el código  
$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");  
$row = mysqli_fetch_assoc($result2);  
$id_carpeta = $row['id_carpeta'];

$result3 = mysqli_query($conexion, "SELECT nt FROM alumno WHERE id_alumno = '$id_alumno'");  
$row = mysqli_fetch_assoc($result3);  
$nt = $row['nt'];

// Preparar la consulta  
$query = "INSERT INTO solicitud (id_alumno, id_carpeta, id_tipoSolicitud, fecha_solicitud, estado, fecha_recordAcademico, numero_liquidacion, nt_solicitud)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $query);  
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 

// Establecer los tipos de datos y enlazar los parámetros  
mysqli_stmt_bind_param($stmt, "iiisssii", $id_alumno, $id_carpeta, $id_tipoSolicitud, $FechaSolicitud, $estado, $fechaRecord, $NumeroLiquidacion, $nt);  

// Ejecutar la consulta  
$ejecutar = mysqli_stmt_execute($stmt);  

$query2 = "UPDATE paso_cp SET paso = 19 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query2);

if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

$result4 = mysqli_query($conexion, "SELECT id_solicitud FROM solicitud WHERE id_alumno = '$id_alumno' AND id_tipoSolicitud = '$id_tipoSolicitud' AND numero_liquidacion = '$NumeroLiquidacion'");    
$row = mysqli_fetch_assoc($result4);  
$id_solicitud = $row['id_solicitud'];

if ($fut['error'] === UPLOAD_ERR_OK && $fotos_carnet['error'] === UPLOAD_ERR_OK && $cons_empresa['error'] === UPLOAD_ERR_OK && $comprobante['error'] === UPLOAD_ERR_OK && $comprobante['error'] === UPLOAD_ERR_OK) {  
    // Leer el contenido de los archivos  
    $contenido_fut = file_get_contents($fut['tmp_name']);  
    $contenido_fotos = file_get_contents($fotos_carnet['tmp_name']);
    $contenido_cons_empresa = file_get_contents($cons_empresa['tmp_name']);  
    $contenido_comprobante = file_get_contents($comprobante['tmp_name']); 

    // Preparar la consulta SQL para insertar en la base de datos  
    $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";  
    $sql2 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";
    $sql3 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";  
    $sql4 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);  
    $stmt2 = $conexion->prepare($sql2);
    $stmt3 = $conexion->prepare($sql3);  
    $stmt4 = $conexion->prepare($sql4);

    $nombre_archivo1 = "FUT";
    $nombre_archivo2 = "Fotos Carnet";
    $nombre_archivo3 = "Constancia de la Empresa";
    $nombre_archivo4 = "Comprobante de pago";

    // Enlazar parámetros  
    $stmt->bind_param("isi", $id_solicitud, $nombre_archivo1, $contenido_fut);  
    $stmt2->bind_param("isi", $id_solicitud, $nombre_archivo2, $contenido_fotos);
    $stmt3->bind_param("isi", $id_solicitud, $nombre_archivo3, $contenido_cons_empresa);  
    $stmt4->bind_param("isi", $id_solicitud, $nombre_archivo4, $contenido_comprobante);      

    // Ejecutar la consulta  
    if ($stmt->execute() and $stmt2->execute() and $stmt3->execute() and $stmt4->execute()){  
        echo "Archivos almacenados correctamente en la base de datos.";  
    } else {  
        echo "Error al almacenar los archivos: " . $stmt->error;  
    }  

    // Cerrar el statement  
    $stmt->close(); 
    $stmt2->close();
    $stmt3->close(); 
    $stmt4->close();
} else {  
    echo "Error al subir los archivos.";  
}  

if ($ejecutar and $ejecutar2) {  

    // $_SESSION['paso_cp'] = '3'; 
    echo ' Datos almacenados exitosamente ';

} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}  

mysqli_close($conexion);
?>  
