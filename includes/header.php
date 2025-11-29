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

<div style="display: flex; align-items: center; gap: 1rem;">
    <a href="<?php echo $menu_url; ?>">
        <img src="assets/images/FIEI_LOGO-removebg-preview.png" alt="Logo" style="width: 130px;" />
    </a>
    <h2 class="titulo-header">Bienvenido de nuevo <?php echo htmlspecialchars($_SESSION['primer_nombre']); ?>!</h2>
</div>

<div style="display: flex; align-items: center; gap: 1.5rem;">
    <div class="sidebar__profile" style="margin: 0; padding: 0; border: none;">
        <div class="avatar__wrapper">
            <img class="avatar" src="<?php echo htmlspecialchars($_SESSION['foto']); ?>" alt="Foto_usuario" style="width: 48px; height: 48px;">
        </div>
        <section class="avatar__name" style="display: flex; flex-direction: column;">
            <div class="user-name" style="font-size: 0.9rem;"><?php echo htmlspecialchars($_SESSION['primer_nombre']) . ' ' . htmlspecialchars($_SESSION['primer_apellido']); ?></div>
            <div class="email" style="font-size: 0.75rem;"><?php echo htmlspecialchars($_SESSION['Correo_Institucional']); ?></div>
        </section>
    </div>
    <a href="assets/controladores/cerrar_sesion.php" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">
        Cerrar Sesión
    </a>
</div>
