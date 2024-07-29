<div style="display: flex; align-items: center">
    <button class="menu-btn" onclick="toggleMenu()">Ξ</button>
    <img src="assets/images/logo_unfv.jpg" alt="Logo" style="width: 130px; height: 70px; margin-right: 20px" />
    <h2>Mesa de partes FIEI P.P.P</h2>
</div>
<div>
    <img width="80" src="<?php echo $_SESSION['foto']; ?>" alt="foto_perfil_usuario">
    <p><?php echo '(' . $_SESSION['codigo_institucional'] . ') ' . $nombre_completo; ?></p>
</div>
<div>
    <a href="assets/controladores/cerrar_sesion.php" class="logout-btn">Cerrar Sesión</a>
</div>