<?php
session_start();
include 'assets\controladores\bd.php'; // Asegúrate de que este archivo establece la conexión a la base de datos correctamente

// Este archivo es para generar la constancia de culminación de PPP
require_once 'phpoffice\vendor\autoload.php';
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('phpoffice\Plantilla_Carta_Presentación.docx');

$codigo_alumno = $_GET['codigo'];
$ruta_alumno = $_GET['carpeta'];
$nombre_carpeta = $_GET['nombre_carpeta'];

// Consulta para traer todos los datos
$traer_datos = "SELECT u.codigo, CONCAT(u.nombre1,' ',u.nombre2,' ',u.apellido1,' ',u.apellido2) AS nombre_alumno, 
al.semestre,e.escuela,al.nt,car.nombre_carpeta, sol.fecha_solicitud, emp.representante, emp.nombre_empresa
FROM usuario u
JOIN alumno al ON al.id_usuario = u.codigo
JOIN escuelas e ON e.id_escuela = u.id_escuela
JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno
JOIN solicitud sol ON sol.id_alumno = al.id_alumno
JOIN practicas prac ON prac.id_alumno = al.id_alumno
JOIN empresa emp ON emp.id_empresa = prac.id_empresa
WHERE u.codigo = '$codigo_alumno' LIMIT 1";

$ejecutar = mysqli_query($conexion, $traer_datos);

if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
    // Obtenemos los datos de la consulta
    $fila = mysqli_fetch_assoc($ejecutar);

    // Asignamos los datos a variables
    $nombre_alumno = $fila['nombre_alumno'];
    $semestre = $fila['semestre'];
    $escuela = $fila['escuela'];
    $nt = $fila['nt'];
    $fecha_solicitud = $fila['fecha_solicitud'];
    $empresa = $fila['nombre_empresa'];
    $representante = $fila['representante'];

    //$fecha_actual = date("Y-m-d"); // Fecha actual en formato AAAA-MM-DD

    // Insertamos los valores en la plantilla de Word
    $templateProcessor->setValue('nombre_carpeta', $nombre_carpeta);
    $templateProcessor->setValue('fecha_solicitud', $fecha_solicitud);
    $templateProcessor->setValue('escuela', $escuela);
    $templateProcessor->setValue('empresa', $empresa);
    $templateProcessor->setValue('representante', $representante);
    $templateProcessor->setValue('nombre_alumno', $nombre_alumno);
    $templateProcessor->setValue('codigo', $codigo_alumno);
    $templateProcessor->setValue('ciclo', $semestre);
    $templateProcessor->setValue('nt', $nt);

    // Guardar el documento modificado
    $pathToSave = $ruta_alumno . '/CARTA_PRESENTACION-' . $codigo_alumno . '.docx'; //si algo no funciona cambiarle el / ACA
    $templateProcessor->saveAs($pathToSave);
    if (file_exists($pathToSave)) {
        echo '
        <script>
            alert("DOCUMENTO GENERADO CON ÉXITO");
            window.location = "carpeta_virtual.php"; 
        </script>
    ';
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
    
    //echo "No se encontraron datos para el alumno con código: $codigo_alumno.";
    /*<script>
            alert("No se encontraron datos suficientes para el alumno con código: ' . $codigo_alumno . '");
            window.location = "carpeta_virtual.php"; 
        </script>*/
}
