<!-- NO SE SI ELIMINAREMOS ESTE MENU O NO. LO HABLAMOS EN EL SPRINT 6 -->
<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU SECRETARIA</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>
<body>
  <header>
    <?php include './includes/header.php'; ?>
  </header>
  <div class="container">
    <?php include './includes/sidebar-docente.php' ?>
    <main class="main-content">
      <div class="profile-form">
      <p style="text-align: justify;"><strong>¡Bienvenido al Portal de Docente de Prácticas Pre Profesionales!</strong></p>
      <p style="text-align: justify;">
      Este espacio está diseñado para facilitar la gestión y supervisión de los 
      tramistes de las prácticas pre profesionales de los estudiantes. 
      Aquí encontrarás todas las herramientas necesarias para asignar tutores, monitorear 
      el progreso de tus alumnos ademas de supervisar el avance de sus documentos
      </p>  
      </div>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
