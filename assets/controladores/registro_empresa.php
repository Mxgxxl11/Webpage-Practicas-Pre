<?php  
include 'bd.php'; 
session_start();  

// Verifica que los datos del formulario estén presentes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_empresa = $_POST['nombre_empresa'];
    $ruc_empresa = $_POST['ruc_empresa'];
    $celular_repre = $_POST['celular_repre'];
    $email_repre = $_POST['email_repre'];
    $provincia_empre = $_POST['provincia_empre'];
    $distrito_empre = $_POST['distrito_empre'];
    $representante = $_POST['representante'];
    $dni_repre = $_POST['dni_repre'];
    $direccion_empre = $_POST['direccion_empre'];
    $departamento_empre = $_POST['departamento_empre'];

    // Preparar la consulta SQL para insertar los datos
    $query = "INSERT INTO empresa (nombre_empresa, ruc_empresa, celular_repre, email_repre, provincia_empre, distrito_empre, representante, dni_repre, direccion_empre, departamento_empre) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . mysqli_error($conexion));
    }

    // Enlazar los parámetros
    mysqli_stmt_bind_param($stmt, "ssssssssss", $nombre_empresa, $ruc_empresa, $celular_repre, $email_repre, $provincia_empre, $distrito_empre, $representante, $dni_repre, $direccion_empre, $departamento_empre);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo "Datos guardados exitosamente.";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }

}


mysqli_close($conexion);

?>