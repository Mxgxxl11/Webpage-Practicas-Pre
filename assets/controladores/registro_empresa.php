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

if(strlen($dniRepresentante) <> 8){
    echo '  
        <script>  
            alert("Número de DNI inválido.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit(); 
}

if(strlen($celularRepresentante) <> 9){
    echo '  
        <script>  
            alert("Número de teléfono inválido.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit(); 
}

if(strlen($rucEmpresa) <> 11){
    echo '  
        <script>  
            alert("Número de RUC inválido.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit(); 
}

// Preparar la consulta SQL para insertar los datos en empresa
$query = "INSERT INTO empresa (nombre_empresa, ruc_empresa, celular_repre, email_repre, provincia_empre, distrito_empre, representante, dni_repre, direccion_empre, departamento_empre, cargo_representante) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $query);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . mysqli_error($conexion));
}

// Enlazar los parámetros
mysqli_stmt_bind_param($stmt, "siissssisss", $nombreEmpresa, $rucEmpresa, $celularRepresentante, $emailRepresentante, $provinciaEmpresa, $DistritoEmpresa, $nombreRepresentante, $dniRepresentante, $direccionRepresentante, $departamentoRepresentante, $cargoRepresentante);

// Ejecutar la consulta de inserción en empresa
if (!mysqli_stmt_execute($stmt)) {
    die("Error al guardar los datos de la empresa: " . mysqli_error($conexion));
}

// Obtener el id_empresa recién insertado
$id_empresa = mysqli_insert_id($conexion);

// Asignar valores a las variables de practicas
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_final = $_POST['fecha_final'] ?? null;
$horas = $_POST['horas'] ?? null;
$meses = $_POST['meses'] ?? null;
$area = $_POST['area_trabajo'] ?? null;

// Preparar la consulta para insertar en practicas
$query2 = "INSERT INTO practicas (id_alumno, id_empresa, area_trabajo, fecha_inicio, fecha_final, horas, meses) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {
    die("Error en la preparación de la consulta: " . mysqli_error($conexion));
}

// Enlazar los parámetros
mysqli_stmt_bind_param($stmt2, "iisssii", $id_alumno, $id_empresa, $area, $fecha_inicio, $fecha_final, $horas, $meses);

// Ejecutar la consulta de inserción en practicas
if (mysqli_stmt_execute($stmt2)) {
    echo "Datos guardados exitosamente.";
} else {
    echo "Error al guardar los datos en practicas: " . mysqli_error($conexion);
}

// Cerrar las conexiones
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmt2);
mysqli_close($conexion);
?>
