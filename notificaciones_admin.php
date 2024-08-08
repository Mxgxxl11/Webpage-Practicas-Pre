<!-- Esta pag muestra por el momento solo los admins que estan registrados en el sistema
sin embargo deberia mostrar las notificaciones de los estados de los tramites -->
<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
//esta consulta solo llamará a los admins (cambiar el a.id_rol a lo que quieras llamar)
$consulta = "SELECT a.id_usuario,r.nombre_rol,u.nombre1, u.correo,u.fecha_creacion  
FROM usuario u
JOIN acceso a ON u.codigo = a.id_usuario
JOIN roles r ON a.id_rol = r.id_rol
WHERE a.id_rol=1;";
$ejecucion = mysqli_query($conexion, $consulta);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <link rel="stylesheet" href="assets/css/detalles.css">
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-admin.php' ?>
        <article class="table-widget">
            <div class="caption">
                <h2>
                    Trayendo todos los usuarios
                </h2>
                <!--
                <button class="export-btn" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-export" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v5m-5 6h7m-3 -3l3 3l-3 3" />
                    </svg>
                    Export
                </button>-->
            </div>
            <table>
                <thead>
                    <tr>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Rol
                        </th>
                        <th>
                            Correo
                        </th>
                        <th>
                            Fecha de registro
                        </th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php

                    while ($filas = mysqli_fetch_assoc($ejecucion)) {
                    ?>
                        <tr>
                            <td>
                                <div class="profile-info">
                                    <?php echo $filas['nombre1'] ?>
                                </div>
                            </td>
                            <td>
                                <div class="profile-info">
                                    <?php echo $filas['nombre_rol'] ?>
                                </div>
                            </td>
                            <td>
                                <?php echo $filas['correo']; ?>
                            </td>
                            <td>
                                <div class="profile-info">
                                    <?php echo $filas['fecha_creacion']; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php mysqli_close($conexion) ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>