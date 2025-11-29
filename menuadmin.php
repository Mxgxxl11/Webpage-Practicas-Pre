<!-- MENU ADMINISTRADOR -->
<!-- Esta es la página principal del portal de ADMINISTRADORES-->
<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
  echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$nombre_completo = $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administradores - Prácticas Pre Profesionales</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/modern-theme.css" />
  <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>

<body>
  <header>
    <?php include './includes/header.php'; ?>
  </header>
  <div class="container" style="display: block;">
    <main class="main-content fade-in" style="max-width: 1400px; margin: 0 auto;">
      <!-- Card de Bienvenida -->
      <div class="card" style="padding: 1.5rem;">
        <h2 class="card-title" style="margin-bottom: 0.75rem;">👨‍💼 Bienvenido al Portal de Administración</h2>
        <div class="card-content">
          <p style="margin-bottom: 0.75rem; font-size: 0.95rem;">
            Aquí podrás gestionar de manera eficiente y organizada todas las actividades
            relacionadas con las prácticas, desde la asignación de tutores hasta el seguimiento
            de los avances de los estudiantes.
          </p>
          <div class="badge badge-warning">Panel de Control Administrativo</div>
        </div>
      </div>
      
      <!-- Grid de Administración -->
      <div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
        <a href="perfil_admin.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Mi Perfil</h3>
            <p class="info-card-description">
              Actualiza tu información personal y de contacto.
            </p>
          </div>
        </a>
        
        <a href="agregar_usuario.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Agregar Usuario</h3>
            <p class="info-card-description">
              Registra nuevos administradores o docentes en el sistema.
            </p>
          </div>
        </a>
        
        <a href="ver_usuarios.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Ver Usuarios</h3>
            <p class="info-card-description">
              Consulta y gestiona todos los usuarios del sistema.
            </p>
          </div>
        </a>
        
        <a href="carpeta_virtual.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Carpetas Virtuales</h3>
            <p class="info-card-description">
              Revisa y administra las carpetas de los estudiantes.
            </p>
          </div>
        </a>
        
        <a href="asignar_docente.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Asignar Docente</h3>
            <p class="info-card-description">
              Asigna docentes supervisores a los estudiantes.
            </p>
          </div>
        </a>
        
        <a href="notificaciones-admin.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Notificaciones</h3>
            <p class="info-card-description">
              Envía notificaciones a docentes y estudiantes.
            </p>
          </div>
        </a>
      </div>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>