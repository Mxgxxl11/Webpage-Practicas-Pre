<?php
//CONSTANCIA DE CULMINACION
session_start();
include 'assets\controladores\bd.php'; // Asegúrate de que este archivo establece la conexión a la base de datos correctamente

// Este archivo es para generar la constancia de culminación de PPP
require_once 'phpoffice\vendor\autoload.php';
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('phpoffice\16_CONSTANCIA_PRACTICA-PRE.docx');

$codigo_alumno = $_GET['codigo'];
$ruta_alumno = $_GET['carpeta'];
$nombre_carpeta = $_GET['nombre_carpeta'];

// Consulta para traer todos los datos
$traer_datos = "SELECT CONCAT(u.nombre1,' ',u.nombre2,' ',u.apellido1,' ',u.apellido2) AS nombre_alumno, u.foto, e.escuela, al.nt, sol.numero_liquidacion AS recibo, emp.nombre_empresa AS empresa, prac.fecha_inicio, prac.fecha_final, prac.horas AS total_horas, cal.promedio_final AS calificacion 
FROM usuario u 
JOIN escuelas e ON e.id_escuela = u.id_escuela 
JOIN alumno al ON al.id_usuario = u.codigo 
JOIN solicitud sol ON sol.id_alumno = al.id_alumno 
JOIN practicas prac ON prac.id_alumno = al.id_alumno 
JOIN empresa emp ON emp.id_empresa = prac.id_empresa 
JOIN calificaciones cal ON cal.id_alumno = al.id_alumno 
WHERE u.codigo = '$codigo_alumno' LIMIT 1";

$ejecutar = mysqli_query($conexion, $traer_datos);

if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
    // Obtenemos los datos de la consulta
    $fila = mysqli_fetch_assoc($ejecutar);

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
    $templateProcessor->setImageValue('foto_alumno', $foto);
    $ruta_bd = './../carpetas_virtuales/' . $nombre_carpeta . '/CONSTANCIA-CULMINACION-' . $codigo_alumno . '.docx';
    // Guardar el documento modificado
    $pathToSave = $ruta_alumno . '/CONSTANCIA-CULMINACION-' . $codigo_alumno . '.docx'; //si algo no funciona cambiarle el / ACA
    $templateProcessor->saveAs($pathToSave);
    // Mover el archivo a la carpeta y registrar en la base de datos  
    if (file_exists($pathToSave)) {
        // Variables para la base de datos  
        $nombre_archivo = 'CONSTANCIA-CULMINACION-' . $codigo_alumno . '.docx';
        $nombre_bd = 'CONSTANCIA-CULMINACION';
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
    die("Error en la consulta SQL: " . mysqli_error($conexion));
}
