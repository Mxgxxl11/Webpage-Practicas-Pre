<?php

$rol = $_SESSION['id_rol'];
$menu_url = '';

// redirección en función del rol del usuario
if ($rol == 1) {
    $menu_url = './../../../menuadmin.php'; 
} elseif ($rol == 2) {
    $menu_url = './../../../menusecretaria.php';  
} else {
    $menu_url = './../../../mesadepartes.php';  
}
?>

<div style="display: flex; align-items: center">
   
    <button id="logosidebar" class="menu-btn" onclick="toggleMenu()">
        <img src="assets/images/sidebar.png" alt="logo_sidebar" style="width: 30px;">
    </button>
   
    <a href="<?php echo $menu_url; ?>">
        <img src="assets/images/FIEI_LOGO-removebg-preview.png" alt="Logo" style="width: 130px;" />
    </a>

    
    <h2 class="titulo-header">Bienvenido de nuevo <?php echo htmlspecialchars($_SESSION['primer_nombre']); ?>!</h2>
</div>

<div class="sidebar__profile">
    <div class="avatar__wrapper">
        
        <img class="avatar" src="<?php echo htmlspecialchars($_SESSION['foto']); ?>" alt="Foto_usuario">
    </div>
    <section class="avatar__name hide">
        
        <div class="user-name"><?php echo htmlspecialchars($_SESSION['primer_nombre']) . ' ' . htmlspecialchars($_SESSION['primer_apellido']); ?></div>
        <div class="email"><?php echo htmlspecialchars($_SESSION['Correo_Institucional']); ?></div>
    </section>
    <br>
</div>
