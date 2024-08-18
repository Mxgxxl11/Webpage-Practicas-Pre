<?php  
include 'bd.php'; 
session_start();  
date_default_timezone_set('America/Lima');
define('RUTA_DEF_CARPETA', './../carpetas_virtuales/'); 

$codigo = $_SESSION['codigo_institucional']; 
$apellidos = trim($_SESSION['primer_apellido'] . '_' . $_SESSION['segundo_apellido']); // Eliminar espacios en blanco
$fechaRegistroS = $_POST['fechaRegistroS'];
$fechaRecord = $_POST['fechaRecord'];
$fut = $_FILES['blob1'];  
$ficha_empresa = $_FILES['blob2']; 
$record_a = $_FILES['RecordAca'];
$CartaRec = $_FILES['CartaRec'];
$CartaAceptacion = $_FILES['CartaAceptacion'];
$id_tipoSolicitud = 2;
$estado = "Iniciado";
$numLiquidacion = 0;
$nt = 0;
$fechaHoy = date('Y-m-d');

if($fechaRegistroS !== $fechaHoy){
    echo '  
        La fecha de registro debe ser la fecha de hoy.';  
    exit(); 
}

if($fechaRecord > $fechaHoy){
    echo '  
        La fecha del record acádemico debe ser anterior a la fecha de hoy.';  
    exit(); 
}

// Obtener el id_rol basado en el código  
$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno']; 

$result2 = mysqli_query($conexion, "SELECT id_carpeta, nombre_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");  
$row2 = mysqli_fetch_assoc($result2);  
$id_carpeta = $row2['id_carpeta'];
$nombre_carpeta = trim($row2['nombre_carpeta']); // Eliminar espacios en blanco

// Crear la ruta completa de la carpeta del alumno
$ruta_carpeta = RUTA_DEF_CARPETA . $nombre_carpeta;

// Verificar si la carpeta existe; si no, crearla
if (!file_exists($ruta_carpeta)) {
    mkdir($ruta_carpeta, 0777, true); // Crear la carpeta con permisos completos
}

$query = "INSERT INTO solicitud (id_alumno, id_carpeta, id_tipoSolicitud, fecha_solicitud, estado, fecha_recordAcademico, numero_liquidacion, nt_solicitud)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $query);  
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 

// Establecer los tipos de datos y enlazar los parámetros  
mysqli_stmt_bind_param($stmt, "iiisssii", $id_alumno, $id_carpeta, $id_tipoSolicitud, $fechaRegistroS, $estado, $fechaRecord, $numLiquidacion, $nt);  

// Ejecutar la consulta  
$ejecutar = mysqli_stmt_execute($stmt);  

$query2 = "UPDATE paso_cp SET paso = 5 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query2);

if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

$result3 = mysqli_query($conexion, "SELECT id_solicitud FROM solicitud WHERE id_alumno = '$id_alumno' AND id_tipoSolicitud = '$id_tipoSolicitud'");  
$row3 = mysqli_fetch_assoc($result3);  
$id_solicitud = $row3['id_solicitud'];

if ($fut['error'] === UPLOAD_ERR_OK && $ficha_empresa['error'] === UPLOAD_ERR_OK && $record_a['error'] === UPLOAD_ERR_OK && $CartaRec['error'] === UPLOAD_ERR_OK && $CartaAceptacion['error'] === UPLOAD_ERR_OK) {  
    // Definir las rutas completas donde se almacenarán los archivos
    $ruta_fut = $ruta_carpeta . "/FUT_apertura_carpeta.pdf";
    $ruta_ficha_empresa = $ruta_carpeta . "/Ficha_de_Inscripcion.pdf";
    $ruta_record_a = $ruta_carpeta . "/Record_Academico_Actualizado.pdf";
    $ruta_carta_rec = $ruta_carpeta . "/Carta_de_Presentacion.pdf";
    $ruta_carta_acep = $ruta_carpeta . "/Carta_de_Aceptacion.pdf";

    // Mover los archivos a la carpeta correspondiente
    $mover_fut = move_uploaded_file($fut['tmp_name'], $ruta_fut);
    $mover_ficha_empresa = move_uploaded_file($ficha_empresa['tmp_name'], $ruta_ficha_empresa);
    $mover_record_a = move_uploaded_file($record_a['tmp_name'], $ruta_record_a);
    $mover_carta_rec = move_uploaded_file($CartaRec['tmp_name'], $ruta_carta_rec);
    $mover_carta_acep = move_uploaded_file($CartaAceptacion['tmp_name'], $ruta_carta_acep);

    if ($mover_fut && $mover_ficha_empresa && $mover_record_a && $mover_carta_rec && $mover_carta_acep) {
        // Preparar la consulta SQL para insertar las rutas en la base de datos  
        $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, ruta) VALUES (?, ?, ?)";  
        
        $stmt = $conexion->prepare($sql);  

        $nombre_archivo1 = "FUT de Apertura de Carpeta";
        $nombre_archivo2 = "Ficha de Inscripción";
        $nombre_archivo3 = "Record Academico Actualizado";
        $nombre_archivo4 = "Carta de Presentacion";
        $nombre_archivo5 = "Carta de Aceptación";

        // Enlazar parámetros y ejecutar la consulta para cada archivo
        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo1, $ruta_fut);  
        $stmt->execute();

        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo2, $ruta_ficha_empresa);
        $stmt->execute();

        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo3, $ruta_record_a);  
        $stmt->execute();

        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo4, $ruta_carta_rec);  
        $stmt->execute();

        $stmt->bind_param("iss", $id_solicitud, $nombre_archivo5, $ruta_carta_acep);  
        $stmt->execute();

        echo "Archivos almacenados correctamente en la base de datos.";  

        // Cerrar el statement  
        $stmt->close(); 
    } else {
        echo "Error al mover los archivos a la carpeta destino.";
    }
} else {  
    echo "Error al subir los archivos.";  
}  

if ($ejecutar && $ejecutar2) {  
    $_SESSION['paso_cp'] = '5'; // Cambia esto según el div que desees mostrar  
    echo 'Datos almacenados exitosamente';  
} else {  
    echo 'alert("Error al almacenar los datos. Inténtelo nuevamente.");';  
    echo "Error: " . mysqli_error($conexion);  
}  

mysqli_close($conexion);
?>
