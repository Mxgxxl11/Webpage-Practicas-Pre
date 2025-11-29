<!-- MENU ESTUDIANTE-->
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mesa de Partes - Prácticas Pre Profesionales</title>
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
        <h2 class="card-title" style="margin-bottom: 0.75rem;">🎓 Bienvenido al Portal de Prácticas Pre Profesionales</h2>
        <div class="card-content">
          <p style="margin-bottom: 0.75rem; font-size: 0.95rem;">
            Estamos aquí para facilitar tu proceso de inserción en el mundo laboral.
            Sabemos que las prácticas preprofesionales son una etapa crucial en tu
            formación académica y profesional.
          </p>
          <div class="badge badge-warning">Apto para estudiantes de últimos ciclos</div>
        </div>
      </div>
      
      <!-- Grid de Información -->
      <div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
        <a href="ver_perfil.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Mi Perfil</h3>
            <p class="info-card-description">
              Actualiza tu información personal y académica.
            </p>
          </div>
        </a>
        
        <a href="tramites.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Trámites en Línea</h3>
            <p class="info-card-description">
              Realiza tus solicitudes de prácticas pre-profesionales.
            </p>
          </div>
        </a>
        
        <a href="constancia.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6zm9-7c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Constancias</h3>
            <p class="info-card-description">
              Solicita y descarga tu constancia de prácticas.
            </p>
          </div>
        </a>
        
        <a href="noti_docente.php" style="text-decoration: none;">
          <div class="info-card">
            <div class="info-card-icon">
              <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
              </svg>
            </div>
            <h3 class="info-card-title">Notificaciones</h3>
            <p class="info-card-description">
              Revisa las notificaciones de tu docente supervisor.
            </p>
          </div>
        </a>
      </div>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>