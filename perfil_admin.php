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
    <div id="profileContainer">

<div class="profile-form">
    <h1 style="text-align:center;">Mi perfil</h1>
    <button id="image-button" type="button" onclick="openModal()">
        <img width="80" src="<?php echo $_SESSION['foto']; ?>" alt="foto_perfil_usuario">
    </button>
    <div class="profile-fields">

        <div>
            <label for="nombre">Apellidos y nombres:</label>
            <input type="text" id="nombre" value="<?php echo $nombre_completo; ?>" readonly />
        </div>
        <div>
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" value="<?php echo $_SESSION['codigo_institucional']; ?>" readonly />
        </div>
        <div>
            <label for="documento">Documento de identidad:</label>
            <input type="text" id="documento" value="<?php echo $_SESSION['documento']; ?>" readonly />
        </div>
        <div>
            <label for="email">Correo:</label>
            <input type="email" id="email" value="<?php echo $_SESSION['Correo_Institucional']; ?>" readonly />
        </div>
        <div>
            <label for="distrito">Distrito:</label>
            <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>" readonly />
        </div>
        <div>
            <label for="direccion">Direccion:</label>
            <input type="text" id="direccion" value="<?php echo $_SESSION['direccion']; ?>" readonly />
        </div>
        <div>
            <label for="phone">Celular:</label>
            <input type="number" id="phone" value="<?php echo $_SESSION['celular']; ?>" readonly />
        </div>
    </div>
    <div class="form-buttons">
        <button type="button" onclick="loadUpdateProfile()">
            Actualizar
        </button>
        <button type="button" onclick="backtoMenuAdmin()">
            Cerrar
        </button>
    </div>
</div>
<!-- Para la imagen del perfil-->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <form action="../assets/controladores/imagen_perfil.php" enctype="multipart/form-data" method="POST">
            <input type="file" name="foto">
            <div class="form-buttons">
                <button type="submit">Editar imagen perfil</button>
            </div>
        </form>
        <div class="form-buttons">
            <button onclick="closeModal()" class="close-btn">
                Cerrar
            </button>
        </div>
    </div>
</div>
</div>
<!-- Para actualizar el perfil-->
<div class="profile-form" id="update-fields-profile" style="display: none;">
<form action="/assets/controladores/actualizar_perfil.php" method="POST">
    <h1>Actualizando datos de mi perfil</h1>
    <div class="profile-fields">
        <div>
            <label for="email">Correo:</label>
            <input type="email" id="email" name="correo" value="<?php echo $_SESSION['Correo_Institucional']; ?>" />
        </div>
        <div class="entrada">
            <label for="distritos">Distrito:</label>
            <select name="distrito" id="distritos">
                <option value="" selected disabled><?php echo $_SESSION['distrito']; ?></option>
                <option value="ANCON">ANCON</option>
                <option value="ATE">ATE</option>
                <option value="BARRANCO">BARRANCO</option>
                <option value="BREÑA">BREÑA</option>
                <option value="CARABAYLLO">CARABAYLLO</option>
                <option value="CHACLACAYO">CHACLACAYO</option>
                <option value="CHORRILLOS">CHORRILLOS</option>
                <option value="CIENEGUILLA">CIENEGUILLA</option>
                <option value="COMAS">COMAS</option>
                <option value="EL AGUSTINO">EL AGUSTINO</option>
                <option value="INDEPENDENCIA">INDEPENDENCIA</option>
                <option value="JESUS MARIA">JESUS MARIA</option>
                <option value="LA MOLINA">LA MOLINA</option>
                <option value="LA VICTORIA">LA VICTORIA</option>
                <option value="LIMA">LIMA</option>
                <option value="LINCE">LINCE</option>
                <option value="LOS OLIVOS">LOS OLIVOS</option>
                <option value="LURIGANCHO">LURIGANCHO</option>
                <option value="LURIN">LURIN</option>
                <option value="MAGDALENA DEL MAR">MAGDALENA DEL MAR</option>
                <option value="MIRAFLORES">MIRAFLORES</option>
                <option value="PACHACAMAC">PACHACAMAC</option>
                <option value="PUCUSANA">PUCUSANA</option>
                <option value="PUEBLO LIBRE">PUEBLO LIBRE</option>
                <option value="PUENTE PIEDRA">PUENTE PIEDRA</option>
                <option value="PUNTA HERMOSA">PUNTA HERMOSA</option>
                <option value="PUNTA NEGRA">PUNTA NEGRA</option>
                <option value="RIMAC">RIMAC</option>
                <option value="SAN BARTOLO">SAN BARTOLO</option>
                <option value="SAN BORJA">SAN BORJA</option>
                <option value="SAN ISIDRO">SAN ISIDRO</option>
                <option value="SAN JUAN DE LURIGANCHO">
                    SAN JUAN DE LURIGANCHO
                </option>
                <option value="SAN JUAN DE MIRAFLORES">
                    SAN JUAN DE MIRAFLORES
                </option>
                <option value="SAN LUIS">SAN LUIS</option>
                <option value="SAN MARTIN DE PORRES">SAN MARTIN DE PORRES</option>
                <option value="SAN MIGUEL">SAN MIGUEL</option>
                <option value="SANTA ANITA">SANTA ANITA</option>
                <option value="SANTA MARIA DEL MAR">SANTA MARIA DEL MAR</option>
                <option value="SANTA ROSA">SANTA ROSA</option>
                <option value="SANTIAGO DE SURCO">SANTIAGO DE SURCO</option>
                <option value="SURQUILLO">SURQUILLO</option>
                <option value="VILLA EL SALVADOR">VILLA EL SALVADOR</option>
                <option value="VILLA MARIA DEL TRIUNFO">
                    VILLA MARIA DEL TRIUNFO
                </option>
            </select>
        </div>
        <div>
            <label for="direccion">Direccion:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $_SESSION['direccion']; ?>" />
        </div>
        <div>
            <label for="phone">Celular:</label>
            <input type="number" id="phone" name="celular" value="<?php echo $_SESSION['celular']; ?>" />
        </div>
        <div class="form-buttons">
            <input type="submit" name="enviar" value="Actualizar" style="background-color:black; color:white;">
        </div>
        <div class="form-buttons">
            <button class="close-btn">
                Cerrar
            </button>
        </div>
    </div>
</form>
</div>
    </main>
  </div>
  <script src="assets/js/mesadepartes.js"></script>
</body>

</html>