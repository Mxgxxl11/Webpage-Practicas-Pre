<?php

session_start();
include 'assets\controladores\bd.php'; // Asegúrate de que este archivo establece la conexión a la base de datos correctamente

// Este archivo es para generar la constancia de culminación de PPP
require_once 'phpoffice\vendor\autoload.php';
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('phpoffice\Plantilla_Docente_encargado_ppp.docx');

$codigo_alumno = $_GET['codigo'];
$direccion_carpeta = "./assets/carpetas_virtuales/"; //me servira para la ruta relativa luego

// Consulta para traer todos los datos
$traer_datos = "SELECT al.id_alumno,
al.id_usuario,
CONCAT(u.nombre1,' ', u.nombre2,' ',u.apellido1,' ',u.apellido2) AS NOMBRE_COMPLETO,
u.correo,
u.celular,
e.escuela,
emp.nombre_empresa,
car.nombre_carpeta,
CONCAT(ud.nombre1,' ', ud.nombre2,' ',ud.apellido1,' ',ud.apellido2) AS NOMBRE_DOCENTE
FROM alumno al
JOIN usuario u ON u.codigo = al.id_usuario
JOIN escuelas e ON e.id_escuela = u.id_escuela
JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno
JOIN practicas p ON p.id_alumno = al.id_alumno
JOIN empresa emp ON emp.id_empresa = p.id_empresa
JOIN docente d ON d.id_docente = al.id_docente
JOIN usuario ud ON ud.codigo = d.id_usuario
Where al.id_usuario ='$codigo_alumno'";

$ejecutar = mysqli_query($conexion, $traer_datos);

if ($ejecutar && mysqli_num_rows($ejecutar) > 0) {
    // Obtenemos los datos de la consulta
    $fila = mysqli_fetch_assoc($ejecutar);

    // Asignamos los datos a variables
    $nombre_alumno = $fila['NOMBRE_COMPLETO'];
    $escuela = $fila['escuela'];
    $correo = $fila['correo'];
    $celular = $fila['celular'];
    $empresa = $fila['nombre_empresa'];
    $docente = $fila['NOMBRE_DOCENTE'];
    $nombre_carpeta = $fila['nombre_carpeta'];
    $fecha_actual = date("Y-m-d"); // Fecha actual en formato AAAA-MM-DD

    // Insertamos los valores en la plantilla de Word
    $templateProcessor->setValue('estudiante', $nombre_alumno);
    $templateProcessor->setValue('codigo', $codigo_alumno);
    $templateProcessor->setValue('escuela', $escuela);
    $templateProcessor->setValue('empresa', $empresa);
    $templateProcessor->setValue('correo', $correo);
    $templateProcessor->setValue('celular', $celular);
    $templateProcessor->setValue('docente_asignado', $docente);
    $templateProcessor->setValue('fecha_hoy', $fecha_actual);
    $templateProcessor->setValue('nombre_carpeta', $nombre_carpeta);

    //definiendo ruta relativa
    $ruta_alumno = $direccion_carpeta . $nombre_carpeta;
    // Guardar el documento modificado
    $pathToSave = $ruta_alumno . '/OFICIO-DOCENTE-ASIGNADO-' . $codigo_alumno . '.docx'; //si algo no funciona cambiarle el / ACA
    $templateProcessor->saveAs($pathToSave);
    if (file_exists($pathToSave)) {
        echo '
        <script>
            alert("DOCUMENTO GENERADO CON ÉXITO");
            window.location = "asignar_docente.php"; 
        </script>
    ';
    } else {
        echo '
        <script>
            alert("DOCUMENTO NO GENERADO. PROBLEMAS AL SUBIR GENERAR ARCHIVO");
            window.location = "asignar_docente.php"; 
        </script>
    ';
    }
} else {
    echo '
        <script>
            alert("No se encontraron datos suficientes para generar oficio de asignación de docente al alumno con código: ' . $codigo_alumno . '");
            window.location = "asignar_docente.php"; 
        </script>
    ';
    //echo "No se encontraron datos para el alumno con código: $codigo_alumno.";
}
