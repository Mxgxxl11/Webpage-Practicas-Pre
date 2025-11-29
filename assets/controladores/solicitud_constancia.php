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

if ($fut['error'] === UPLOAD_ERR_OK && $fotos_carnet['error'] === UPLOAD_ERR_OK && $cons_empresa['error'] === UPLOAD_ERR_OK && $comprobante['error'] === UPLOAD_ERR_OK) {  
    // Definir la carpeta de destino
    $carpeta_destino = "../documentos_solicitud/";
    
    // Crear la carpeta si no existe
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }
    
    // Generar nombres únicos para los archivos
    $extension_fut = pathinfo($fut['name'], PATHINFO_EXTENSION);
    $extension_fotos = pathinfo($fotos_carnet['name'], PATHINFO_EXTENSION);
    $extension_cons = pathinfo($cons_empresa['name'], PATHINFO_EXTENSION);
    $extension_comp = pathinfo($comprobante['name'], PATHINFO_EXTENSION);
    
    // Si no hay extensión, usar 'pdf' por defecto
    $extension_fut = !empty($extension_fut) ? $extension_fut : 'pdf';
    $extension_fotos = !empty($extension_fotos) ? $extension_fotos : 'pdf';
    $extension_cons = !empty($extension_cons) ? $extension_cons : 'pdf';
    $extension_comp = !empty($extension_comp) ? $extension_comp : 'pdf';
    
    $nombre_fut = $codigo . "_" . $apellidos . "_FUT." . $extension_fut;
    $nombre_fotos = $codigo . "_" . $apellidos . "_FotosCarnet." . $extension_fotos;
    $nombre_cons = $codigo . "_" . $apellidos . "_ConstanciaEmpresa." . $extension_cons;
    $nombre_comp = $codigo . "_" . $apellidos . "_Comprobante." . $extension_comp;
    
    // Rutas completas de destino
    $ruta_fut = $carpeta_destino . $nombre_fut;
    $ruta_fotos = $carpeta_destino . $nombre_fotos;
    $ruta_cons = $carpeta_destino . $nombre_cons;
    $ruta_comp = $carpeta_destino . $nombre_comp;
    
    // Mover archivos a la carpeta de destino
    $mover_fut = move_uploaded_file($fut['tmp_name'], $ruta_fut);
    $mover_fotos = move_uploaded_file($fotos_carnet['tmp_name'], $ruta_fotos);
    $mover_cons = move_uploaded_file($cons_empresa['tmp_name'], $ruta_cons);
    $mover_comp = move_uploaded_file($comprobante['tmp_name'], $ruta_comp);
    
    if ($mover_fut && $mover_fotos && $mover_cons && $mover_comp) {
        // Preparar la consulta SQL para insertar en la base de datos  
        $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, ruta) VALUES (?, ?, ?)";  
        
        $stmt = $conexion->prepare($sql);
        
        $nombre_archivo1 = "FUT";
        $nombre_archivo2 = "Fotos Carnet";
        $nombre_archivo3 = "Constancia de la Empresa";
        $nombre_archivo4 = "Comprobante de pago";
        
        // Enlazar parámetros y ejecutar para cada archivo
        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo1, $ruta_fut);  
        $stmt->execute();
        
        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo2, $ruta_fotos);
        $stmt->execute();
        
        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo3, $ruta_cons);  
        $stmt->execute();
        
        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo4, $ruta_comp);      
        $stmt->execute();
        
        // Cerrar el statement  
        $stmt->close();
        
        if ($ejecutar && $ejecutar2) {  
            echo 'Datos almacenados exitosamente';
        } else {  
            echo 'Error al almacenar los datos en la solicitud: ' . mysqli_error($conexion);  
        }
    } else {  
        echo "Error al mover los archivos al servidor. Verifique los permisos de la carpeta.";  
    }
} else {  
    echo "Error al subir los archivos. Verifique que todos los archivos se hayan cargado correctamente.";  
}  

mysqli_close($conexion);
?>
