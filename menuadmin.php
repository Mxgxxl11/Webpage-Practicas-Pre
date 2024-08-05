<!-- MENU ADMINISTRADOR -->
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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administradores</title>
  <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>

<body>
  <header>
    <?php include './includes/header.php'; ?>
  </header>
  <div class="container">
    <?php include './includes/sidebar-admin.php' ?>
    <main class="main-content">
      <div class="profile-form">
        <p>Bienvenido a nuestro portal para administradores de las Practicas Pre Profesionales</p>
        <p>
          Esta pagina es de bienvenida. Después se corregirá.
        </p>
        <p><strong>SOLO PARA ADMINS</strong></p>
      </div>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>