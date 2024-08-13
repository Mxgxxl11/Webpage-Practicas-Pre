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
$record_a = $_FILES['archivo2'];
$ficha_matricula = $_FILES['archivo3'];
$comprobante = $_FILES['archivo4'];
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

$nombre_carpeta_ofi = date('Y') . '_' . $id_carpeta . '-' . $apellidos; // este es el nombre que llevara la carpeta en el servidor

$update = "UPDATE carpeta_virtual SET nombre_carpeta = '$nombre_carpeta_ofi' WHERE id_carpeta = '$id_carpeta'";
$stmt_u = mysqli_prepare($conexion, $update);

if (!$stmt_u) {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    exit();
}
$ejecutar_u = mysqli_stmt_execute($stmt_u);

// Crear la carpeta para almacenar los archivos
$carpeta_destino = __DIR__ . '/../../assets/carpetas_virtuales/' . $nombre_carpeta_ofi . "/";
if (!file_exists($carpeta_destino)) {
    mkdir($carpeta_destino, 0777, true);
}

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

if ($fut['error'] === UPLOAD_ERR_OK && $ficha_empresa['error'] === UPLOAD_ERR_OK && $record_a['error'] === UPLOAD_ERR_OK && $ficha_matricula['error'] === UPLOAD_ERR_OK && $comprobante['error'] === UPLOAD_ERR_OK) {
    // Definir las rutas de destino para los archivos
    $ruta_relativa = 'assets/carpetas_virtuales/' . $nombre_carpeta_ofi . '/';
    $ruta_fut = $ruta_relativa . "FUT.pdf";
    $ruta_ficha_empresa = $ruta_relativa . "Datos_empresa.pdf";
    $ruta_record_a = $ruta_relativa . "Record_academico.pdf";
    $ruta_ficha_matricula = $ruta_relativa . "Ficha_matricula.pdf";
    $ruta_comprobante = $ruta_relativa . "Comprobante_pago.pdf";
    // Mover los archivos a las rutas definidas
    move_uploaded_file($fut['tmp_name'], __DIR__ . '/../../' . $ruta_fut);
    move_uploaded_file($ficha_empresa['tmp_name'], __DIR__ . '/../../' . $ruta_ficha_empresa);
    move_uploaded_file($record_a['tmp_name'], __DIR__ . '/../../' . $ruta_record_a);
    move_uploaded_file($ficha_matricula['tmp_name'], __DIR__ . '/../../' . $ruta_ficha_matricula);
    move_uploaded_file($comprobante['tmp_name'], __DIR__ . '/../../' . $ruta_comprobante);

    // Preparar la consulta SQL para insertar las rutas en la base de datos  
    $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, ruta) VALUES (?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
        exit();
    }

    // Ejecutar cada consulta por separado
    $nombre_archivo1 = "FUT";
    $stmt->bind_param("iss", $id_solicitud, $nombre_archivo1, $ruta_fut);
    $stmt->execute();

    $nombre_archivo2 = "Datos de empresa";
    $stmt->bind_param("iss", $id_solicitud, $nombre_archivo2, $ruta_ficha_empresa);
    $stmt->execute();

    $nombre_archivo3 = "Record academico";
    $stmt->bind_param("iss", $id_solicitud, $nombre_archivo3, $ruta_record_a);
    $stmt->execute();

    $nombre_archivo4 = "Ficha de matricula";
    $stmt->bind_param("iss", $id_solicitud, $nombre_archivo4, $ruta_ficha_matricula);
    $stmt->execute();

    $nombre_archivo5 = "Comprobante de pago";
    $stmt->bind_param("iss", $id_solicitud, $nombre_archivo5, $ruta_comprobante);
    $stmt->execute();

    // Cerrar el statement  
    $stmt->close();
} else {
    echo "Error al subir los archivos.";
}

if ($ejecutar and $ejecutar2 and $ejecutar_cp and $ejecutar_u) {
    $_SESSION['paso_cp'] = '3'; // Cambia esto según el div que desees mostrar  
    echo 'Datos almacenados exitosamente';
} else {
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';
    echo "Error: " . mysqli_error($conexion);
}

mysqli_close($conexion);
