<?php  
include 'bd.php'; 
session_start();  

// Obtener los datos del formulario   
$codigo = $_POST['codigo'];  
$planCurricular = $_POST['p-curricular'];  
$base = $_POST['base'];  
$semestre = $_POST['semestre'];  
$seccion = $_POST['seccion'];  
$estado = $_POST['condicion']; 
$firma = $_FILES['firma']['tmp_name']; // Para subir la firma como imagen  

// Validar si el archivo de la firma fue subido  
if (is_uploaded_file($firma)) {  
    $firmaBlob = file_get_contents($firma); // Leer el contenido del archivo  
} else {  
    echo '  
        <script>  
            alert("Error al subir la firma."); 
        </script>';  
    exit();  
}  

// Verificar si el código de usuario ya está registrado  
$verificarCodigo = mysqli_query($conexion, "SELECT * FROM usuario WHERE codigo = '$codigo'");  
if (mysqli_num_rows($verificarCodigo) == 0) {  
    echo '  
        <script>  
            alert("Código no encontrado en el sistema.");   
        </script>';  
    exit();  
}  

// Obtener el id_rol basado en el código  
$result = mysqli_query($conexion, "SELECT id_rol FROM acceso WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_rol = $row['id_rol']; // Asegúrate de que el nombre de campo es correcto  

// Inserción en la tabla alumno  
$query = "INSERT INTO alumno (id_usuario, plan_curricular, base, semestre, seccion, estado, imagen_firma)   
          VALUES (?, ?, ?, ?, ?, ?, ?)";  

// Preparar la consulta  
$stmt = mysqli_prepare($conexion, $query);  
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
}  

// Establecer los tipos de datos y enlazar los parámetros  
mysqli_stmt_bind_param($stmt, "isssssb", $codigo, $planCurricular, $base, $semestre, $seccion, $estado, $firmaBlob);  

// Ejecutar la consulta  
$ejecutar = mysqli_stmt_execute($stmt);  

if ($ejecutar) {  
    echo '  
        <script>  
            alert("Datos almacenados exitosamente.");  
            window.location = "carta_presentación.php"; // Ajusta la redirección según sea necesario  
        </script>';  
} else {  
    echo '  
        <script>  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
        </script>';  
    echo "Error: " . mysqli_error($conexion);  
}  

mysqli_close($conexion);
?>