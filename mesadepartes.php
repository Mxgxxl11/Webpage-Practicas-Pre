<!-- MENU ESTUDIANTE-->
<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
  echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}

$nombre_completo = $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mesa de partes FIEI P.P.P</title>
  <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>

<body>
  <header>
    <?php include './includes/header.php'; ?>
  </header>
  <div class="container">
    <?php include './includes/sidebar.php'; ?>
    <main class="main-content">
      <?php include './includes/bienvenida.php'; ?>
      <?php include './includes/mostrar_perfil.php'; ?>
      <?php include './includes/solicitud_carta_presentacion.php'; ?>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>
</html>