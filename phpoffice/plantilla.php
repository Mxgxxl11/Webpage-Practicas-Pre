<?php
require_once 'vendor/autoload.php';

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('phpoffice\16_CONSTANCIA_PRACTICA-PRE.docx'); //16_CONSTANCIA_PRACTICA-PRE.docx

$nombre_archivo = "16_CONSTANCIA_PRACTICA-PRE";

$nombre_alumno = "LUIS SEBASTIAN LOYOLA VERA";
$codigo_alumno = "2022015357";
$escuela = "INFORMÁTICA";
$empresa = "IBM";
$fecha_inicio = "2024-01-03";
$fecha_final = "2024-05-03";
$total_horas = "780";
$calificacion = "20";

$fecha_actual = strftime('%d de %B del %Y');;
$nt = "04421-22";
$recibo = "6312493986 ";
$expediente = "002-2024-INFORMATICA";

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
$templateProcessor->setValue('expediente', $expediente);

$templateProcessor->setImageValue('foto_alumno', 'phpoffice\capibara fino.jpg');

$pathToSave = $nombre_archivo . $nombre_alumno . '.docx';
$templateProcessor->saveAs($pathToSave);
