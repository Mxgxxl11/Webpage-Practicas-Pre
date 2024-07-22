<!-- MENU ADMINISTRADOR -->
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
    <div>
      <p><?php echo '(' . $_SESSION['codigo_institucional'] . ') ' . $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido']; ?></p>
    </div>
    <div>
      <a href="assets/controladores/cerrar_sesion.php" class="logout-btn">Cerrar Sesión</a>
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
    </nav>
    <main class="main-content">
      <div id="profileContainer" style="display: none">
        <div class="profile-form">
          <button id="image-button" type="button" onclick="openModal()">Seleccionar Imagen</button>
          <div class="profile-fields">
            <div>
              <label for="name">Apellidos y nombres:</label>
              <echo input type="text" id="name" name="name" value="" /> 
              <div class="error-message" id="name-error"></div>
              <?php $nombreUsuario = $_SESSION['primer_nombre']; echo '<input type="text" value="' . htmlspecialchars($nombreUsuario) . '" readonly>'; ?>
            </div>
            <div>
              <label for="codigo">Código:</label>
              <echo input type="text" id="codigo" name="codigo" value="" />
              <div class="error-message" id="codigo-error"></div>
              <?php $codigo = $_SESSION['codigo_institucional']; echo '<input type="text" value="' . htmlspecialchars($codigo) . '" readonly>'; ?>
            </div>
            <div>
              <label for="email">Correo:</label>
              <echo input type="email" id="email" name="email" value="" />
              <div class="error-message" id="email-error"></div>
              <?php $email = $_SESSION['Correo_Institucional']; echo '<input type="text" value="' . htmlspecialchars($email) . '" readonly>'; ?>
            </div>
            <div>
              <label for="phone">Celular:</label>
              <echo input type="number" id="phone" name="phone" value="" />
              <div class="error-message" id="phone-error"></div>
              <?php $celular = $_SESSION['celular']; echo '<input type="number" value="' . htmlspecialchars($celular) . '">'; ?>
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
      <input type="file" id="fileInput" style="display: none" />
      <button onclick="openFileInput()" class="form-buttons">Cargar imagen</button>
      <button onclick="removeImage()">Quitar imagen</button>
      <div id="imagePreview" style="display: none">
        <img id="previewImage" src="#" alt="Vista previa de la imagen" />
      </div>
      <div class="form-buttons">
        <button onclick="closeModal()" class="close-btn">Cerrar</button>
        <button onclick="saveImage()">Guardar</button>
      </div>
    </div>
  </div>

  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
