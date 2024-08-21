<?php
include 'assets/controladores/bd.php';
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$codigo = $_SESSION['codigo_institucional'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mesa de partes</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar.php'; ?>
        <main class="main-content">
            <div id="complete" class="container2">
                <h2>Descarga tu constancia</h2>
                <p>*Si le sale la notificación de archivo no encontrado es porque su constancia aún no esta disponible para su descarga</p>
                <input type="text" value="<?php echo $codigo; ?>" name="id_alumno" id="id_alumno" style="display: none;">
                <div class="form-buttons">
                    <button type="button" id="d_const" name="d_const" class="close-btn">Descargar Constancia</button>
                </div>
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
