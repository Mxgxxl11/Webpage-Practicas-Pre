<?php
//CONSTANCIA DE CULMINACION
session_start();
include 'assets/controladores/bd.php'; // Asegúrate de que este archivo establece la conexión a la base de datos correctamente

// Este archivo es para generar la constancia de culminación de PPP
require_once 'phpoffice/vendor/autoload.php';
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('phpoffice/16_CONSTANCIA_PRACTICA-PRE.docx');

$codigo_alumno = $_GET['codigo'];
$ruta_alumno = $_GET['carpeta'];
$nombre_carpeta = $_GET['nombre_carpeta'];

// Consulta para traer todos los datos
$traer_datos = "SELECT CONCAT(u.nombre1,' ',u.nombre2,' ',u.apellido1,' ',u.apellido2) AS nombre_alumno, u.foto, e.escuela, al.nt, sol.numero_liquidacion AS recibo, emp.nombre_empresa AS empresa, prac.fecha_inicio, prac.fecha_final, prac.horas AS total_horas, cal.promedio_final AS calificacion 
FROM usuario u 
LEFT JOIN escuelas e ON e.id_escuela = u.id_escuela 
LEFT JOIN alumno al ON al.id_usuario = u.codigo 
LEFT JOIN solicitud sol ON sol.id_alumno = al.id_alumno AND sol.id_tipoSolicitud = 3
LEFT JOIN practicas prac ON prac.id_alumno = al.id_alumno 
LEFT JOIN empresa emp ON emp.id_empresa = prac.id_empresa 
LEFT JOIN calificaciones cal ON cal.id_alumno = al.id_alumno 
WHERE u.codigo = '$codigo_alumno' 
ORDER BY prac.fecha_inicio DESC
LIMIT 1";

$ejecutar = mysqli_query($conexion, $traer_datos);

if (!$ejecutar) {
    die("Error al ejecutar la consulta: " . mysqli_error($conexion) . "<br>Consulta: " . $traer_datos);
}

if (mysqli_num_rows($ejecutar) > 0) {
    // Obtenemos los datos de la consulta
    $fila = mysqli_fetch_assoc($ejecutar);
    
    // Verificar qué datos faltan
    $datos_faltantes = [];
    if (empty($fila['nombre_alumno'])) $datos_faltantes[] = 'Nombre del alumno';
    if (empty($fila['escuela'])) $datos_faltantes[] = 'Escuela';
    if (empty($fila['nt'])) $datos_faltantes[] = 'NT (Número de trámite)';
    if (empty($fila['recibo'])) $datos_faltantes[] = 'Número de liquidación (solicitud de constancia no registrada)';
    if (empty($fila['empresa'])) $datos_faltantes[] = 'Nombre de la empresa (práctica no registrada)';
    if (empty($fila['fecha_inicio'])) $datos_faltantes[] = 'Fecha de inicio de práctica';
    if (empty($fila['fecha_final'])) $datos_faltantes[] = 'Fecha final de práctica';
    if (empty($fila['total_horas'])) $datos_faltantes[] = 'Total de horas';
    if (empty($fila['calificacion'])) $datos_faltantes[] = 'Calificación (promedio final no registrado)';
    
    if (!empty($datos_faltantes)) {
        echo "<h3>No se puede generar la constancia. Faltan los siguientes datos:</h3>";
        echo "<ul>";
        foreach ($datos_faltantes as $dato) {
            echo "<li>" . htmlspecialchars($dato) . "</li>";
        }
        echo "</ul>";
        echo "<br><a href='carpeta_virtual.php'>Volver a carpeta virtual</a>";
        exit();
    }

    // Asignamos los datos a variables
    $nombre_alumno = $fila['nombre_alumno'];
    $foto = $fila['foto'];
    $escuela = $fila['escuela'];
    $nt = $fila['nt'];
    $recibo = $fila['recibo'];
    $empresa = $fila['empresa'];
    $fecha_inicio = $fila['fecha_inicio'];
    $fecha_final = $fila['fecha_final'];
    $total_horas = $fila['total_horas'];
    $calificacion = $fila['calificacion'];
    $fecha_actual = date("Y-m-d"); // Fecha actual en formato AAAA-MM-DD

    // Insertamos los valores en la plantilla de Word
    $templateProcessor->setValue('nombre_alumno', $nombre_alumno);
    $templateProcessor->setValue('codigo_alumno', $codigo_alumno);
    $templateProcessor->setValue('escuela', $escuela);
    $templateProcessor->setValue('empresa', $empresa);
    $templateProcessor->setValue('fecha_inicio', $fecha_inicio);
    $templateProcessor->setValue('fecha_final', $fecha_final);
    $templateProcessor->setValue('total_horas', $total_horas);
    $templateProcessor->setValue('calificacion', $calificacion);
    $templateProcessor->setValue('fecha_actual', $fecha_actual);
    $templateProcessor->setValue('nt', $nt);
    $templateProcessor->setValue('recibo', $recibo);
    $templateProcessor->setValue('expediente', $nombre_carpeta);
    
    // Validar y establecer la foto del alumno
    if (!empty($foto) && file_exists($foto)) {
        $templateProcessor->setImageValue('foto_alumno', $foto);
    }
    
    $ruta_bd = './../carpetas_virtuales/' . $nombre_carpeta . '/CONSTANCIA-CULMINACION-' . $codigo_alumno . '.docx';
    // Guardar el documento modificado
    $pathToSave = $ruta_alumno . '/CONSTANCIA-CULMINACION-' . $codigo_alumno . '.docx';
    // Normalizar la ruta para el sistema operativo actual
    $pathToSave = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $pathToSave);
    $templateProcessor->saveAs($pathToSave);
    // Mover el archivo a la carpeta y registrar en la base de datos  
    if (file_exists($pathToSave)) {
        // Variables para la base de datos  
        $nombre_archivo = 'CONSTANCIA-CULMINACION-' . $codigo_alumno . '.docx';
        $nombre_bd = 'Constancia de culminacion';
        $fechaExam = date("Y-m-d"); // Fecha actual  
        $traer_id_carpeta = "SELECT id_carpeta FROM carpeta_virtual WHERE nombre_carpeta = '$nombre_carpeta'";
        $exe = mysqli_query($conexion, $traer_id_carpeta);
        $row = mysqli_fetch_assoc($exe);
        $id_carpeta = $row['id_carpeta'];


        // Prepare the SQL query to insert into the database  
        $sql = "INSERT INTO archivos (id_carpeta, nombre_archivo, fecha_subida, ruta) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        // Enlazar parámetros  
        $stmt->bind_param("isss", $id_carpeta, $nombre_bd, $fechaExam, $ruta_bd);

        // Ejecutar la consulta  
        if ($stmt->execute()) {
            echo '  
            <script>  
                alert("DOCUMENTO GENERADO Y ALMACENADO EN LA BASE DE DATOS CON ÉXITO");  
                window.location = "carpeta_virtual.php";   
            </script>  
            ';
        } else {
            echo '  
            <script>  
                alert("DOCUMENTO GENERADO PERO ERROR AL ALMACENAR EN LA BASE DE DATOS: ' . $stmt->error . '");  
                window.location = "carpeta_virtual.php";   
            </script>  
            ';
        }

        // Cerrar el statement  
        $stmt->close();
    } else {
        echo '  
        <script>  
            alert("DOCUMENTO NO GENERADO. PROBLEMAS AL SUBIR GENERAR ARCHIVO");  
            window.location = "carpeta_virtual.php";   
        </script>  
        ';
    }
} else {
    echo "No se encontraron datos para el código: " . htmlspecialchars($codigo_alumno) . "<br>";
    echo "Verifica que:<br>";
    echo "- El alumno existe en la tabla 'usuario'<br>";
    echo "- Tiene una solicitud registrada<br>";
    echo "- Tiene prácticas registradas<br>";
    echo "- Tiene una empresa asignada<br>";
    echo "- Tiene calificaciones registradas<br>";
    echo "<br>Consulta ejecutada:<br><pre>" . htmlspecialchars($traer_datos) . "</pre>";
}
