<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno'];

$nombreEmpresa = $_POST['nombreEmpresa'];
$rucEmpresa = $_POST['rucEmpresa'];
$celularRepresentante = $_POST['celularRepresentante'];
$emailRepresentante = $_POST['emailRepresentante'];
$provinciaEmpresa = $_POST['provinciaEmpresa'];
$departamentoRepresentante = $_POST['departamentoRepresentante'];
$DistritoEmpresa = $_POST['DistritoEmpresa'];
$nombreRepresentante = $_POST['nombreRepresentante'];
$cargoRepresentante = $_POST['cargoRepresentante'];
$dniRepresentante = $_POST['dniRepresentante'];
$direccionRepresentante = $_POST['direccionRepresentante'];

// Preparar la consulta SQL para insertar los datos
$query = "INSERT INTO empresa (nombre_empresa, ruc_empresa, celular_repre, email_repre, provincia_empre, distrito_empre, representante, dni_repre, direccion_empre, departamento_empre, cargo_representante) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Preparar la consulta
$stmt = mysqli_prepare($conexion, $query);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . mysqli_error($conexion));
}

// Enlazar los parámetros
mysqli_stmt_bind_param($stmt, "siissssisss", $nombreEmpresa, $rucEmpresa, $celularRepresentante, $emailRepresentante, $provinciaEmpresa, $DistritoEmpresa, $nombreRepresentante, $dniRepresentante, $direccionRepresentante, $departamentoRepresentante, $cargoRepresentante);

$query2 = "INSERT INTO practicas (id_alumno, id_empresa, area_trabajo, fecha_inicio, fecha_final, horas, meses) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$result2 = mysqli_query($conexion, "SELECT id_empresa FROM empresa WHERE nombre_empresa = '$nombreEmpresa'");  
$row2 = mysqli_fetch_assoc($result2);  
$id_empresa = $row2['id_empresa'];

$fecha_inicio = null;
$fecha_final = null;
$horas = null;
$meses = null;
$area = null;

// Preparar la consulta
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {
    die("Error en la preparación de la consulta: " . mysqli_error($conexion));
}

// Enlazar los parámetros
mysqli_stmt_bind_param($stmt2, "iisssii", $id_alumno, $id_empresa, $area, $fecha_inicio, $fecha_final, $horas, $meses);

// Ejecutar la consulta
if (mysqli_stmt_execute($stmt) and mysqli_stmt_execute($stmt2)) {
    echo "Datos guardados exitosamente.";
} else {
    echo "Error: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
