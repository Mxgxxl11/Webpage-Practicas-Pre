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
  <title>Menu Principal</title>
  <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>

<body>
  <header>
    <div style="display: flex; align-items: center">
      <button class="menu-btn" onclick="toggleMenu()">Ξ</button>
      <img src="assets/images/logo_unfv.jpg" alt="Logo" style="width: 130px; height: 70px; margin-right: 20px" />
      <h2>Administracion</h2>
    </div>
    <div class="sidebar__profile">
      <div class="avatar__wrapper">
        <img class="avatar" src="<?php echo $_SESSION['foto']; ?>" alt="Foto_usuario">
      </div>
      <section class="avatar__name hide">
        <div class="user-name"><?php echo $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido']; ?></div>
        <div class="email"><?php echo $_SESSION['Correo_Institucional'] ?></div>
      </section>
      <br>
    </div>
  </header>
  <div class="container">
    <nav id="sidebar" class="sidebar">
      <a href="#" onclick="loadProfileForm()">ADMINISTRADOR</a>
      <a href="#" onclick="">AGREGAR USUARIO</a>
      <a href="#">REVISIÓN DE SOLICITUDES</a>
      <a href="#">NOTIFICACIONES</a>
      <a href="#">REPORTES</a>
      <a href="#">CARPETAS VIRTUALES</a>
      <a href="#">CONSULTAS</a>
      <a href="assets/controladores/cerrar_sesion.php" class="logout-btn">Cerrar Sesión</a>
    </nav>
    <main class="main-content">
      <?php include './includes/bienvenida.php'; ?>
      <?php include './includes/mostrar_perfil.php'; ?>
      <?php include './includes/solicitud_carta_presentacion.php'; ?>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>