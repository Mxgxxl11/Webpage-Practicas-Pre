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
$nt = 0;

// Verificar si el código de usuario ya está registrado  
$verificarCodigo = mysqli_query($conexion, "SELECT * FROM usuario WHERE codigo = '$codigo'");  
if (mysqli_num_rows($verificarCodigo) == 0) {  
    echo '  
        <script>  
            alert("Código no encontrado en el sistema.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit();  
}  

if($base > (date("Y") - 4) && $estado === 'Estudiante'){
    echo '  
        <script>  
            alert("Debes ser de una base menor para poder continuar.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit(); 
}

if($estado === 'Estudiante' && ($semestre === '' || $seccion === '')){
    echo '  
        <script>  
            alert("Si eres alumno debes seleccionar un semestre y una seccion para poder continuar.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit(); 
}

if($base > (date("Y") - 5) && $estado === 'Egresado'){
    echo '  
        <script>  
            alert("Debes ser de una base menor para ser egresado.");   
            window.location = "./../../carta_presentacion.php";
        </script>';  
    exit(); 
}

$verificarCodigo2 = mysqli_query($conexion, "SELECT * FROM alumno WHERE id_usuario = '$codigo'");   

// Obtener el id_rol basado en el código  
$result = mysqli_query($conexion, "SELECT id_rol FROM acceso WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_rol = $row['id_rol']; // Asegúrate de que el nombre de campo es correcto  

// Inserción en la tabla alumno  
$query = "INSERT INTO alumno (id_usuario, plan_curricular, base, semestre, seccion, estado, nt)   
          VALUES (?, ?, ?, ?, ?, ?, ?)";  

// Preparar la consulta  
$stmt = mysqli_prepare($conexion, $query);  
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
}  

$query2 = "UPDATE paso_cp SET paso = 2 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query2);

if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

// Establecer los tipos de datos y enlazar los parámetros  
mysqli_stmt_bind_param($stmt, "isssssi", $codigo, $planCurricular, $base, $semestre, $seccion, $estado, $nt);  

// Ejecutar la consulta  
$ejecutar = mysqli_stmt_execute($stmt);  
if (!$ejecutar2){
    echo '  
        <script>  
            alert("Datos del alumno ya almacenados."); 
        </script>';  
}

if ($ejecutar && $ejecutar2) {  
    // Inicia o reutiliza la sesión  
    session_start();  
    // Establece una sesión para mostrar el segundo div  
    $_SESSION['paso_cp'] = '2'; // Cambia esto según el div que desees mostrar  

    echo '  
        <script>  
            alert("Datos almacenados exitosamente.");  
            window.location = "./../../carta_presentacion.php";
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
