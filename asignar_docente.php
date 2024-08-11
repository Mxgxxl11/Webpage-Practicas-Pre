<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
//ESTE CODIGO ES PARA ASIGNAR UN DOCENTE DESDE EL PORTAL DE ADMINISTRADOR
//TOTALMENTE FUNCIONAL

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
                    ASIGNAR DOCENTE A ALUMNO
                </h2>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="codigo">Codigo alumno:</label>
                            <input type="number" id="codigo" name="codigo" autocomplete="off">
                        </td>
                        <td>
                            <label for="nombre">Nombre alumno o docente:</label>
                            <input type="text" id="nombre" name="nombre" autocomplete="off">
                        </td>
                        <td>
                            <input class="my-form__button" type="submit" name="enviar" value="Buscar">
                        </td>
                        <td>
                            <div class="tags">
                                <div class="tag tag--marketing">
                                    <a href="asignar_docente.php" style="text-decoration:none; color:black;">
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
                            Escuela
                        </th>
                        <th>
                            Seccion
                        </th>
                        <th>
                            id Docente
                        </th>
                        <th>
                            Docente Encargado
                        </th>
                        <th>
                            Acción
                        </th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                    if (isset($_POST['enviar'])) {
                        //aca es para la busqueda
                        $codigo = $_POST['codigo'];
                        $nombre = $_POST['nombre'];
                        if (empty($codigo) and empty($nombre)) { // si no funciona codigo cambiar a $_POST['codigo']
                            echo '<script>
                            alert("Ingresa algún dato para buscar");
                            window.location = "./asignar_docente.php"; 
                            </script>';
                        } else {
                            if (empty($nombre)) {
                                //si esta vacio la variable nombre entonces buscar por codigo
                                $busqueda = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                e.escuela, a.seccion, a.id_docente, 
                                (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                 FROM usuario us 
                                 JOIN docente dn ON dn.id_usuario = us.codigo 
                                 WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                 FROM usuario u 
                                 JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                 JOIN alumno a ON a.id_usuario = u.codigo 
                                 JOIN acceso ac ON ac.id_usuario = u.codigo 
                                WHERE u.codigo like '%" . $codigo . "%'";
                            }
                            if (empty($codigo)) {
                                //si esta vacio la variable codigo entonces buscar por nombre
                                $busqueda = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                e.escuela, a.seccion, a.id_docente, 
                                (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                 FROM usuario us 
                                 JOIN docente dn ON dn.id_usuario = us.codigo 
                                 WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                 FROM usuario u 
                                 JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                 JOIN alumno a ON a.id_usuario = u.codigo 
                                 JOIN acceso ac ON ac.id_usuario = u.codigo
                                 WHERE u.nombre1 LIKE '%" . $nombre . "%'
                                 OR u.nombre2 LIKE '%" . $nombre . "%'
                                 OR u.apellido1 LIKE '%" . $nombre . "%'
                                 OR u.apellido2 LIKE '%" . $nombre . "%'
                                 OR a.id_docente IN (SELECT dn.id_docente 
                                 FROM docente dn 
                                 JOIN usuario us ON us.codigo = dn.id_usuario
                                 WHERE us.nombre1 LIKE '%" . $nombre . "%' 
                                 OR us.apellido1 LIKE '%" . $nombre . "%');";
                            }
                            if (!empty($codigo) and !empty($nombre)) {
                                //para buscar tanto con la variable codigo como con la variable nombre
                                $busqueda = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                e.escuela, a.seccion, a.id_docente, 
                                (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                 FROM usuario us 
                                 JOIN docente dn ON dn.id_usuario = us.codigo 
                                 WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                 FROM usuario u 
                                 JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                 JOIN alumno a ON a.id_usuario = u.codigo 
                                 JOIN acceso ac ON ac.id_usuario = u.codigo
                                 WHERE u.codigo like '%" . $codigo . "%' and u.nombre1 LIKE '%" . $nombre . "%'
                                 OR u.nombre2 LIKE '%" . $nombre . "%'
                                 OR u.apellido1 LIKE '%" . $nombre . "%'
                                 OR u.apellido2 LIKE '%" . $nombre . "%'
                                 OR a.id_docente IN (SELECT dn.id_docente 
                                 FROM docente dn 
                                 JOIN usuario us ON us.codigo = dn.id_usuario
                                 WHERE us.nombre1 LIKE '%" . $nombre . "%' 
                                 OR us.apellido1 LIKE '%" . $nombre . "%');";
                            }
                        }
                        $ejec = mysqli_query($conexion, $busqueda);
                        if ($ejec) {
                            while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                <tr>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['CODIGO_ALUMNO'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['NOMBRE_ALUMNO']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['escuela'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $filas['seccion']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $filas['id_docente'] ?? 'No asignado';
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $filas['NOMBRE_DOCENTE'] ?? 'No asignado' ?>
                                    </td>
                                    <td>
                                        <div class="tags">
                                            <div class=' tag tag--marketing'>
                                                <?php
                                                // Redirigir a actualizar_docente.php si id_docente es null
                                                if (is_null($filas['id_docente'])) {
                                                    echo "<a style='text-decoration:none; color:red;' href='./actualizar_docente.php?CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>ASIGNAR DOCENTE</a>";
                                                } else {
                                                    echo "<a style='text-decoration:none; color:black;' href='./actualizar_docente.php?id_docente=" . $filas['id_docente'] . "&CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>ACTUALIZAR</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } else {
                        //ACA SE LLAMA CUANDO A TODOS LOS REGISTROS (CUANDO NO SE PRESIONO BUSCAR)

                        $consulta = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                        CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                        e.escuela, a.seccion, a.id_docente, 
                        (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                         FROM usuario us 
                         JOIN docente dn ON dn.id_usuario = us.codigo 
                         WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                         FROM usuario u 
                         JOIN escuelas e ON e.id_escuela = u.id_escuela 
                         JOIN alumno a ON a.id_usuario = u.codigo 
                         JOIN acceso ac ON ac.id_usuario = u.codigo 
                         WHERE ac.id_rol = 3";
                        $ejecucion = mysqli_query($conexion, $consulta);
                        if ($ejecucion) {
                            while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                                <tr>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['CODIGO_ALUMNO'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['NOMBRE_ALUMNO']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="profile-info">
                                            <?php echo $filas['escuela'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $filas['seccion']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $filas['id_docente'] ?? 'No asignado';
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $filas['NOMBRE_DOCENTE'] ?? 'No asignado' ?>
                                    </td>
                                    <td>
                                        <div class="tags">
                                            <div class=' tag tag--marketing'>
                                                <?php
                                                // Redirigir a actualizar_docente.php si id_docente es null
                                                if (is_null($filas['id_docente'])) {
                                                    echo "<a style='text-decoration:none; color:red;' href='./actualizar_docente.php?CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>ASIGNAR DOCENTE</a>";
                                                } else {
                                                    echo "<a style='text-decoration:none; color:black;' href='./actualizar_docente.php?id_docente=" . $filas['id_docente'] . "&CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>ACTUALIZAR</a>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                    <?php }
                        } else {
                            die('Error en la consulta: ' . mysqli_error($conexion));
                        }
                    } ?>
                </tbody>
            </table>
            <?php mysqli_close($conexion) ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>