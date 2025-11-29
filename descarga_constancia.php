<?php
include 'assets/controladores/bd.php';
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$codigo = $_SESSION['codigo_institucional'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Descargar Constancia - Prácticas Pre Profesionales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 800px; margin: 0 auto;">
            
            <div class="card" style="text-align: center; padding: 3rem 2rem;">
                <div style="font-size: 4rem; margin-bottom: 1.5rem;">📜</div>
                <h2 class="card-title" style="margin-bottom: 1rem;">Constancia de Prácticas</h2>
                <p style="color: #6c757d; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                    <strong>Nota:</strong> Si recibes una notificación de archivo no encontrado, es porque tu constancia aún no está disponible para descarga.
                </p>
                <input type="text" value="<?php echo $codigo; ?>" name="id_alumno" id="id_alumno" style="display: none;">
                <button type="button" id="d_const" name="d_const" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1rem;">
                    📥 Descargar Mi Constancia
                </button>
            </div>
        </main>
    </div>
    <script>
        $(document).ready(function() {  
        $('#d_const').click(function() {  
        // Obtener los valores de los inputs  
        var id_alumno = $('#id_alumno').val();  
        
        // Redirigir a la URL de descarga  
        window.location.href = 'assets/controladores/descargar_constancia.php?codigo_a=' + encodeURIComponent(id_alumno);  
        });  
        });
    </script>
</body>
</html>
