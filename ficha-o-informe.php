<!-- modificado para hacer la conexion con la base de datos-->

<?php
session_start();
include './assets/controladores/bd.php';

if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
    exit();
}

// Obtener el código del alumno desde la URL o la sesión
$codigo_alumno = isset($_GET['codigo']) ? $_GET['codigo'] : '';

if (empty($codigo_alumno)) {
    echo '<script>
    alert("No se ha especificado el código del alumno.");
    window.history.back();
    </script>';
    exit();
}

// Consulta para obtener información del alumno
$query = "SELECT u.codigo, CONCAT(u.nombre1, ' ', u.apellido1) AS nombre_completo
          FROM usuario u
          JOIN alumno a ON u.codigo = a.id_usuario
          WHERE u.codigo = '$codigo_alumno'";
$result = mysqli_query($conexion, $query);

// Verificar si se encontró al alumno
if (mysqli_num_rows($result) == 0) {
    echo '<script>
    alert("No se encontró al alumno.");
    window.history.back();
    </script>';
    exit();
}

$filas = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buscar-alumno</title>
    <link rel="stylesheet" href="./assets/css/mesadepartes.css" />
    <link rel="stylesheet" href="./assets/css/menu_tramites.css">
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php'; ?>
        <main class="main-contents">

            <div class="responsive">
                <div class="gallery-docente">
                    <img src="./../assets/images/ficha.png" alt="logo-Ficha de evaluación del coordinador_">
                    <div class="desc">
                        <div class="ambos">
                            <p class="sexto_izquierdo" id="text3"><strong>Ficha de evaluación </strong></p>
                        </div>
                        <!-- Usa un enlace para redirigir -->
                        <a href="./ficha-evaluacion-alui.php?codigo=<?php echo $filas['codigo']; ?>"><button class="action-btn">Evaluar</button></a>
                    </div>
                </div>
            </div>

            <div class="responsive">
                <div class="gallery-docente">
                    <img src="./assets/images/informe.png" alt="logo-informe">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>Informe Final PPP</strong></p>
                        </div>

                        <a href="./informe-final-eva.php?codigo=<?php echo $filas['codigo']; ?>"><button class="action-btn">Evaluar</button></a>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>

<?php
mysqli_close($conexion);
?>
