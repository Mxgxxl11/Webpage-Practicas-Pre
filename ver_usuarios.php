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
    <style>
        .my-form__button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: darkorange;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .my-form__button:hover {
            background-color: chocolate;
        }
    </style>
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
                    TODOS LOS USUARIOS REGISTRADOS
                </h2>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="codigo">Codigo</label>
                            <input type="number" id="codigo" name="codigo" autocomplete="off">
                        </td>
                        <td>
                            <label for="rol">Rol</label>
                            <input type="text" id="rol" name="rol" autocomplete="off">
                        </td>
                        <td>
                            <input class="my-form__button" type="submit" name="enviar" value="Buscar">
                        </td>
                        <td>
                            <div class="tags">
                                <div class="tag tag--marketing">
                                    <a href="ver_usuarios.php" style="text-decoration:none; color:black;">
                                        Mostrar todos los usuarios
                                    </a>
                                </div>

                        </td>
                    </tr>
                </table>
            </form>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>
                            Código
                        </th>
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
                    if (isset($_POST['enviar'])) {
                        //aca es para la busqueda
                        $codigo = $_POST['codigo'];
                        $rol = $_POST['rol'];
                        if (empty($codigo) and empty($rol)) { // si no funciona codigo cambiar a $_POST['codigo']
                            echo '<script>
                            alert("Ingresa algún dato para buscar");
                            window.location = "./ver_usuarios.php"; 
                            </script>';
                        } else {
                            if (empty($rol)) {
                                $busqueda = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion  
                                    FROM usuario u
                                    JOIN acceso a ON u.codigo = a.id_usuario
                                    JOIN roles r ON a.id_rol = r.id_rol
                                    WHERE u.codigo like '%" . $codigo . "%'";
                            }
                            if (empty($codigo)) {
                                $busqueda = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion  
                                FROM usuario u
                                JOIN acceso a ON u.codigo = a.id_usuario
                                JOIN roles r ON a.id_rol = r.id_rol
                                WHERE r.nombre_rol like '%" . $rol . "%'";
                            }
                            if (!empty($rol) and !empty($codigo)) {
                                $busqueda = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion  
                                FROM usuario u
                                JOIN acceso a ON u.codigo = a.id_usuario
                                JOIN roles r ON a.id_rol = r.id_rol
                                WHERE u.codigo like '%" . $codigo . "%' and r.nombre_rol like '%" . $rol . "%'";
                            }
                        }
                        $ejec = mysqli_query($conexion, $busqueda);
                        if ($ejec) {
                            while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                <tr>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['codigo'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?>
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
                                        <div class="profile-info" style="text-align:center;">
                                            <?php echo $filas['fecha_creacion']; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } else {
                        //aca para mostrar todos los registros
                        //esta consulta solo llamará a los admins (cambiar el a.id_rol a lo que quieras llamar)
                        $consulta = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion  
                                    FROM usuario u
                                    JOIN acceso a ON u.codigo = a.id_usuario
                                    JOIN roles r ON a.id_rol = r.id_rol";
                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                            <tr>
                                <td>
                                    <div class="profile-info">
                                        <?php echo $filas['codigo'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="profile-info">
                                        <?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?>
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
                                    <div class="profile-info" style="text-align:center;">
                                        <?php echo $filas['fecha_creacion']; ?>
                                    </div>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
            <?php mysqli_close($conexion) ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>