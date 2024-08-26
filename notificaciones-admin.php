<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>  
    alert("Para continuar debe iniciar sesión");  
    window.location = "login.html";   
    </script>';
}
$codigo_admin = $_SESSION['codigo_institucional'];
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
        <?php include './includes/sidebar-admin.php'; ?>
        <article class="table-widget">
            <div class="caption">
                <h2>TODAS LAS NOTIFICACIONES</h2>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="codigo">Cód:</label>
                            <input type="number" id="codigo" name="codigo" autocomplete="off">
                        </td>
                        <td>
                            <label for="rol">Alumno:</label>
                            <input type="text" id="rol" name="alumno" autocomplete="off">
                        </td>
                        <td>
                            <input class="my-form__button" type="submit" name="enviar" value="Buscar">
                        </td>
                        <td>
                            <div class="tags">
                                <div class="tag tag--marketing">
                                    <a href="notificaciones-admin.php" style="text-decoration:none; color:black;">
                                        Mostrar todas las notf.
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre Alumno</th>
                        <th>Escuela</th>
                        <th>Mensaje</th>
                        <th>Fecha-Hora</th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                    if (isset($_POST['enviar'])) {
                        // Busqueda en notificaciones  
                        $codigo = $_POST['codigo'];
                        $alumno = $_POST['alumno'];
                        if (empty($codigo) && empty($alumno)) {
                            echo '<script>  
                        alert("Ingresa algún dato para buscar");  
                        window.location = "./notificaciones-admin.php";   
                        </script>';
                        } else {
                            if (empty($alumno)) {
                                $busqueda = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                                FROM notificaciones n   
                                JOIN usuario u ON u.codigo = n.id_usuario
                                JOIN escuelas e ON e.id_escuela = u.id_escuela  
                                WHERE n.id_usuario <> '$codigo_admin' AND u.codigo LIKE '%" . $codigo . "%'";
                            } else if (empty($codigo)) {
                                $busqueda = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                                FROM notificaciones n   
                                JOIN usuario u ON u.codigo = n.id_usuario
                                JOIN escuelas e ON e.id_escuela = u.id_escuela  
                                WHERE n.id_usuario <> '$codigo_admin' AND (u.nombre1 LIKE '%" . $alumno . "%'  
                                OR u.apellido1 LIKE '%" . $alumno . "%')";
                            } else {
                                $busqueda = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                                FROM notificaciones n   
                                JOIN usuario u ON u.codigo = n.id_usuario
                                JOIN escuelas e ON e.id_escuela = u.id_escuela
                                WHERE n.id_usuario <> '$codigo_admin' AND u.codigo LIKE '%" . $codigo . "%'
                                AND (u.nombre1 LIKE '%" . $alumno . "%'  
                                OR u.apellido1 LIKE '%" . $alumno . "%')";
                            }
                        }
                        $ejec = mysqli_query($conexion, $busqueda);
                        if ($ejec && mysqli_num_rows($ejec) > 0) {
                            while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                <tr>
                                    <td><?php echo $filas['codigo']; ?></td>
                                    <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                    <td><?php echo $filas['escuela']; ?></td>
                                    <td><?php echo $filas['mensaje']; ?></td>
                                    <td><?php echo $filas['fecha_notificacion']; ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo '<tr><td colspan="4">No se encontraron notificaciones.</td></tr>';
                        }
                    } else {
                        // Mostrar todas las notificaciones  
                        $consulta = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                    FROM notificaciones n   
                    JOIN usuario u ON u.codigo = n.id_usuario
                    JOIN escuelas e ON e.id_escuela = u.id_escuela  
                    WHERE n.id_usuario <> '$codigo_admin'";

                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                            <tr>
                                <td><?php echo $filas['codigo']; ?></td>
                                <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                <td><?php echo $filas['escuela']; ?></td>
                                <td><?php echo $filas['mensaje']; ?></td>
                                <td><?php echo $filas['fecha_notificacion']; ?></td>
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