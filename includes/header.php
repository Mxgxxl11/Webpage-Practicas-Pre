<div style="display: flex; align-items: center">
    <button class="menu-btn" onclick="toggleMenu()">
        <img src="assets/images/sidebar.png" alt="logo_sidebar" style="width: 30px;">
    </button>
    <img src="assets/images/FIEI_LOGO-removebg-preview.png" alt="Logo" style="width: 130px;" />
    <h2 class="titulo-header">Mesa de partes Practicas Pre Profesionales</h2>

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