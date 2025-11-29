<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];
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

if(strlen($dniRepresentante) <> 8){
    echo '  
        Número de DNI inválido';  
    exit(); 
}

if(strlen($celularRepresentante) <> 9){
    echo '  
        Número de teléfono inválido';  
    exit(); 
}

if(strlen($rucEmpresa) <> 11){
    echo '  
        Ingrese un número RUC valido';  
    exit(); 
}

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_empresa FROM empresa WHERE nombre_empresa = '$nombreEmpresa'");  
$row2 = mysqli_fetch_assoc($result2);
$id_empresa = $row2['id_empresa'];

// Obtener datos de prácticas
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_final = $_POST['fecha_final'] ?? null;
$area = $_POST['area_trabajo'] ?? null;

// Calcular horas y meses si se proporcionaron las fechas
$horas = null;
$meses = null;
if ($fecha_inicio && $fecha_final) {
    $inicio = new DateTime($fecha_inicio);
    $culminacion = new DateTime($fecha_final);
    $intervalo = $inicio->diff($culminacion);
    $meses = $intervalo->y * 12 + $intervalo->m; // Total de meses
    $horas = ($intervalo->days * 6) + $intervalo->h; // Total de horas (6 horas por día)
}

$query2 = "UPDATE empresa SET nombre_empresa = '$nombreEmpresa', ruc_empresa = '$rucEmpresa', departamento_empre = '$departamentoRepresentante',
           distrito_empre = '$DistritoEmpresa', provincia_empre = '$provinciaEmpresa', direccion_empre = '$direccionRepresentante', 
           representante = '$nombreRepresentante', dni_repre = '$dniRepresentante', celular_repre = '$celularRepresentante',
           email_repre = '$emailRepresentante', cargo_representante = '$cargoRepresentante'
           WHERE id_empresa = '$id_empresa';";

$stmt2 = mysqli_prepare($conexion, $query2);

if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2);

// Actualizar también los datos de prácticas si se proporcionaron
$ejecutar3 = true;
if ($fecha_inicio && $fecha_final && $area) {
    $query3 = "UPDATE practicas SET area_trabajo = ?, fecha_inicio = ?, fecha_final = ?, horas = ?, meses = ? 
               WHERE id_alumno = ? AND id_empresa = ?";
    $stmt3 = mysqli_prepare($conexion, $query3);
    
    if (!$stmt3) {  
        echo "Error en la preparación de la consulta de prácticas: " . mysqli_error($conexion);  
        exit();  
    }
    
    mysqli_stmt_bind_param($stmt3, "sssiii", $area, $fecha_inicio, $fecha_final, $horas, $meses, $id_alumno, $id_empresa);
    $ejecutar3 = mysqli_stmt_execute($stmt3);
    mysqli_stmt_close($stmt3);
}

if ($ejecutar2 && $ejecutar3) {    
    echo ' Datos modificados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>
