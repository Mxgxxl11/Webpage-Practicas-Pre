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
  <title>Mesa de partes</title>
  <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>

<body>
  <header>
    <?php include './includes/header.php'; ?>
  </header>
  <div class="container">
    <?php include './includes/sidebar.php'; ?>
    <main class="main-content">
      <div class="profile-form">
        <p>Bienvenido a nuestro portal para tramitar tus Prácticas Pre Profesionales</p>
        <p>
          Estamos aquí para facilitar tu proceso de inserción en el mundo laboral.
          Sabemos que las prácticas preprofesionales son una etapa crucial en tu
          formación académica y profesional, por eso, hemos creado este espacio
          especialmente para ti.
        </p>
        <p><strong>(apto para estudiantes de últimos ciclos)</strong></p>
        <!-- SOLO POR EL RATO -->
        <svg fill="#000000" viewBox="0 0 24 24" id="work" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <path id="secondary" d="M20.81,7.45,19,11.58A4,4,0,0,1,15.36,14H13v1H11V14H8.64A4,4,0,0,1,5,11.58L3.19,7.45A1,1,0,0,0,3,8V20a1,1,0,0,0,1,1H20a1,1,0,0,0,1-1V8A1,1,0,0,0,20.81,7.45Z" style="fill: #2ca9bc; stroke-width: 2;"></path>
            <path id="primary" d="M11,14H8.64A4,4,0,0,1,5,11.58L3.18,7.43A1,1,0,0,1,4,7H20a1,1,0,0,1,.82.43L19,11.58A4,4,0,0,1,15.36,14H13" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
            <path id="primary-2" data-name="primary" d="M16,7H8V4A1,1,0,0,1,9,3h6a1,1,0,0,1,1,1Zm5,13V8a1,1,0,0,0-1-1H4A1,1,0,0,0,3,8V20a1,1,0,0,0,1,1H20A1,1,0,0,0,21,20Zm-8-7H11v2h2Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
          </g>
        </svg>
      </div>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>