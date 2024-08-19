<?php
include 'bd.php';
session_start();
date_default_timezone_set('America/Lima');
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
$fechaHoy = date('Y-m-d');

if($fechaRegistro !== $fechaHoy){
    echo '  
        La fecha de registro debe ser la fecha de hoy.';  
    exit(); 
}

if($fechaRecord > $fechaHoy){
    echo '  
        La fecha del record académico debe ser anterior a la fecha de hoy.';  
    exit(); 
}

if(strlen($numLiquidacion) !== 10){
    echo '  
        Número de liquidación inválido.';  
    exit(); 
}

// Verificar que todos los archivos requeridos estén presentes y se hayan subido correctamente
if ($fut['error'] !== UPLOAD_ERR_OK || $ficha_empresa['error'] !== UPLOAD_ERR_OK || $record_a['error'] !== UPLOAD_ERR_OK || $ficha_matricula['error'] !== UPLOAD_ERR_OK || $comprobante['error'] !== UPLOAD_ERR_OK) {
    echo "Error: Todos los archivos deben ser subidos.";
    exit();
}

// Obtener el id_alumno basado en el código  
$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

// Insertar en carpeta_virtual
$apertura_carpeta = "INSERT INTO carpeta_virtual (id_alumno, nombre_carpeta) VALUES (?, ?)";
$stmt_cp = mysqli_prepare($conexion, $apertura_carpeta);
if (!$stmt_cp) {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    exit();
}
mysqli_stmt_bind_param($stmt_cp, "is", $id_alumno, $nombre_carpeta);
$ejecutar_cp = mysqli_stmt_execute($stmt_cp);

// Obtener id_carpeta y actualizar nombre_carpeta
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

// Crear la carpeta en el servidor
$carpeta_destino = __DIR__ . '/../../assets/carpetas_virtuales/' . $nombre_carpeta_ofi . "/";
if (!file_exists($carpeta_destino)) {
    mkdir($carpeta_destino, 0777, true);
}

// Insertar en solicitud
$query = "INSERT INTO solicitud (id_alumno, id_carpeta, id_tipoSolicitud, fecha_solicitud, estado, fecha_recordAcademico, numero_liquidacion, nt_solicitud)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conexion, $query);
if (!$stmt) {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    exit();
}
mysqli_stmt_bind_param($stmt, "iiisssii", $id_alumno, $id_carpeta, $id_tipoSolicitud, $fechaRegistro, $estado, $fechaRecord, $numLiquidacion, $nt);
$ejecutar = mysqli_stmt_execute($stmt);

// Actualizar paso_cp
$query2 = "UPDATE paso_cp SET paso = 3 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    exit();
}
$ejecutar2 = mysqli_stmt_execute($stmt2);

// Obtener id_solicitud
$result3 = mysqli_query($conexion, "SELECT id_solicitud FROM solicitud WHERE id_alumno = '$id_alumno' AND id_tipoSolicitud = '$id_tipoSolicitud'");
$row = mysqli_fetch_assoc($result3);
$id_solicitud = $row['id_solicitud'];

// Subir archivos y guardar rutas
$ruta_relativa = 'assets/carpetas_virtuales/' . $nombre_carpeta_ofi . '/';
$ruta_fut = $ruta_relativa . "FUT_carta_presentacion.pdf";
$ruta_ficha_empresa = $ruta_relativa . "Datos_empresa.pdf";
$ruta_record_a = $ruta_relativa . "Record_academico.pdf";
$ruta_ficha_matricula = $ruta_relativa . "Ficha_matricula.pdf";
$ruta_comprobante = $ruta_relativa . "Comprobante_pago.pdf";

if (
    move_uploaded_file($fut['tmp_name'], __DIR__ . '/../../' . $ruta_fut) &&
    move_uploaded_file($ficha_empresa['tmp_name'], __DIR__ . '/../../' . $ruta_ficha_empresa) &&
    move_uploaded_file($record_a['tmp_name'], __DIR__ . '/../../' . $ruta_record_a) &&
    move_uploaded_file($ficha_matricula['tmp_name'], __DIR__ . '/../../' . $ruta_ficha_matricula) &&
    move_uploaded_file($comprobante['tmp_name'], __DIR__ . '/../../' . $ruta_comprobante)
) {
    // Inserción de rutas en la base de datos
    $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, ruta) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $documentos = [
            ["FUT carta de presentacion", $ruta_fut],
            ["Datos de empresa", $ruta_ficha_empresa],
            ["Record academico", $ruta_record_a],
            ["Ficha de matricula", $ruta_ficha_matricula],
            ["Comprobante de pago", $ruta_comprobante]
        ];

        foreach ($documentos as $doc) {
            $stmt->bind_param("iss", $id_solicitud, $doc[0], $doc[1]);
            if (!$stmt->execute()) {
                echo "Error al insertar el documento: " . $doc[0];
                exit();
            }
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
        exit();
    }
} else {
    echo "Error al mover los archivos a las rutas definidas.";
    exit();
}

if ($ejecutar && $ejecutar2 && $ejecutar_cp && $ejecutar_u) {
    $_SESSION['paso_cp'] = '3'; // Cambia esto según el div que desees mostrar  
    echo 'Datos almacenados exitosamente';
} else {
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';
    echo "Error: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>