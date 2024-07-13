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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mesa de partes FIEI P.P.P</title>
  <link rel="stylesheet" href="assets/css/mesadepartes.css" />
</head>

<body>
  <header>
    <div style="display: flex; align-items: center">
      <button class="menu-btn" onclick="toggleMenu()">Ξ</button>
      <img src="assets/images/logo_unfv.jpg" alt="Logo" style="width: 130px; height: 70px; margin-right: 20px" />
      <h2>Mesa de partes FIEI P.P.P</h2>
    </div>
    <div>
      <a class="logout-btn" href="assets/controladores/cerrar_sesion.php">Cerrar Sesión</a>
    </div>
    <div>
      <p><?php echo $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido']; ?></p>
    </div>
  </header>
  <div class="container">
    <nav id="sidebar" class="sidebar">
      <a href="#" onclick="loadProfileForm()">MI PERFIL</a>
      <a href="#" onclick="loadSolicitudForm()">INICIAR SOLICITUD</a>
      <a href="#">REVISIÓN DE SOLICITUDES</a>
      <a href="#">NOTIFICACIONES</a>
      <a href="#">REPORTES</a>
      <a href="#">CARPETA VIRTUAL</a>
      <a href="#">CONSULTAS</a>
    </nav>
    <main class="main-content">
      <div id="profileContainer" style="display: none">
        <div class="profile-form">
          <button id="image-button" type="button" onclick="openModal()"></button>
          <div class="profile-fields">
            <div>
              <label for="name">Apellidos y nombres:</label>
              <input type="text" id="name" name="name" value="" />
              <div class="error-message" id="name-error"></div>
            </div>
            <div>
              <label for="codigo">Código:</label>
              <input type="text" id="codigo" name="codigo" value="" />
              <div class="error-message" id="codigo-error"></div>
            </div>
            <div>
              <label for="email">Correo:</label>
              <input type="email" id="email" name="email" value="" />
              <div class="error-message" id="email-error"></div>
            </div>
            <div>
              <label for="phone">Celular:</label>
              <input type="text" id="phone" name="phone" value="" />
              <div class="error-message" id="phone-error"></div>
            </div>
          </div>
          <div class="form-buttons">
            <button type="button" onclick="updateProfile()">
              Actualizar
            </button>
            <button type="button" onclick="closeProfileForm()">Cerrar</button>
          </div>
        </div>
      </div>
      <div id="solicitudContainer" style="display: none">
        <div class="profile-form">
          <div class="welcome-message">
            Bienvenido al inicio del proceso de solicitud
          </div>
          <div class="form-buttons">
            <button type="button" onclick="closeSolicitudForm()">
              Cerrar
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
  <div id="imageModal" class="modal">
    <div class="modal-content">
      <div id="preview-image" style="width: 100%; height: auto"></div>
      <img href="mesadepartes.html" src="image-button" alt="Img" height="100px">
      <button onclick="uploadImage()" class="form-buttons">
        Cargar imagen
      </button>
      <button onclick="removeImage()">Quitar imagen</button>
      <div class="form-buttons">
        <button onclick="closeModal()" class="close-btn">Cerrar</button>
        <button onclick="saveImage()">Guardar</button>
      </div>
    </div>
  </div>
  <div id="imageModal" class="modal">
    <div class="modal-content">
      <input type="file" id="fileInput" style="display: none" />
      <button onclick="openFileInput()" class="form-buttons">
        Cargar imagen
      </button>
      <button onclick="removeImage()">Quitar imagen</button>
      <button onclick="closeModal()" class="close-btn">Cerrar</button>
      <button onclick="saveImage()">Guardar</button>
      <div id="imagePreview" style="display: none">
        <img id="previewImage" src="#" alt="Vista previa de la imagen" />
      </div>
    </div>
  </div>

  <script src="assets/js/script.js"></script>
</body>

</html>