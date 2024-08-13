<?php
// Obtener el rol del usuario desde la sesión
$rol = $_SESSION['id_rol'];
?>

<div style="display: flex; align-items: center">
    <!-- Botón para alternar el menú -->
    <button id="logosidebar" class="menu-btn" onclick="toggleMenu()">
        <img src="assets/images/sidebar.png" alt="logo_sidebar" style="width: 30px;">
    </button>
    <!-- Enlace con el logo que cambia según el rol del usuario -->
    <a href="<?php 
        echo $rol == 1 ? './../../../menuadmin.php' : 
            ($rol == 2 ? './../../../menusecretaria.php' : './../../../mesadepartes.php'); 
    ?>">
        <img src="assets/images/FIEI_LOGO-removebg-preview.png" alt="Logo" style="width: 130px;" />
    </a>

    <!-- Mensaje de bienvenida -->
    <h2 class="titulo-header">Bienvenido de nuevo <?php echo htmlspecialchars($_SESSION['primer_nombre']); ?>!</h2>
</div>

<div class="sidebar__profile">
    <div class="avatar__wrapper">
        <!-- Foto de perfil del usuario -->
        <img class="avatar" src="<?php echo htmlspecialchars($_SESSION['foto']); ?>" alt="Foto_usuario">
    </div>
    <section class="avatar__name hide">
        <!-- Nombre completo del usuario y correo institucional -->
        <div class="user-name"><?php echo htmlspecialchars($_SESSION['primer_nombre']) . ' ' . htmlspecialchars($_SESSION['primer_apellido']); ?></div>
        <div class="email"><?php echo htmlspecialchars($_SESSION['Correo_Institucional']); ?></div>
    </section>
    <br>
</div>
